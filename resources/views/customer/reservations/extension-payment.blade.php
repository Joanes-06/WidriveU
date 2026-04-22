@extends('layouts.dashboard')

@section('title', 'Paiement prolongation — ' . $extension->reservation->reservation_number)
@section('page_title', 'Paiement de la prolongation')

@push('styles')
<style>
    .pay_wrap { max-width: 560px; margin: 0 auto; }

    /* header card */
    .pay_header {
        background: #111827;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 16px;
    }
    .pay_header_icon {
        width: 50px; height: 50px; border-radius: 12px;
        background: rgba(234,0,30,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #860000; flex-shrink: 0;
    }
    .pay_header_title {
        font-family: 'Sora', sans-serif;
        font-size: 18px; font-weight: 800; color: #fff;
        margin-bottom: 3px;
    }
    .pay_header_sub { font-size: 12px; color: rgba(255,255,255,0.5); }

    /* panel */
    .pay_panel {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 16px;
    }
    .pay_panel_head {
        padding: 14px 22px;
        border-bottom: 1px solid #F3F4F6;
        font-family: 'Sora', sans-serif;
        font-size: 11px; font-weight: 700; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.8px;
    }

    /* rows */
    .pay_row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 22px; border-bottom: 1px solid #F9FAFB;
        font-size: 13px;
    }
    .pay_row:last-child { border-bottom: none; }
    .pay_row .lbl { color: #6B7280; }
    .pay_row .val { font-weight: 700; color: #111827; }
    .pay_row .val.green { color: #059669; }

    /* total */
    .pay_total {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 22px;
        background: #F5F6FA;
        border-top: 2px solid #111827;
    }
    .pay_total .lbl { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: #111827; text-transform: uppercase; letter-spacing: 0.3px; }
    .pay_total .val { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #860000; }

    /* button */
    .pay_btn_wrap { text-align: center; margin-top: 8px; }
    .pay_btn {
        display: inline-flex; align-items: center; gap: 10px;
        background: #860000; color: #fff;
        font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700;
        padding: 14px 36px; border-radius: 10px; border: none; cursor: pointer;
        text-transform: uppercase; letter-spacing: 0.3px;
        transition: opacity 0.15s;
    }
    .pay_btn:hover { opacity: 0.85; }
    .pay_secure { font-size: 11px; color: #9CA3AF; margin-top: 10px; }

    @if(session('payment_error'))
    .pay_error {
        background: #FEF2F2; border: 1px solid #FECACA;
        border-radius: 8px; padding: 12px 16px;
        font-size: 12px; color: #991B1B;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }
    @endif
</style>
@endpush

@section('content')

<div class="pay_wrap">

    {{-- Header ─────────────────────────────────────────── --}}
    <div class="pay_header">
        <div class="pay_header_icon"><i class="fas fa-calendar-plus"></i></div>
        <div>
            <div class="pay_header_title">Prolongation de location</div>
            <div class="pay_header_sub">{{ $extension->reservation->reservation_number }} · {{ $extension->reservation->vehicle->name ?? '' }}</div>
        </div>
    </div>

    {{-- Error ──────────────────────────────────────────── --}}
    @if(session('payment_error'))
    <div class="pay_error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('payment_error') }}
    </div>
    @endif

    {{-- Extension details ──────────────────────────────── --}}
    <div class="pay_panel">
        <div class="pay_panel_head">Détails de l'extension</div>

        <div class="pay_row">
            <span class="lbl">Ancienne date de fin</span>
            <span class="val">{{ $extension->reservation->end_date->subDays($extension->days)->format('d/m/Y') }}</span>
        </div>
        <div class="pay_row">
            <span class="lbl">Nouvelle date de fin</span>
            <span class="val">{{ $extension->new_end_date->format('d/m/Y') }}</span>
        </div>
        <div class="pay_row">
            <span class="lbl">Jours supplémentaires</span>
            <span class="val">{{ $extension->days }} jour{{ $extension->days > 1 ? 's' : '' }}</span>
        </div>
        <div class="pay_row">
            <span class="lbl">Sous-total</span>
            <span class="val">{{ number_format($extension->subtotal) }} FCFA</span>
        </div>
        @if($extension->discount_percentage > 0)
        <div class="pay_row">
            <span class="lbl">Réduction ({{ $extension->discount_percentage }}%)</span>
            <span class="val green">− {{ number_format($extension->discount_amount) }} FCFA</span>
        </div>
        @endif

        <div class="pay_total">
            <span class="lbl">Total à payer</span>
            <span class="val">{{ number_format($extension->amount) }} FCFA</span>
        </div>
    </div>

    {{-- Pay button ─────────────────────────────────────── --}}
    <div class="pay_btn_wrap">
        <button id="pay_btn" class="pay_btn">
            <i class="fas fa-lock"></i>
            Payer {{ number_format($extension->amount) }} FCFA
        </button>
        <div class="pay_secure">
            <i class="fas fa-shield-alt"></i>
            Paiement sécurisé via KKiaPay (MTN / Moov Mobile Money)
        </div>
    </div>

    {{-- Hidden verify form ─────────────────────────────── --}}
    <form id="verifyForm" action="{{ route('extension.verify', $extension) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="transaction_id" id="kkiapay_transaction_id">
    </form>

</div>

<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
document.getElementById('pay_btn').addEventListener('click', function () {
    openKkiapayWidget({
        amount:  {{ (int) $extension->amount }},
        api_key: "{{ config('kkiapay.public_key') }}",
        sandbox: {{ config('kkiapay.sandbox') ? 'true' : 'false' }},
        phone:   "{{ preg_replace('/\D/', '', $extension->reservation->phone ?? '') }}",
        name:    "{{ addslashes($extension->reservation->user->name ?? '') }}",
        email:   "{{ $extension->reservation->email ?? '' }}",
        data:    "EXT-{{ $extension->id }}-{{ $extension->reservation->reservation_number }}",
    });
});

addSuccessListener(function (response) {
    document.getElementById('kkiapay_transaction_id').value = response.transactionId;
    document.getElementById('verifyForm').submit();
});

addFailedListener(function () {
    window.location.href = "{{ route('extension.failure', ['extension_id' => $extension->id]) }}";
});
</script>

@endsection
