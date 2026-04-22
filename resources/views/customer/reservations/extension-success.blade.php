@extends('layouts.dashboard')

@section('title', 'Prolongation confirmée')
@section('page_title', 'Prolongation confirmée')

@section('content')
<div style="max-width:520px;margin:0 auto;text-align:center;padding-top:20px;">

    {{-- Icon ──────────────────────────────────────────── --}}
    <div style="width:72px;height:72px;border-radius:50%;background:#D1FAE5;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;color:#059669;">
        <i class="fas fa-check"></i>
    </div>

    {{-- Title ─────────────────────────────────────────── --}}
    <h2 style="font-family:'Sora',sans-serif;font-size:22px;font-weight:800;color:#111827;margin-bottom:8px;">
        Prolongation confirmée !
    </h2>
    <p style="font-size:13px;color:#6B7280;margin-bottom:28px;">
        Votre location a bien été prolongée. Le paiement de
        <strong style="color:#111827;">{{ number_format($extension->amount) }} FCFA</strong>
        a été enregistré.
    </p>

    {{-- Summary card ───────────────────────────────────── --}}
    <div style="background:#fff;border-radius:14px;box-shadow:0 1px 2px rgba(0,0,0,0.04),0 4px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:24px;text-align:left;">

        <div style="background:#111827;padding:14px 22px;">
            <div style="font-family:'Sora',sans-serif;font-size:13px;font-weight:700;color:#fff;">
                {{ $extension->reservation->reservation_number }}
            </div>
            <div style="font-size:11px;color:rgba(255,255,255,0.5);margin-top:2px;">
                {{ $extension->reservation->vehicle->name ?? '' }}
            </div>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 22px;border-bottom:1px solid #F3F4F6;font-size:13px;">
            <span style="color:#6B7280;">Nouvelle date de fin</span>
            <strong style="color:#111827;">{{ $extension->new_end_date->format('d/m/Y') }}</strong>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 22px;border-bottom:1px solid #F3F4F6;font-size:13px;">
            <span style="color:#6B7280;">Jours ajoutés</span>
            <strong style="color:#111827;">+ {{ $extension->days }} jour{{ $extension->days > 1 ? 's' : '' }}</strong>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 22px;font-size:13px;">
            <span style="color:#6B7280;">Montant payé</span>
            <strong style="color:#860000;font-family:'Sora',sans-serif;font-size:16px;">{{ number_format($extension->amount) }} FCFA</strong>
        </div>
    </div>

    {{-- CTA ────────────────────────────────────────────── --}}
    <a href="{{ route('reservations.show', $extension->reservation_id) }}"
       style="display:inline-flex;align-items:center;gap:8px;background:#860000;color:#fff;font-family:'Sora',sans-serif;font-size:13px;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;text-transform:uppercase;letter-spacing:0.3px;">
        <i class="fas fa-eye"></i> Voir ma réservation
    </a>

</div>
@endsection
