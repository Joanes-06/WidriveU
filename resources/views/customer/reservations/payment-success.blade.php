@extends('layouts.dashboard')

@section('title', 'Paiement réussi — ' . $reservation->reservation_number)
@section('page_title', 'Paiement confirmé')

@push('styles')
<style>
    .success_wrapper {
        max-width: 600px;
        margin: 0 auto;
    }

    .success_hero {
        background: #fff;
        border-radius: 12px;
        padding: 40px 36px 32px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .success_icon_ring {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #D1FAE5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .success_icon_ring i {
        font-size: 36px;
        color: #065F46;
    }

    .success_hero h2 {
        font-family: 'Sora', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .success_hero p {
        font-size: 13px;
        color: #6B7280;
        margin: 0;
    }

    .success_num {
        display: inline-block;
        background: #F3F4F6;
        color: #374151;
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 20px;
        margin-top: 12px;
        letter-spacing: 0.5px;
    }

    .success_details {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .success_details_head {
        padding: 14px 22px;
        border-bottom: 1px solid #F3F4F6;
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #111827;
    }

    .success_row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 22px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 13px;
    }
    .success_row:last-child { border-bottom: none; }

    .success_row .sr_label { color: #6B7280; }
    .success_row .sr_value { font-weight: 600; color: #111827; }
    .success_row .sr_value.total {
        font-family: 'Sora', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #860000;
    }

    .success_actions {
        display: flex;
        gap: 12px;
    }

    .sa_btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 13px 16px;
        border-radius: 8px;
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        text-decoration: none;
        transition: all 0.18s;
    }

    .sa_btn.primary {
        background: #860000;
        color: #fff;
    }
    .sa_btn.primary:hover { background: #c0001a; color: #fff; text-decoration: none; }

    .sa_btn.secondary {
        background: #F3F4F6;
        color: #374151;
    }
    .sa_btn.secondary:hover { background: #E5E7EB; color: #111827; text-decoration: none; }
</style>
@endpush

@section('content')

<div class="success_wrapper">

    {{-- Hero --}}
    <div class="success_hero" data-aos="fade-up">
        <div class="success_icon_ring">
            <i class="fas fa-check"></i>
        </div>
        <h2>Paiement confirmé !</h2>
        <p>Votre réservation a été enregistrée avec succès.</p>
        <span class="success_num">{{ $reservation->reservation_number }}</span>
    </div>

    {{-- Details --}}
    <div class="success_details" data-aos="fade-up" data-aos-delay="80">
        <div class="success_details_head">
            <i class="fas fa-receipt" style="color:#860000;margin-right:6px;"></i>
            Récapitulatif de la réservation
        </div>

        <div class="success_row">
            <span class="sr_label">Véhicule</span>
            <span class="sr_value">{{ $reservation->vehicle->name }}</span>
        </div>
        <div class="success_row">
            <span class="sr_label">Période</span>
            <span class="sr_value">
                {{ $reservation->start_date->format('d/m/Y') }}
                &rarr;
                {{ $reservation->end_date->format('d/m/Y') }}
            </span>
        </div>
        <div class="success_row">
            <span class="sr_label">Durée</span>
            <span class="sr_value">{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</span>
        </div>
        <div class="success_row">
            <span class="sr_label">Type</span>
            <span class="sr_value">
                {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
            </span>
        </div>
        @if($reservation->zone)
        <div class="success_row">
            <span class="sr_label">Zone</span>
            <span class="sr_value">{{ $reservation->zone->name }}</span>
        </div>
        @endif
        @if($reservation->discount_amount > 0)
        <div class="success_row">
            <span class="sr_label">Réduction ({{ $reservation->discount_percentage }}%)</span>
            <span class="sr_value" style="color:#065F46;">− {{ number_format($reservation->discount_amount) }} FCFA</span>
        </div>
        @endif
        <div class="success_row">
            <span class="sr_label" style="font-weight:700;color:#111827;">Total payé</span>
            <span class="sr_value total">{{ number_format($reservation->total) }} FCFA</span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="success_actions" data-aos="fade-up" data-aos-delay="140">
        <a href="{{ route('reservations.show', $reservation) }}" class="sa_btn primary">
            <i class="fas fa-eye"></i> Voir la réservation
        </a>
        <a href="{{ route('dashboard') }}" class="sa_btn secondary">
            <i class="fas fa-th-large"></i> Tableau de bord
        </a>
    </div>

</div>

@endsection
