@extends('layouts.dashboard')

@section('title', 'Mes Réservations')
@section('page_title', 'Mes Réservations')

@push('styles')
<style>

    /* ── STAT CARDS (identical to dashboard) ──────────────── */
    .db_stats_row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .db_stat {
        background: #fff;
        border-radius: 12px;
        padding: 20px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .db_stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.06), 0 8px 24px rgba(0,0,0,0.07);
    }
    .db_stat_icon {
        width: 46px; height: 46px;
        border-radius: 10px;
        background: #000C21;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
    }
    .db_stat_icon.red  { background: #860000; }
    .db_stat_icon.gray { background: #374151; }
    .db_stat_val {
        font-family: 'Sora', sans-serif;
        font-size: 26px; font-weight: 700; color: #111827;
        line-height: 1; margin-bottom: 4px;
    }
    .db_stat_lbl {
        font-size: 11px; font-weight: 600; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    /* ── PANEL (identical to dashboard) ──────────────────── */
    .db_panel {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .db_panel_head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #F3F4F6;
        gap: 12px;
        flex-wrap: wrap;
    }
    .db_panel_title {
        font-family: 'Sora', sans-serif;
        font-size: 14px; font-weight: 700; color: #111827;
        margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .db_count_pill {
        background: #F3F4F6; color: #6B7280;
        font-size: 10px; font-weight: 700;
        padding: 2px 8px; border-radius: 20px;
    }
    .db_count_pill.green { background: #D1FAE5; color: #065F46; }
    .db_panel_more {
        font-size: 11px; font-weight: 700;
        color: #860000; text-decoration: none;
        text-transform: uppercase; letter-spacing: 0.4px;
        display: inline-flex; align-items: center; gap: 4px;
        transition: gap 0.15s; white-space: nowrap;
    }
    .db_panel_more:hover { gap: 8px; color: #860000; text-decoration: none; }

    /* ── FILTER TABS (inside panel header) ────────────────── */
    .rf_tabs {
        display: flex;
        gap: 3px;
        flex: 1;
        justify-content: center;
        flex-wrap: wrap;
    }
    .rf_tab {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        border: none; outline: none; background: transparent;
        font-family: 'Sora', sans-serif;
        font-size: 11px; font-weight: 700;
        color: #9CA3AF;
        cursor: pointer;
        transition: all 0.15s;
        text-transform: uppercase; letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .rf_tab:focus { outline: none; box-shadow: none; }
    .rf_tab:hover { color: #374151; background: #F3F4F6; }
    .rf_tab.is_active { background: #860000; color: #fff; }
    .rf_tab.is_active .db_count_pill { background: rgba(255,255,255,0.25); color: #fff; }

    /* ── TABLE (identical to dashboard) ──────────────────── */
    .db_table { width: 100%; border-collapse: collapse; }
    .db_table thead th {
        padding: 10px 18px;
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #9CA3AF; text-align: left;
        border-bottom: 1px solid #F3F4F6;
        background: #FAFBFC; white-space: nowrap;
    }
    .db_table tbody tr { transition: background 0.1s; }
    .db_table tbody tr:hover { background: #FAFBFC; }
    .db_table tbody td {
        padding: 13px 18px; font-size: 12px; color: #6B7280;
        border-bottom: 1px solid #F3F4F6; vertical-align: middle;
    }
    .db_table tbody tr:last-child td { border-bottom: none; }
    .tc_num  { font-family: 'Sora', sans-serif; font-weight: 700; color: #111827; font-size: 12px; }
    .tc_name { font-weight: 600; color: #374151; }
    .tc_amt  { font-family: 'Sora', sans-serif; font-weight: 700; color: #111827; white-space: nowrap; }

    /* Vehicle cell with thumbnail */
    .tc_vehicle { display: flex; align-items: center; gap: 10px; }
    .tc_thumb {
        width: 48px; height: 34px; border-radius: 6px;
        object-fit: cover; flex-shrink: 0; background: #F3F4F6;
    }
    .tc_thumb_ph {
        width: 48px; height: 34px; border-radius: 6px;
        background: #F3F4F6; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .tc_thumb_ph i { font-size: 12px; color: #D1D5DB; }

    /* ── BADGES (identical to dashboard) ─────────────────── */
    .db_badge {
        display: inline-block; padding: 3px 9px; border-radius: 20px;
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap;
    }
    .db_badge.pending   { background: #FEF3C7; color: #92400E; }
    .db_badge.active    { background: #D1FAE5; color: #065F46; }
    .db_badge.completed { background: #F3F4F6; color: #374151; }
    .db_badge.cancelled { background: #FEE2E2; color: #991B1B; }

    /* Countdown under badge */
    .tc_timer {
        display: block; margin-top: 3px;
        font-family: 'Sora', sans-serif;
        font-size: 10px; font-weight: 500; color: #860000;
        white-space: nowrap;
    }

    /* ── GO LINK (identical to dashboard) ────────────────── */
    .db_go {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; color: #860000;
        text-decoration: none; text-transform: uppercase; letter-spacing: 0.3px;
        transition: gap 0.15s;
    }
    .db_go:hover { gap: 8px; color: #860000; text-decoration: none; }

    /* Action icon buttons */
    .tc_actions { display: flex; align-items: center; gap: 4px; }
    .tc_icon_btn {
        width: 28px; height: 28px; border-radius: 6px; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; cursor: pointer; text-decoration: none;
        transition: all 0.15s; flex-shrink: 0;
    }
    .tc_icon_btn.dark  { background: #F3F4F6; color: #374151; }
    .tc_icon_btn.dark:hover  { background: #111827; color: #fff; text-decoration: none; }
    .tc_icon_btn.blue  { background: #F3F4F6; color: #374151; }
    .tc_icon_btn.blue:hover  { background: #111827; color: #fff; }
    .tc_icon_btn.red   { background: #FEF2F2; color: #DC2626; }
    .tc_icon_btn.red:hover   { background: #DC2626; color: #fff; }

    /* Discount tag */
    .tc_discount { font-size: 10px; color: #065F46; font-weight: 600; }

    /* ── EMPTY (identical to dashboard) ──────────────────── */
    .db_empty { text-align: center; padding: 48px 20px; }
    .db_empty i { font-size: 32px; color: #E5E7EB; margin-bottom: 10px; display: block; }
    .db_empty p { font-size: 12px; color: #9CA3AF; margin-bottom: 14px; }

    /* ── MODAL ────────────────────────────────────────────── */
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
    @media (max-width: 991px) {
        .db_stats_row { grid-template-columns: repeat(2, 1fr); }
        .rf_tabs { justify-content: flex-start; }
    }
    @media (max-width: 575px) {
        .db_stats_row { grid-template-columns: 1fr 1fr; gap: 10px; }
        .db_stat_val  { font-size: 22px; }
        .db_table thead th:nth-child(4),
        .db_table tbody td:nth-child(4) { display: none; }
    }
</style>
@endpush

@section('content')

@php
    $grouped      = $reservations->getCollection()->groupBy('status');
    $activeRes    = $grouped->get('active',    collect());
    $pendingRes   = $grouped->get('pending',   collect());
    $completedRes = $grouped->get('completed', collect());
    $cancelledRes = $grouped->get('cancelled', collect());
    $allRes       = $reservations->getCollection();
    $totalSpent   = $allRes->whereIn('status', ['active','completed'])->sum('total');
    $totalDays    = $allRes->whereIn('status', ['active','completed'])->sum('days');
@endphp

{{-- STAT CARDS ─────────────────────────────────────────── --}}
<div class="db_stats_row">
    <div class="db_stat">
        <div class="db_stat_icon red"><i class="fas fa-car"></i></div>
        <div>
            <div class="db_stat_val">{{ $activeRes->count() }}</div>
            <div class="db_stat_lbl">En cours</div>
        </div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="db_stat_val">{{ $allRes->count() }}</div>
            <div class="db_stat_lbl">Total réservations</div>
        </div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon gray"><i class="fas fa-coins"></i></div>
        <div>
            <div class="db_stat_val" style="font-size:{{ strlen(number_format($totalSpent)) > 9 ? '16px' : (strlen(number_format($totalSpent)) > 7 ? '20px' : '26px') }};">
                {{ number_format($totalSpent) }}
            </div>
            <div class="db_stat_lbl">FCFA dépensés</div>
        </div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-calendar-day"></i></div>
        <div>
            <div class="db_stat_val">{{ $totalDays }}</div>
            <div class="db_stat_lbl">Jours de location</div>
        </div>
    </div>
</div>

{{-- RESERVATIONS PANEL ──────────────────────────────────── --}}
<div class="db_panel">

    {{-- Panel header: title | filter tabs | new button --}}
    <div class="db_panel_head">
        <h3 class="db_panel_title">
            Mes Réservations
            <span class="db_count_pill">{{ $allRes->count() }}</span>
        </h3>

        <div class="rf_tabs">
            <button class="rf_tab is_active" data-filter="all">
                Toutes <span class="db_count_pill">{{ $allRes->count() }}</span>
            </button>
            <button class="rf_tab" data-filter="active">
                En cours <span class="db_count_pill">{{ $activeRes->count() }}</span>
            </button>
            <button class="rf_tab" data-filter="pending">
                Programmées <span class="db_count_pill">{{ $pendingRes->count() }}</span>
            </button>
            <button class="rf_tab" data-filter="completed">
                Terminées <span class="db_count_pill">{{ $completedRes->count() }}</span>
            </button>
            <button class="rf_tab" data-filter="cancelled">
                Annulées <span class="db_count_pill">{{ $cancelledRes->count() }}</span>
            </button>
        </div>

        <a href="{{ route('fleet') }}" class="db_panel_more">
            <i class="fas fa-plus"></i> Nouvelle réservation
        </a>
    </div>

    {{-- Table --}}
    @if($allRes->isEmpty())
        <div class="db_empty">
            <i class="fas fa-car-side"></i>
            <p>Vous n'avez aucune réservation pour le moment.</p>
            <a href="{{ route('fleet') }}" class="db_go">
                Réserver un véhicule <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="db_table" id="res_table">
                <thead>
                    <tr>
                        <th>N° Réservation</th>
                        <th>Véhicule</th>
                        <th>Période</th>
                        <th>Durée</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($allRes->sortByDesc('created_at') as $res)
                    <tr data-status="{{ $res->status }}">
                        {{-- N° --}}
                        <td><span class="tc_num">{{ $res->reservation_number }}</span></td>

                        {{-- Véhicule --}}
                        <td>
                            <div class="tc_vehicle">
                                @if($res->vehicle && $res->vehicle->photo_url)
                                    <img src="{{ $res->vehicle->photo_url }}"
                                         alt="{{ $res->vehicle->name }}"
                                         class="tc_thumb">
                                @else
                                    <div class="tc_thumb_ph"><i class="fas fa-car"></i></div>
                                @endif
                                <span class="tc_name">{{ $res->vehicle->name ?? 'Véhicule' }}</span>
                            </div>
                        </td>

                        {{-- Période --}}
                        <td style="white-space:nowrap;color:#111827;">
                            {{ $res->start_date->format('d/m/Y') }}<br>
                            <span style="color:#111827;font-size:10px;">&rarr; {{ $res->end_date->format('d/m/Y') }}</span>
                        </td>

                        {{-- Durée --}}
                        <td style="white-space:nowrap;color:#111827;">
                            {{ $res->days }} jour{{ $res->days > 1 ? 's' : '' }}
                        </td>

                        {{-- Montant --}}
                        <td>
                            <span class="tc_amt">{{ number_format($res->total) }}</span>
                            <span style="font-size:9px;color:#111827;"> FCFA</span>
                            @if($res->discount_percentage > 0)
                                <br><span class="tc_discount">-{{ $res->discount_percentage }}%</span>
                            @endif
                        </td>

                        {{-- Statut + countdown --}}
                        <td>
                            <span class="db_badge {{ $res->status }}">{{ $res->status_label }}</span>
                            @if($res->status === 'active')
                                <span class="tc_timer countdown_inline"
                                      data-end="{{ $res->end_date->format('Y-m-d') }}T{{ $res->return_time ?? '18:00' }}">—</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="tc_actions">
                                <a href="{{ route('reservations.show', $res) }}"
                                   class="tc_icon_btn dark" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($res->status === 'active')
                                    @if($res->canBeExtended())
                                        <a href="{{ route('reservations.extend.show', $res) }}"
                                           class="tc_icon_btn blue"
                                           title="Prolonger la réservation">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    @else
                                        <span class="tc_icon_btn"
                                              style="background:#F3F4F6;color:#D1D5DB;cursor:not-allowed;"
                                              title="{{ $res->extendBlockReason() }}">
                                            <i class="fas fa-calendar-plus"></i>
                                        </span>
                                    @endif
                                @endif
                                @if($res->status === 'pending')
                                    <button type="button"
                                            class="tc_icon_btn red open_cancel_modal"
                                            title="Annuler"
                                            data-res-id="{{ $res->id }}"
                                            data-res-number="{{ $res->reservation_number }}"
                                            data-cancel-url="{{ route('reservations.cancel', $res) }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

@if($reservations->hasPages())
    <div style="margin-top:16px;">{{ $reservations->links() }}</div>
@endif

{{-- Cancel Modal --}}
<div class="modal fade db_modal" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="cancelForm" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle" style="color:#FBBF24;margin-right:8px;"></i>
                        Annuler la réservation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size:13px;color:#6B7280;margin-bottom:16px;">
                        Confirmer l'annulation de la réservation
                        <strong id="cancelResNumber" style="color:#111827;"></strong> ?
                        Cette action est irréversible.
                    </p>
                    <label class="db_modal_label">Raison (optionnelle)</label>
                    <textarea name="cancellation_reason" rows="3" placeholder="Expliquez brièvement..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="db_modal_btn secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="db_modal_btn primary">
                        <i class="fas fa-times"></i> Confirmer l'annulation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
$(function () {

    // ── Filter tabs ─────────────────────────────────────────
    $('.rf_tab').on('click', function () {
        var filter = $(this).data('filter');
        $('.rf_tab').removeClass('is_active');
        $(this).addClass('is_active');

        if (filter === 'all') {
            $('#res_table tbody tr').show();
        } else {
            $('#res_table tbody tr').hide();
            $('#res_table tbody tr[data-status="' + filter + '"]').show();
        }
    });

    // ── Cancel modal ─────────────────────────────────────────
    $(document).on('click', '.open_cancel_modal', function () {
        $('#cancelResNumber').text($(this).data('res-number'));
        $('#cancelForm').attr('action', $(this).data('cancel-url'));
        $('#cancelModal').modal('show');
    });

    // ── Countdown ────────────────────────────────────────────
    function tick() {
        $('.countdown_inline[data-end]').each(function () {
            var end  = new Date($(this).attr('data-end'));
            var diff = end - new Date();
            if (isNaN(end.getTime())) return;
            if (diff <= 0) { $(this).text('Terminée'); return; }
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var p = [];
            if (d) p.push(d + 'j');
            if (h) p.push(h + 'h');
            if (m) p.push(m + 'min');
            $(this).text(p.length ? p.join(' ') : '< 1 min');
        });
    }
    tick();
    setInterval(tick, 60000);

    // ── Hash-based filter ────────────────────────────────────
    var hash = window.location.hash.replace('#', '');
    if (hash) {
        var $tab = $('.rf_tab[data-filter="' + hash + '"]');
        if ($tab.length) $tab.trigger('click');
    }

});
</script>
@endpush
