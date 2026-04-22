@extends('layouts.dashboard')

@section('title', 'Réservation ' . $reservation->reservation_number)
@section('page_title', 'Détail réservation')

@push('styles')
<style>

    /* ── SHARED PANEL (same as dashboard) ─────────────────── */
    .db_panel {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .db_panel:last-child { margin-bottom: 0; }

    .db_panel_head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #F3F4F6;
        gap: 10px;
    }
    .db_panel_title {
        font-family: 'Sora', sans-serif;
        font-size: 14px; font-weight: 700; color: #111827;
        margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .db_panel_title i { color: #860000; font-size: 13px; }

    /* ── BADGE (same as dashboard) ────────────────────────── */
    .db_badge {
        display: inline-block; padding: 4px 11px; border-radius: 20px;
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap;
    }
    .db_badge.pending   { background: #FEF3C7; color: #92400E; }
    .db_badge.active    { background: #D1FAE5; color: #065F46; }
    .db_badge.completed { background: #F3F4F6; color: #374151; }
    .db_badge.cancelled { background: #FEE2E2; color: #991B1B; }

    /* ── BACK + HEADER ────────────────────────────────────── */
    .sd_back {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 700; color: #9CA3AF;
        text-decoration: none; text-transform: uppercase; letter-spacing: 0.4px;
        margin-bottom: 18px; transition: color 0.15s;
    }
    .sd_back:hover { color: #860000; text-decoration: none; }

    .sd_header { margin-bottom: 22px; }
    .sd_header h2 {
        font-family: 'Sora', sans-serif;
        font-size: 22px; font-weight: 800; color: #111827;
        margin: 0 0 5px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .sd_header p { font-size: 12px; color: #9CA3AF; margin: 0; }

    /* ── CONTENT GRID (same as dashboard) ─────────────────── */
    .sd_grid {
        display: grid;
        grid-template-columns: 1fr 310px;
        gap: 20px;
        align-items: start;
    }

    /* ── VEHICLE IMAGE PANEL ──────────────────────────────── */
    .sd_vehicle_img {
        position: relative;
        height: 210px;
        overflow: hidden;
    }
    .sd_vehicle_img img {
        width: 100%; height: 100%; object-fit: cover; display: block;
    }
    .sd_vehicle_img .sd_img_ph {
        width: 100%; height: 100%;
        background: #F3F4F6;
        display: flex; align-items: center; justify-content: center;
    }
    .sd_vehicle_img .sd_img_ph i { font-size: 48px; color: #D1D5DB; }
    .sd_vehicle_overlay {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0,12,33,0.82));
        padding: 28px 20px 16px;
    }
    .sd_vname {
        font-family: 'Sora', sans-serif;
        font-size: 18px; font-weight: 800; color: #fff;
        display: block; margin-bottom: 3px;
    }
    .sd_vinfo { font-size: 11px; color: rgba(255,255,255,0.65); }
    .sd_price_tag {
        position: absolute; top: 14px; right: 14px;
        background: #860000;
        color: #fff; font-family: 'Sora', sans-serif;
        font-size: 13px; font-weight: 700;
        padding: 5px 12px; border-radius: 20px;
        white-space: nowrap;
    }

    /* ── TABLE ROWS (same style as dashboard table) ────────── */
    .sd_table { width: 100%; border-collapse: collapse; }
    .sd_table tbody tr { transition: background 0.1s; }
    .sd_table tbody tr:hover { background: #FAFBFC; }
    .sd_table tbody td {
        padding: 12px 20px; font-size: 12px;
        border-bottom: 1px solid #F3F4F6; vertical-align: middle;
    }
    .sd_table tbody tr:last-child td { border-bottom: none; }
    .sd_label { color: #9CA3AF; font-weight: 600; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; width: 40%; }
    .sd_value { color: #111827; font-weight: 600; font-size: 13px; text-align: right; }
    .sd_value.big {
        font-family: 'Sora', sans-serif;
        font-size: 16px; font-weight: 800; color: #860000;
    }
    .sd_value.green { color: #065F46; }
    .sd_value.muted { color: #9CA3AF; }

    /* ── COUNTDOWN CARD ───────────────────────────────────── */
    .sd_countdown {
        background: #111827;
        border-radius: 12px;
        padding: 22px 20px;
        text-align: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .sd_countdown .sdc_label {
        font-size: 10px; font-weight: 700; color: #ffffff;
        text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 10px;
    }
    .sd_countdown .sdc_val {
        font-family: 'Sora', sans-serif;
        font-size: 30px; font-weight: 800; color: #860000;
        line-height: 1;
    }
    .sd_countdown .sdc_sub {
        font-size: 11px; color: #ffffff; margin-top: 6px;
    }

    /* Completed / cancelled status cards */
    .sd_status_card {
        border-radius: 12px; padding: 20px;
        text-align: center; margin-bottom: 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .sd_status_card.completed { background: #F3F4F6; }
    .sd_status_card.cancelled { background: #FEF2F2; }
    .sd_status_card.pending   { background: #FFFBEB; }
    .sd_status_icon {
        width: 44px; height: 44px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .completed .sd_status_icon { background: #E5E7EB; color: #374151; }
    .cancelled .sd_status_icon { background: #FEE2E2; color: #991B1B; }
    .pending   .sd_status_icon { background: #FEF3C7; color: #92400E; }
    .sd_status_text { text-align: left; }
    .sd_status_text strong {
        font-family: 'Sora', sans-serif;
        font-size: 13px; font-weight: 700; color: #111827; display: block; margin-bottom: 2px;
    }
    .sd_status_text span { font-size: 11px; color: #9CA3AF; }

    /* ── CLIENT ROW (same as db_res_item) ─────────────────── */
    .sd_info_row {
        display: flex; align-items: center; gap: 12px;
        padding: 13px 20px; border-bottom: 1px solid #F3F4F6;
        transition: background 0.1s;
    }
    .sd_info_row:last-child { border-bottom: none; }
    .sd_info_row:hover { background: #FAFBFC; }
    .sd_info_icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: #F3F4F6; color: #374151;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .sd_info_icon.green { background: #D1FAE5; color: #065F46; }
    .sd_info_lbl { font-size: 10px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
    .sd_info_val { font-size: 13px; font-weight: 600; color: #111827; margin-top: 1px; }

    /* ── ACTION BUTTONS ───────────────────────────────────── */
    .sd_action_btn {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 12px 16px;
        border-radius: 8px; border: none; cursor: pointer;
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.3px;
        text-decoration: none; transition: all 0.15s; margin-bottom: 8px;
    }
    .sd_action_btn:last-child { margin-bottom: 0; }

    /* Document button group (view + download side by side) */
    .sd_doc_group { display: flex; gap: 6px; margin-bottom: 8px; }
    .sd_doc_group .sd_action_btn { margin-bottom: 0; width: auto; }
    .sd_doc_group .sd_action_btn.grow { flex: 1; }
    .sd_doc_group .sd_action_btn.icon_only { flex-shrink: 0; padding: 12px 14px; }
    .sd_action_btn.dark    { background: #111827; color: #fff; }
    .sd_action_btn.dark:hover { background: #000C21; color: #fff; text-decoration: none; }
    .sd_action_btn.navy    { background: #374151; color: #fff; }
    .sd_action_btn.navy:hover { background: #111827; color: #fff; text-decoration: none; }
    .sd_action_btn.red     { background: #860000; color: #fff; }
    .sd_action_btn.red:hover { background: #c0001a; color: #fff; text-decoration: none; }
    .sd_action_btn.outline_red { background: transparent; color: #860000; border: 1.5px solid #860000; }
    .sd_action_btn.outline_red:hover { background: #860000; color: #fff; text-decoration: none; }
    .sd_action_btn.gray    { background: #F3F4F6; color: #374151; }
    .sd_action_btn.gray:hover { background: #E5E7EB; color: #111827; text-decoration: none; }

    /* ── CANCELLATION NOTICE ──────────────────────────────── */
    .sd_cancel_notice {
        background: #FEF2F2;
        border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .sd_cancel_notice i { color: #860000; margin-top: 2px; flex-shrink: 0; }
    .sd_cancel_notice p { font-size: 12px; color: #374151; margin: 0; line-height: 1.6; }

    /* ── MODAL ─────────────────────────────────────────────── */
    .db_modal .modal-content { border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .db_modal .modal-header { background: #111827; padding: 16px 22px; border: none; }
    .db_modal .modal-title { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700; color: #fff; }
    .db_modal .modal-header .btn-close { filter: invert(1); opacity: 0.7; }
    .db_modal .modal-body { padding: 22px; }
    .db_modal .modal-footer { padding: 14px 22px; border-top: 1px solid #F3F4F6; gap: 8px; }
    .db_modal_label { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 6px; display: block; }
    .db_modal input[type="date"], .db_modal textarea { width: 100%; padding: 10px 14px; border: 1.5px solid #E5E7EB; border-radius: 8px; font-family: 'Sora', sans-serif; font-size: 13px; color: #111827; background: #FAFBFC; outline: none; transition: border-color 0.15s; }
    .db_modal input:focus, .db_modal textarea:focus { border-color: #860000; background: #fff; }
    .db_modal_btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 8px; font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; border: none; cursor: pointer; transition: all 0.15s; }
    .db_modal_btn.secondary { background: #F3F4F6; color: #374151; }
    .db_modal_btn.secondary:hover { background: #E5E7EB; }
    .db_modal_btn.primary { background: #860000; color: #fff; }
    .db_modal_btn.primary:hover { background: #c0001a; }

    /* ── RESPONSIVE ───────────────────────────────────────── */
    @media (max-width: 1100px) {
        .sd_grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- Back link --}}
<a href="{{ route('reservations.index') }}" class="sd_back">
    <i class="fas fa-chevron-left"></i> Mes réservations
</a>

{{-- Page header --}}
<div class="sd_header">
    <h2>
        {{ $reservation->reservation_number }}
        <span class="db_badge {{ $reservation->status }}">{{ $reservation->status_label }}</span>
    </h2>
    <p>
        <i class="fas fa-calendar-alt" style="color:#860000;margin-right:4px;"></i>
        Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}
    </p>
</div>

{{-- Content grid --}}
<div class="sd_grid">

    {{-- ── LEFT COLUMN ──────────────────────────────────── --}}
    <div>

        {{-- Vehicle panel --}}
        <div class="db_panel">
            {{-- Photo --}}
            <div class="sd_vehicle_img">
                @if($reservation->vehicle && $reservation->vehicle->photo_url)
                    <img src="{{ $reservation->vehicle->photo_url }}" alt="{{ $reservation->vehicle->name }}">
                @else
                    <div class="sd_img_ph"><i class="fas fa-car"></i></div>
                @endif
                @if($reservation->vehicle)
                <div class="sd_vehicle_overlay">
                    <span class="sd_vname">{{ $reservation->vehicle->name }}</span>
                    <span class="sd_vinfo">
                        {{ $reservation->vehicle->brand ?? '' }}
                        {{ $reservation->vehicle->year ? '· ' . $reservation->vehicle->year : '' }}
                        {{ $reservation->vehicle->seats ? '· ' . $reservation->vehicle->seats . ' places' : '' }}
                        {{ $reservation->vehicle->fuel_type ? '· ' . ucfirst($reservation->vehicle->fuel_type) : '' }}
                    </span>
                </div>
                <span class="sd_price_tag">
                    @if($reservation->type === 'avec_chauffeur')
                        {{ number_format($reservation->vehicle->price_with_driver) }} FCFA/j
                    @else
                        {{ number_format($reservation->vehicle->price_without_driver) }} FCFA/j
                    @endif
                </span>
                @endif
            </div>
            {{-- Panel head --}}
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-car"></i>
                    {{ $reservation->vehicle->name ?? 'Véhicule' }}
                </h3>
                <span style="font-size:11px;color:#9CA3AF;">
                    {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
                </span>
            </div>
        </div>

        {{-- Dates & Details panel --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-calendar-alt"></i>
                    Détails de la location
                </h3>
            </div>
            <table class="sd_table">
                <tbody>
                    <tr>
                        <td class="sd_label">Date de début</td>
                        <td class="sd_value">
                            {{ $reservation->start_date->format('d/m/Y') }}
                            @if($reservation->departure_time)
                                <span style="color:#9CA3AF;font-size:11px;"> à {{ $reservation->departure_time }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="sd_label">Date de fin</td>
                        <td class="sd_value">
                            {{ $reservation->end_date->format('d/m/Y') }}
                            @if($reservation->return_time)
                                <span style="color:#9CA3AF;font-size:11px;"> à {{ $reservation->return_time }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="sd_label">Durée</td>
                        <td class="sd_value">
                            {{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sd_label">Type</td>
                        <td class="sd_value">
                            {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
                        </td>
                    </tr>
                    @if($reservation->zone)
                    <tr>
                        <td class="sd_label">Zone</td>
                        <td class="sd_value">{{ $reservation->zone->name }}</td>
                    </tr>
                    @endif
                    @if($reservation->current_position)
                    <tr>
                        <td class="sd_label">Prise en charge</td>
                        <td class="sd_value">{{ $reservation->current_position }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Financial panel --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-receipt"></i>
                    Récapitulatif financier
                </h3>
            </div>
            <table class="sd_table">
                <tbody>
                    <tr>
                        <td class="sd_label">Tarif journalier</td>
                        <td class="sd_value">
                            @if($reservation->type === 'avec_chauffeur')
                                {{ number_format($reservation->vehicle->price_with_driver ?? 0) }} FCFA/j
                            @else
                                {{ number_format($reservation->vehicle->price_without_driver ?? 0) }} FCFA/j
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="sd_label">Durée</td>
                        <td class="sd_value">{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</td>
                    </tr>
                    <tr>
                        <td class="sd_label">Sous-total</td>
                        <td class="sd_value">{{ number_format($reservation->subtotal) }} FCFA</td>
                    </tr>
                    @if($reservation->discount_percentage > 0)
                    <tr>
                        <td class="sd_label">Réduction ({{ $reservation->discount_percentage }}%)</td>
                        <td class="sd_value green">− {{ number_format($reservation->discount_amount) }} FCFA</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="sd_label" style="color:#111827;font-size:12px;font-weight:700;text-transform:none;letter-spacing:0;">Total payé</td>
                        <td class="sd_value big">{{ number_format($reservation->total) }} FCFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Extensions history --}}
        @if($reservation->extensions->isNotEmpty())
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-history"></i>
                    Historique des prolongations
                </h3>
                <span class="db_badge active">{{ $reservation->extensions->count() }} prolongation{{ $reservation->extensions->count() > 1 ? 's' : '' }}</span>
            </div>
            <table class="sd_table">
                <thead>
                    <tr style="background:#FAFBFC;">
                        <td class="sd_label" style="padding:10px 20px;">Date</td>
                        <td class="sd_label" style="padding:10px 20px;text-align:center;">Jours +</td>
                        <td class="sd_label" style="padding:10px 20px;text-align:center;">Statut</td>
                        <td class="sd_label" style="padding:10px 20px;text-align:right;">Montant</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservation->extensions as $ext)
                    <tr>
                        <td style="padding:12px 20px;font-size:12px;color:#111827;font-weight:600;border-bottom:1px solid #F3F4F6;">
                            → {{ $ext->new_end_date->format('d/m/Y') }}
                            @if($ext->new_return_time)
                                <span style="color:#9CA3AF;font-size:10px;"> à {{ $ext->new_return_time }}</span>
                            @endif
                        </td>
                        <td style="padding:12px 20px;font-size:13px;font-weight:700;color:#111827;text-align:center;border-bottom:1px solid #F3F4F6;">
                            +{{ $ext->days }}j
                        </td>
                        <td style="padding:12px 20px;text-align:center;border-bottom:1px solid #F3F4F6;">
                            @if($ext->status === 'paid')
                                <span class="db_badge active">Payée</span>
                            @else
                                <span class="db_badge pending">En attente</span>
                            @endif
                        </td>
                        <td style="padding:12px 20px;font-size:12px;font-weight:700;color:#860000;text-align:right;border-bottom:1px solid #F3F4F6;">
                            {{ number_format($ext->amount) }} FCFA
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Cancellation notice --}}
        @if($reservation->status === 'cancelled' && $reservation->cancellation_reason)
        <div class="sd_cancel_notice">
            <i class="fas fa-info-circle"></i>
            <p><strong>Raison de l'annulation :</strong> {{ $reservation->cancellation_reason }}</p>
        </div>
        @endif

    </div>
    {{-- ── END LEFT ──────────────────────────────────────── --}}


    {{-- ── RIGHT COLUMN ─────────────────────────────────── --}}
    <div>

        {{-- Status / Countdown card --}}
        @if($reservation->status === 'active')
            <div class="sd_countdown">
                <div class="sdc_label">Temps restant</div>
                <div class="sdc_val" id="countdown_value">—</div>
                <div class="sdc_sub">
                    Fin le {{ $reservation->end_date->format('d/m/Y') }}
                    @if($reservation->return_time) à {{ $reservation->return_time }} @endif
                </div>
            </div>
        @elseif($reservation->status === 'completed')
            <div class="sd_status_card completed">
                <div class="sd_status_icon"><i class="fas fa-check"></i></div>
                <div class="sd_status_text">
                    <strong>Location terminée</strong>
                    <span>Terminée le {{ $reservation->end_date->format('d/m/Y') }}</span>
                </div>
            </div>
        @elseif($reservation->status === 'cancelled')
            <div class="sd_status_card cancelled">
                <div class="sd_status_icon"><i class="fas fa-times"></i></div>
                <div class="sd_status_text">
                    <strong>Réservation annulée</strong>
                    <span>Cette réservation a été annulée</span>
                </div>
            </div>
        @elseif($reservation->status === 'pending')
            <div class="sd_status_card pending">
                <div class="sd_status_icon"><i class="fas fa-clock"></i></div>
                <div class="sd_status_text">
                    <strong>En attente</strong>
                    <span>Démarre le {{ $reservation->start_date->format('d/m/Y') }}</span>
                </div>
            </div>
        @endif

        {{-- Client info panel --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-user"></i>
                    Informations client
                </h3>
            </div>

            <div class="sd_info_row">
                <div class="sd_info_icon"><i class="fas fa-user"></i></div>
                <div>
                    <div class="sd_info_lbl">Nom</div>
                    <div class="sd_info_val">{{ $reservation->user->name ?? auth()->user()->name }}</div>
                </div>
            </div>
            <div class="sd_info_row">
                <div class="sd_info_icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="sd_info_lbl">Email</div>
                    <div class="sd_info_val">{{ $reservation->email }}</div>
                </div>
            </div>
            <div class="sd_info_row">
                <div class="sd_info_icon"><i class="fas fa-phone"></i></div>
                <div>
                    <div class="sd_info_lbl">Téléphone</div>
                    <div class="sd_info_val">{{ $reservation->phone }}</div>
                </div>
            </div>
            @if($reservation->paid_at)
            <div class="sd_info_row">
                <div class="sd_info_icon green"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="sd_info_lbl">Payé le</div>
                    <div class="sd_info_val" style="color:#065F46;">
                        {{ $reservation->paid_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Actions panel --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-bolt"></i>
                    Actions
                </h3>
            </div>
            <div style="padding:16px 20px;">

                @if($reservation->status !== 'pending')

                {{-- Contrat --}}
                <div class="sd_doc_group">
                    <a href="{{ route('reservations.contract', $reservation) }}"
                       target="_blank"
                       class="sd_action_btn dark grow">
                        <i class="fas fa-file-pdf"></i> Contrat
                    </a>
                    <a href="{{ route('reservations.contract', $reservation) }}?dl=1"
                       class="sd_action_btn dark icon_only" title="Télécharger">
                        <i class="fas fa-download"></i>
                    </a>
                </div>

                {{-- Reçu --}}
                <div class="sd_doc_group">
                    <a href="{{ route('reservations.receipt', $reservation) }}"
                       target="_blank"
                       class="sd_action_btn gray grow">
                        <i class="fas fa-receipt"></i> Reçu
                    </a>
                    <a href="{{ route('reservations.receipt', $reservation) }}?dl=1"
                       class="sd_action_btn gray icon_only" title="Télécharger">
                        <i class="fas fa-download"></i>
                    </a>
                </div>

                @endif

                @if($reservation->canBeExtended())
                    <a href="{{ route('reservations.extend.show', $reservation) }}"
                       class="sd_action_btn outline_red">
                        Prolonger la location
                    </a>
                @endif

                @if($reservation->canBeCancelled())
                @php
                    $waMessage = urlencode(
                        "Bonjour WidriveU, je souhaite procéder à l'annulation de ma réservation N° "
                        . $reservation->reservation_number
                        . ". Merci de bien vouloir traiter ma demande.\n— "
                        . auth()->user()->name
                    );
                    $waUrl = "https://wa.me/22994080808?text=" . $waMessage;
                @endphp
                <a href="{{ $waUrl }}"
                   target="_blank"
                   rel="noopener"
                   class="sd_action_btn outline_red"
                   onmouseover="this.style.opacity='0.85'"
                   onmouseout="this.style.opacity='1'">
                  
                    Demander l'annulation
                </a>
                @endif

                <a href="{{ route('reservations.index') }}" class="sd_action_btn outline_red">
                    Retour à la liste
                </a>
                <a href="{{ route('fleet') }}" class="sd_action_btn red">
                    <i class="fas fa-car"></i> Nouvelle réservation
                </a>

            </div>
        </div>

    </div>
    {{-- ── END RIGHT ─────────────────────────────────────── --}}

</div>




@endsection

@push('scripts')
<script>
$(function () {
    @if($reservation->status === 'active')
    var endDate = new Date("{{ $reservation->end_date->format('Y-m-d') }}T{{ $reservation->return_time ?? '18:00' }}");

    function tick() {
        var diff = endDate - new Date();
        var $val = $('#countdown_value');
        if (isNaN(endDate.getTime())) { $val.text('—'); return; }
        if (diff <= 0) {
            $val.css('color','#DC2626').text('Location expirée');
            return;
        }
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var p = [];
        if (d) p.push(d + 'j');
        if (h) p.push(h + 'h');
        if (m) p.push(m + 'min');
        if (!d) p.push(s + 's');
        $val.text(p.join(' '));
    }
    tick();
    setInterval(tick, 1000);
    @endif
});
</script>
@endpush
