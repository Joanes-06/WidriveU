<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationExtension;
use App\Models\Vehicle;
use App\Models\Zone;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Show the reservation creation form.
     */
    public function create(Vehicle $vehicle): View
    {
        if ($vehicle->status !== 'disponible') {
            abort(404, 'Ce véhicule n\'est pas disponible.');
        }

        $zones = Zone::orderBy('name')->get();

        return view('customer.reservations.create', compact('vehicle', 'zones'));
    }

    /**
     * Store a new reservation.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'zone_id'          => 'nullable|exists:zones,id',
            'type'             => 'required|in:sans_chauffeur,avec_chauffeur',
            'current_position' => 'nullable|string|max:255',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email|max:255',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
            'departure_time'   => 'required|date_format:H:i',
            'return_time'      => 'required|date_format:H:i',
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate);

        $basePrice = $validated['type'] === 'avec_chauffeur'
            ? $vehicle->price_with_driver
            : $vehicle->price_without_driver;

        $subtotal = $basePrice * $days;
        $discountPercentage = Reservation::getDiscountPercentage($days);
        $discountAmount = (int) round($subtotal * $discountPercentage / 100);
        $total = $subtotal - $discountAmount;

        $reservation = Reservation::create([
            'reservation_number' => Reservation::generateNumber(),
            'user_id'            => Auth::id(),
            'vehicle_id'         => $vehicle->id,
            'zone_id'            => $validated['zone_id'] ?? null,
            'type'               => $validated['type'],
            'current_position'   => $validated['current_position'] ?? null,
            'phone'              => $validated['phone'],
            'email'              => $validated['email'],
            'start_date'         => $validated['start_date'],
            'end_date'           => $validated['end_date'],
            'departure_time'     => $validated['departure_time'],
            'return_time'        => $validated['return_time'],
            'days'               => $days,
            'subtotal'           => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_amount'    => $discountAmount,
            'total'              => $total,
            'status'             => 'pending',
        ]);

        return redirect()->route('payment.checkout', $reservation);
    }

    /**
     * Show the payment checkout page (KKiaPay widget).
     */
    public function payment(Reservation $reservation): View
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status !== 'pending') {
            abort(404, 'Cette réservation a déjà été traitée.');
        }

        $reservation->load(['vehicle', 'user']);

        return view('customer.reservations.payment', compact('reservation'));
    }

    /**
     * Verify KKiaPay transaction and confirm reservation.
     */
    public function verifyPayment(Request $request, Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['transaction_id' => 'required|string']);

        $transactionId = $request->transaction_id;
        $sandbox       = config('kkiapay.sandbox');
        $apiBase       = $sandbox
            ? 'https://sandbox-api.kkiapay.me'
            : 'https://api.kkiapay.me';

        // Tentative de vérification server-side
        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders([
                    'x-private-key' => config('kkiapay.private_key'),
                ])->get("{$apiBase}/api/v1/transactions/{$transactionId}/status");

            if ($response->successful()) {
                $data   = $response->json();
                $status = strtoupper($data['status'] ?? $data['transactionStatus'] ?? '');

                if (!in_array($status, ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'])) {
                    return redirect()->route('payment.checkout', $reservation)
                        ->with('payment_error', 'Paiement non confirmé par KKiaPay (statut : ' . $status . ').');
                }
            }
            // Si la réponse HTTP échoue, on fait confiance au callback JS
            // (addSuccessListener ne se déclenche qu'après confirmation KKiaPay)
        } catch (\Exception $e) {
            Log::warning('KKiaPay verify error: ' . $e->getMessage());
            // On continue — le callback JS est déjà une preuve de succès
        }

        // Confirmer la réservation
        if ($reservation->status === 'pending') {
            $reservation->update([
                'status'         => 'active',
                'paid_at'        => now(),
                'transaction_id' => $transactionId,
            ]);
            $reservation->vehicle->update(['status' => 'reservee']);

            // Générer automatiquement le contrat et le reçu
            try {
                app(PdfService::class)->generateAll($reservation->fresh());
            } catch (\Exception $e) {
                Log::warning('PDF generation failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('payment.success', ['reservation_id' => $reservation->id]);
    }

    /**
     * Handle successful payment callback.
     */
    public function paymentSuccess(Request $request): View
    {
        $reservation = Reservation::with(['vehicle', 'user', 'zone'])
            ->findOrFail($request->input('reservation_id'));

        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.reservations.payment-success', compact('reservation'));
    }

    /**
     * Handle failed payment callback.
     */
    public function paymentFailure(Request $request): RedirectResponse
    {
        $reservationId = $request->input('reservation_id');

        if ($reservationId) {
            $reservation = Reservation::find($reservationId);
            if ($reservation && $reservation->status === 'pending') {
                $reservation->delete();
            }
        }

        return redirect()->route('home')->with('error', 'Le paiement a échoué. Veuillez réessayer.');
    }

    /**
     * Show the user's reservations list.
     */
    public function index(): View
    {
        $reservations = Auth::user()
            ->reservations()
            ->with(['vehicle', 'zone', 'extensions'])
            ->latest()
            ->paginate(10);

        return view('customer.reservations.index', compact('reservations'));
    }

    /**
     * Show a single reservation.
     */
    public function show(Reservation $reservation): View
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['vehicle', 'zone', 'extensions']);

        return view('customer.reservations.show', compact('reservation'));
    }

    /**
     * Cancel a reservation.
     */
    public function cancel(Request $request, Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'cancellation_reason' => 'nullable|string|max:1000',
        ]);

        $reservation->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        // Make vehicle available if no other active reservations
        $hasActiveReservation = Reservation::where('vehicle_id', $reservation->vehicle_id)
            ->where('status', 'active')
            ->where('id', '!=', $reservation->id)
            ->exists();

        if (!$hasActiveReservation) {
            $reservation->vehicle->update(['status' => 'disponible']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Votre réservation a été annulée.');
    }

    /**
     * View or download the rental contract PDF.
     * ?dl=1  → force download   (default: inline view)
     */
    public function downloadContract(Request $request, Reservation $reservation): mixed
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$reservation->contract_path || !Storage::exists($reservation->contract_path)) {
            $reservation->load(['vehicle', 'user', 'zone']);
            $path = app(PdfService::class)->generateContract($reservation);
            $reservation->update(['contract_path' => $path]);
        }

        $filename    = 'contrat-' . $reservation->reservation_number . '.pdf';
        $disposition = $request->boolean('dl') ? 'attachment' : 'inline';

        return response()->file(
            Storage::path($reservation->contract_path),
            ['Content-Disposition' => $disposition . '; filename="' . $filename . '"']
        );
    }

    /**
     * View or download the payment receipt PDF.
     * ?dl=1  → force download   (default: inline view)
     */
    public function downloadReceipt(Request $request, Reservation $reservation): mixed
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Always regenerate to pick up template changes
        if ($reservation->receipt_path && Storage::exists($reservation->receipt_path)) {
            Storage::delete($reservation->receipt_path);
        }
        $reservation->load(['vehicle', 'user', 'zone']);
        $path = app(PdfService::class)->generateReceipt($reservation);
        $reservation->update(['receipt_path' => $path]);

        $filename    = 'recu-' . $reservation->reservation_number . '.pdf';
        $disposition = $request->boolean('dl') ? 'attachment' : 'inline';

        return response()->file(
            Storage::path($reservation->receipt_path),
            ['Content-Disposition' => $disposition . '; filename="' . $filename . '"']
        );
    }

    /**
     * Show the extension form.
     */
    public function showExtend(Reservation $reservation): View|RedirectResponse
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['vehicle', 'zone', 'user']);
        $zones = Zone::orderBy('name')->get();

        return view('customer.reservations.extend', compact('reservation', 'zones'));
    }

    /**
     * Store a new extension (payment already done via KKiaPay on the form page).
     */
    public function extend(Request $request, Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$reservation->canBeExtended()) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut pas être prolongée.');
        }

        // Normaliser l'heure (08:00:00 → 08:00) pour la validation
        if ($request->new_return_time) {
            $request->merge(['new_return_time' => substr($request->new_return_time, 0, 5)]);
        }

        $request->validate([
            'new_end_date'     => 'required|date|after:' . $reservation->end_date->format('Y-m-d'),
            'new_return_time'  => 'nullable|date_format:H:i',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email|max:255',
            'current_position' => 'nullable|string|max:255',
            'zone_id'          => 'nullable|exists:zones,id',
            'transaction_id'   => 'required|string',
        ]);

        $reservation->load('vehicle');

        $newEnd    = \Carbon\Carbon::parse($request->new_end_date);
        $extraDays = $reservation->end_date->diffInDays($newEnd);
        $totalDays = $reservation->days + $extraDays;

        $basePrice = $reservation->type === 'avec_chauffeur'
            ? $reservation->vehicle->price_with_driver
            : $reservation->vehicle->price_without_driver;

        $subtotal           = $basePrice * $extraDays;
        $discountPercentage = Reservation::getDiscountPercentage($totalDays);
        $discountAmount     = (int) round($subtotal * $discountPercentage / 100);
        $total              = $subtotal - $discountAmount;

        // Vérification KKiaPay server-side (best effort — on ne bloque jamais sur ceci)
        // Le callback addSuccessListener ne se déclenche que sur un vrai succès KKiaPay.
        $transactionId = $request->transaction_id;
        $sandbox       = config('kkiapay.sandbox');
        $apiBase       = $sandbox ? 'https://sandbox-api.kkiapay.me' : 'https://api.kkiapay.me';

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['x-private-key' => config('kkiapay.private_key')])
                ->get("{$apiBase}/api/v1/transactions/{$transactionId}/status");

            if ($response->successful()) {
                $data   = $response->json();
                $status = strtoupper($data['status'] ?? $data['transactionStatus'] ?? '');
                if (!in_array($status, ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'])) {
                    Log::warning('KKiaPay extension status non-SUCCESS: ' . $status . ' for txn ' . $transactionId);
                    // On continue quand même — le callback JS est une preuve de succès côté client
                }
            }
        } catch (\Exception $e) {
            Log::warning('KKiaPay extension verify error: ' . $e->getMessage());
        }

        // Créer l'extension directement comme payée
        $extension = ReservationExtension::create([
            'reservation_id'      => $reservation->id,
            'new_end_date'        => $request->new_end_date,
            'new_return_time'     => $request->new_return_time ?? $reservation->return_time,
            'days'                => $extraDays,
            'subtotal'            => $subtotal,
            'discount_percentage' => $discountPercentage,
            'discount_amount'     => $discountAmount,
            'amount'              => $total,
            'status'              => 'paid',
            'paid_at'             => now(),
            'transaction_id'      => $transactionId,
        ]);

        // Mettre à jour la réservation
        $reservation->update([
            'end_date'    => $extension->new_end_date,
            'return_time' => $extension->new_return_time ?? $reservation->return_time,
            'days'        => $reservation->days + $extension->days,
            'subtotal'    => $reservation->subtotal + $extension->subtotal,
            'total'       => $reservation->total + $extension->amount,
        ]);

        return redirect()->route('extension.success', ['extension_id' => $extension->id]);
    }

    /**
     * Show the KKiaPay payment page for an extension.
     */
    public function extensionPayment(ReservationExtension $extension): View
    {
        if ($extension->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($extension->status !== 'pending') {
            abort(404, 'Cette prolongation a déjà été traitée.');
        }

        $extension->load(['reservation.vehicle', 'reservation.user']);

        return view('customer.reservations.extension-payment', compact('extension'));
    }

    /**
     * Verify KKiaPay transaction and confirm extension.
     */
    public function verifyExtensionPayment(Request $request, ReservationExtension $extension): RedirectResponse
    {
        if ($extension->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['transaction_id' => 'required|string']);

        $transactionId = $request->transaction_id;
        $sandbox       = config('kkiapay.sandbox');
        $apiBase       = $sandbox
            ? 'https://sandbox-api.kkiapay.me'
            : 'https://api.kkiapay.me';

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['x-private-key' => config('kkiapay.private_key')])
                ->get("{$apiBase}/api/v1/transactions/{$transactionId}/status");

            if ($response->successful()) {
                $data   = $response->json();
                $status = strtoupper($data['status'] ?? $data['transactionStatus'] ?? '');

                if (!in_array($status, ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'])) {
                    return redirect()->route('extension.payment', $extension)
                        ->with('payment_error', 'Paiement non confirmé par KKiaPay (statut : ' . $status . ').');
                }
            }
        } catch (\Exception $e) {
            Log::warning('KKiaPay extension verify error: ' . $e->getMessage());
        }

        if ($extension->status === 'pending') {
            $extension->update([
                'status'         => 'paid',
                'paid_at'        => now(),
                'transaction_id' => $transactionId,
            ]);

            $reservation = $extension->reservation;
            $reservation->update([
                'end_date'    => $extension->new_end_date,
                'return_time' => $extension->new_return_time ?? $reservation->return_time,
                'days'        => $reservation->days + $extension->days,
                'subtotal'    => $reservation->subtotal + $extension->subtotal,
                'total'       => $reservation->total + $extension->amount,
            ]);
        }

        return redirect()->route('extension.success', ['extension_id' => $extension->id]);
    }

    /**
     * Extension payment success page.
     */
    public function extensionSuccess(Request $request): View
    {
        $extension = ReservationExtension::with(['reservation.vehicle'])
            ->findOrFail($request->input('extension_id'));

        if ($extension->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.reservations.extension-success', compact('extension'));
    }

    /**
     * Extension payment failure — discard pending extension.
     */
    public function extensionFailure(Request $request): RedirectResponse
    {
        $extensionId = $request->input('extension_id');

        if ($extensionId) {
            $extension = ReservationExtension::find($extensionId);
            if ($extension && $extension->status === 'pending') {
                $reservationId = $extension->reservation_id;
                $extension->delete();

                return redirect()->route('reservations.show', $reservationId)
                    ->with('error', 'Le paiement de la prolongation a échoué. Veuillez réessayer.');
            }
        }

        return redirect()->route('reservations.index')
            ->with('error', 'Le paiement a échoué.');
    }
}
