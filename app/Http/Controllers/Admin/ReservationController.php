<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Show form to create a reservation for a client.
     */
    public function create(Request $request): View
    {
        $vehicles = Vehicle::where('status', 'disponible')->orderBy('name')->get();
        $clients  = User::where('role', 'client')->orderBy('name')->get();
        $zones    = Zone::orderBy('name')->get();

        // Pre-select vehicle if passed via query string
        $selectedVehicle = $request->filled('vehicle_id')
            ? Vehicle::find($request->vehicle_id)
            : null;

        return view('admin.reservations.create', compact('vehicles', 'clients', 'zones', 'selectedVehicle'));
    }

    /**
     * Store a reservation created by the admin for a client.
     */
    public function store(Request $request): RedirectResponse
    {
        $mode = $request->input('client_mode', 'existing');

        // Common validation rules
        $rules = [
            'vehicle_id'       => 'required|exists:vehicles,id',
            'zone_id'          => 'nullable|exists:zones,id',
            'type'             => 'required|in:sans_chauffeur,avec_chauffeur',
            'start_date'       => 'required|date|after_or_equal:today',
            'end_date'         => 'required|date|after:start_date',
            'departure_time'   => 'nullable|string|max:10',
            'return_time'      => 'nullable|string|max:10',
            'current_position' => 'nullable|string|max:255',
        ];

        if ($mode === 'existing') {
            $rules['user_id'] = 'required|exists:users,id';
        } else {
            $rules['walkin_firstname'] = 'required|string|max:100';
            $rules['walkin_lastname']  = 'required|string|max:100';
            $rules['walkin_phone']     = 'required|string|max:30';
            $rules['walkin_email']     = 'nullable|email|max:255';
            $rules['walkin_address']   = 'nullable|string|max:255';
            $rules['walkin_password']  = 'required|string|min:6|max:50';
        }

        $validated = $request->validate($rules);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        // Resolve or create the user
        if ($mode === 'existing') {
            $user = User::findOrFail($validated['user_id']);
            $phone = $request->existing_phone ?: $user->phone;
            $email = $request->existing_email ?: $user->email;
        } else {
            $fullName = trim($request->walkin_firstname . ' ' . $request->walkin_lastname);
            $email    = $request->walkin_email ?: null;

            // Reuse existing account if email matches, otherwise create
            $walkinPassword = $request->walkin_password;

            $user = $email ? User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $fullName,
                    'phone'    => $request->walkin_phone,
                    'address'  => $request->walkin_address,
                    'role'     => 'client',
                    'password' => bcrypt($walkinPassword),
                ]
            ) : User::create([
                'name'     => $fullName,
                'email'    => 'presentiel_' . time() . '@widriveu.local',
                'phone'    => $request->walkin_phone,
                'address'  => $request->walkin_address,
                'role'     => 'client',
                'password' => bcrypt($walkinPassword),
            ]);

            // Update name/phone if user already existed
            if ($user->wasRecentlyCreated === false && $email) {
                $user->update([
                    'name'  => $user->name ?: $fullName,
                    'phone' => $user->phone ?: $request->walkin_phone,
                ]);
            }

            $phone = $request->walkin_phone;
            $email = $user->email;
        }

        $start = \Carbon\Carbon::parse($validated['start_date']);
        $end   = \Carbon\Carbon::parse($validated['end_date']);
        $days  = $start->diffInDays($end);
        if ($days < 1) $days = 1;

        $basePrice = $validated['type'] === 'avec_chauffeur'
            ? $vehicle->price_with_driver
            : $vehicle->price_without_driver;

        $subtotal    = $basePrice * $days;
        $discountPct = \App\Models\Reservation::getDiscountPercentage($days);
        $discountAmt = (int) round($subtotal * $discountPct / 100);
        $total       = $subtotal - $discountAmt;

        $reservation = Reservation::create([
            'reservation_number'  => Reservation::generateNumber(),
            'user_id'             => $user->id,
            'vehicle_id'          => $vehicle->id,
            'zone_id'             => $validated['zone_id'] ?? null,
            'type'                => $validated['type'],
            'current_position'    => $validated['current_position'] ?? null,
            'phone'               => $phone,
            'email'               => $email,
            'start_date'          => $validated['start_date'],
            'end_date'            => $validated['end_date'],
            'departure_time'      => $validated['departure_time'] ?? null,
            'return_time'         => $validated['return_time'] ?? null,
            'days'                => $days,
            'subtotal'            => $subtotal,
            'discount_percentage' => $discountPct,
            'discount_amount'     => $discountAmt,
            'total'               => $total,
            'status'              => 'active',
            'paid_at'             => $request->boolean('paid') ? now() : null,
        ]);

        // Mark vehicle as reserved
        $vehicle->update(['status' => 'reservee']);

        $successMsg = "Réservation #{$reservation->reservation_number} créée avec succès pour {$user->name}.";

        // For walk-in clients, remind admin of credentials
        if ($mode !== 'existing') {
            $successMsg .= " Identifiants client — Email : {$user->email} / Mot de passe : {$request->walkin_password}";
            session()->flash('credentials', [
                'email'    => $user->email,
                'password' => $request->walkin_password,
                'name'     => $user->name,
            ]);
        }

        return redirect()->route('admin.reservations.show', $reservation)
            ->with('success', $successMsg);
    }

    /**
     * Show all reservations with filters.
     */
    public function index(Request $request): View
    {
        $query = Reservation::with(['user', 'vehicle', 'zone']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reservation_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('vehicle', fn($v) => $v->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $reservations = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show active reservations.
     */
    public function active(): View
    {
        $reservations = Reservation::with(['user', 'vehicle', 'zone', 'extensions'])
            ->where('status', 'active')
            ->latest()
            ->get();

        $expiringSoon = $reservations->filter(function ($r) {
            $endDt = $r->end_date->copy();
            if ($r->return_time) {
                $parts = explode(':', $r->return_time);
                $endDt->setTime((int) $parts[0], (int) ($parts[1] ?? 0));
            } else {
                $endDt->setTime(23, 59);
            }
            $hours = now()->diffInHours($endDt, false);
            return $hours >= 0 && $hours <= 48;
        })->count();

        $stats = [
            'count'         => $reservations->count(),
            'revenue'       => $reservations->sum('total'),
            'avg_days'      => $reservations->count() > 0 ? round($reservations->avg('days')) : '—',
            'expiring_soon' => $expiringSoon,
        ];

        return view('admin.reservations.active', compact('reservations', 'stats'));
    }

    /**
     * Show expired reservations.
     */
    public function expired(): View
    {
        $reservations = Reservation::with(['user', 'vehicle', 'zone'])
            ->where('status', 'active')
            ->where('end_date', '<', now()->toDateString())
            ->latest()
            ->get();

        return view('admin.reservations.expired', compact('reservations'));
    }

    /**
     * Show a single reservation with client history.
     */
    public function show(Reservation $reservation): View
    {
        $reservation->load(['user', 'vehicle', 'zone', 'extensions']);

        $clientHistory = Reservation::where('user_id', $reservation->user_id)
            ->where('id', '!=', $reservation->id)
            ->with('vehicle')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.reservations.show', compact('reservation', 'clientHistory'));
    }

    /**
     * Mark a reservation as completed.
     */
    public function complete(Reservation $reservation): RedirectResponse
    {
        $reservation->update(['status' => 'completed']);
        $reservation->vehicle->update(['status' => 'disponible']);

        return back()->with('success', 'Réservation marquée comme terminée.');
    }

    /**
     * Cancel a reservation.
     */
    public function cancel(Request $request, Reservation $reservation): RedirectResponse
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ]);

        $reservation->update([
            'status'              => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        $reservation->vehicle->update(['status' => 'disponible']);

        return back()->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Make the vehicle of a reservation available.
     */
    public function makeAvailable(Reservation $reservation): RedirectResponse
    {
        $reservation->vehicle->update(['status' => 'disponible']);

        return back()->with('success', 'Véhicule marqué comme disponible.');
    }
}
