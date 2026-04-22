@extends('layouts.dashboard')

@section('title', 'Paiement — ' . $reservation->reservation_number)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-10">

                <div class="text-center mb-4" data-aos="fade-up">
                    <h2 class="title_text" style="font-size:28px;">Finaliser le paiement</h2>
                    <p style="color:#888;font-size:14px;">Réservation <strong style="color:#0A0F1E;">{{ $reservation->reservation_number }}</strong></p>
                </div>

                {{-- Récapitulatif --}}
                <div data-aos="fade-up" data-aos-delay="100"
                     style="background:#F2F2F2;border-radius:6px;padding:28px 32px;margin-bottom:28px;">
                    <h4 style="font-size:17px;font-weight:700;color:#0A0F1E;border-bottom:2px solid #860000;padding-bottom:10px;margin-bottom:16px;">
                        Récapitulatif
                    </h4>
                    <table style="width:100%;font-size:14px;color:#555;">
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px 0;">Véhicule</td>
                            <td style="padding:8px 0;text-align:right;font-weight:700;color:#0A0F1E;">{{ $reservation->vehicle->name }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px 0;">Dates</td>
                            <td style="padding:8px 0;text-align:right;font-weight:600;color:#0A0F1E;">
                                {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px 0;">Durée</td>
                            <td style="padding:8px 0;text-align:right;font-weight:600;color:#0A0F1E;">{{ $reservation->days }} jour(s)</td>
                        </tr>
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px 0;">Type</td>
                            <td style="padding:8px 0;text-align:right;font-weight:600;color:#0A0F1E;">
                                {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
                            </td>
                        </tr>
                        @if($reservation->discount_amount > 0)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:8px 0;">Réduction ({{ $reservation->discount_percentage }}%)</td>
                            <td style="padding:8px 0;text-align:right;font-weight:600;color:#28a745;">
                                − {{ number_format($reservation->discount_amount) }} FCFA
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td style="padding:12px 0 0;font-size:16px;font-weight:700;color:#860000;">Total à payer</td>
                            <td style="padding:12px 0 0;text-align:right;font-size:18px;font-weight:800;color:#860000;">
                                {{ number_format($reservation->total) }} FCFA
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Messages d'erreur --}}
                @if(session('payment_error'))
                <div style="background:#fff0f0;border:1px solid #860000;border-radius:4px;padding:12px 16px;margin-bottom:20px;color:#860000;font-size:13px;">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('payment_error') }}
                </div>
                @endif

                {{-- Bouton paiement --}}
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <button id="pay_btn" class="custom_btn bg_default_red text-uppercase">
                        Payer {{ number_format($reservation->total) }} FCFA
                        <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
                    </button>
                    <p style="font-size:12px;color:#aaa;margin-top:12px;">
                        <i class="fas fa-shield-alt mr-1"></i> Paiement sécurisé via KKiaPay (MTN Mobile Money / Moov Money)
                    </p>
                </div>

                {{-- Formulaire de vérification (soumis via JS après succès KKiaPay) --}}
                <form id="verifyForm" action="{{ route('payment.verify', $reservation) }}" method="POST" style="display:none;">
                    @csrf
                    <input type="hidden" name="transaction_id" id="kkiapay_transaction_id">
                </form>

            </div>
        </div>
    </div>
</section>

{{-- KKiaPay SDK --}}
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
document.getElementById('pay_btn').addEventListener('click', function () {
    openKkiapayWidget({
        amount:   {{ (int) $reservation->total }},
        api_key:  "{{ config('kkiapay.public_key') }}",
        sandbox:  {{ config('kkiapay.sandbox') ? 'true' : 'false' }},
        phone:    "{{ preg_replace('/\D/', '', $reservation->phone) }}",
        name:     "{{ addslashes($reservation->user->name ?? '') }}",
        email:    "{{ $reservation->email }}",
        data:     "{{ $reservation->reservation_number }}",
    });
});

addSuccessListener(function (response) {
    document.getElementById('kkiapay_transaction_id').value = response.transactionId;
    document.getElementById('verifyForm').submit();
});

addFailedListener(function () {
    window.location.href = "{{ route('payment.failure', ['reservation_id' => $reservation->id]) }}";
});
</script>
@endsection
