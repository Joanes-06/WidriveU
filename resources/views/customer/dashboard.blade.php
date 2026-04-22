@extends('layouts.dashboard')

@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@push('styles')
<style>

    /* ============================================================
       GREETING
       ============================================================ */
    .db_greeting {
        margin-bottom: 24px;
    }
    .db_greeting h2 {
        font-family: 'Sora', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px;
    }
    .db_greeting p {
        font-size: 12px;
        color: #9CA3AF;
        margin: 0;
    }

    /* ============================================================
       STAT CARDS ROW
       ============================================================ */
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
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: #000C21;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .db_stat_icon.red  { background: #860000; }
    .db_stat_icon.gray { background: #374151; }

    .db_stat_val {
        font-family: 'Sora', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
        margin-bottom: 4px;
    }

    .db_stat_lbl {
        font-size: 11px;
        font-weight: 600;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================================
       CONTENT GRID  (table left | right panel)
       ============================================================ */
    .db_content_grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }

    /* ============================================================
       PANEL (white card)
       ============================================================ */
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
    }

    .db_panel_title {
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .db_count_pill {
        background: #F3F4F6;
        color: #6B7280;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .db_count_pill.green { background: #D1FAE5; color: #065F46; }

    .db_panel_more {
        font-size: 11px;
        font-weight: 700;
        color: #860000;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.15s;
    }
    .db_panel_more:hover { gap: 8px; color: #860000; text-decoration: none; }

    /* ============================================================
       TABLE
       ============================================================ */
    .db_table { width: 100%; border-collapse: collapse; }

    .db_table thead th {
        padding: 10px 18px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9CA3AF;
        text-align: left;
        border-bottom: 1px solid #F3F4F6;
        background: #FAFBFC;
        white-space: nowrap;
    }

    .db_table tbody tr { transition: background 0.1s; }
    .db_table tbody tr:hover { background: #FAFBFC; }
    .db_table tbody td {
        padding: 13px 18px;
        font-size: 12px;
        color: #6B7280;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }
    .db_table tbody tr:last-child td { border-bottom: none; }

    .tc_num  { font-family: 'Sora', sans-serif; font-weight: 700; color: #111827; font-size: 12px; }
    .tc_name { font-weight: 600; color: #374151; }
    .tc_amt  { font-family: 'Sora', sans-serif; font-weight: 700; color: #111827; white-space: nowrap; }

    /* ============================================================
       STATUS BADGES
       ============================================================ */
    .db_badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .db_badge.pending   { background: #FEF3C7; color: #92400E; }
    .db_badge.active    { background: #D1FAE5; color: #065F46; }
    .db_badge.completed { background: #FFF2F2; color: #860000; }
    .db_badge.cancelled { background: #FEE2E2; color: #991B1B; }

    /* ============================================================
       INLINE LINK
       ============================================================ */
    .db_go {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 700;
        color: #860000;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: gap 0.15s;
    }
    .db_go:hover { gap: 8px; color: #860000; text-decoration: none; }

    /* ============================================================
       ACTIVE RESERVATION ITEM
       ============================================================ */
    .db_res_item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 20px;
        border-bottom: 1px solid #F3F4F6;
        transition: background 0.1s;
    }
    .db_res_item:last-child { border-bottom: none; }
    .db_res_item:hover { background: #FAFBFC; }

    .db_res_thumb {
        width: 58px;
        height: 44px;
        border-radius: 7px;
        object-fit: cover;
        flex-shrink: 0;
        background: #F3F4F6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .db_res_name {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 3px;
    }

    .db_res_dates {
        font-size: 11px;
        color: #111827;
        line-height: 1.5;
    }
    .db_res_dates i { color: #860000; font-size: 9px; margin-right: 3px; }

    .db_res_right { text-align: right; flex-shrink: 0; }

    .db_res_amount {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #111827;
        display: block;
        margin-bottom: 3px;
        white-space: nowrap;
    }

    .db_res_timer {
        font-size: 10px;
        font-weight: 700;
        color: #860000;
        display: block;
        white-space: nowrap;
    }

    /* ============================================================
       CTA CARD (red)
       ============================================================ */
    .db_cta_card {
        background: #860000;
        border-radius: 12px;
        padding: 22px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(234,0,30,0.22);
    }
    .db_cta_card h4 {
        font-family: 'Sora', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 5px;
    }
    .db_cta_card p {
        font-size: 11px;
        color: rgba(255,255,255,0.65);
        margin: 0 0 16px;
        line-height: 1.6;
    }
    .db_cta_card .cta_btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: #860000;
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: opacity 0.18s;
    }
    .db_cta_card .cta_btn:hover { opacity: 0.85; color: #860000; text-decoration: none; }

    /* ============================================================
       EMPTY STATE
       ============================================================ */
    .db_empty {
        text-align: center;
        padding: 40px 20px;
    }
    .db_empty i { font-size: 32px; color: #E5E7EB; margin-bottom: 10px; display: block; }
    .db_empty p { font-size: 12px; color: #9CA3AF; margin-bottom: 14px; }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1199px) {
        .db_content_grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 991px) {
        .db_stats_row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .db_stats_row { grid-template-columns: 1fr 1fr; }
        .db_stat_val  { font-size: 22px; }
    }
</style>
@endpush

@section('content')

@php
    $parts    = explode(' ', trim(auth()->user()->name));
    $firstName = $parts[0];
@endphp

{{-- GREETING --}}
<div class="db_greeting">
    <h2>Bonjour, <span style="color:#860000;">{{ $firstName }}</span> 👋</h2>
    <p>
        <i class="fas fa-map-marker-alt" style="color:#860000;margin-right:4px;"></i>
        Cotonou, Bénin &nbsp;&bull;&nbsp; {{ now()->format('d/m/Y') }}
    </p>
</div>

{{-- STAT CARDS --}}
<div class="db_stats_row">

    <div class="db_stat">
        <div class="db_stat_icon red"><i class="fas fa-car"></i></div>
        <div>
            <div class="db_stat_val">{{ $activeCount }}</div>
            <div class="db_stat_lbl">En cours</div>
        </div>
    </div>

    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="db_stat_val">{{ $totalCount }}</div>
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


{{-- CONTENT GRID --}}
<div class="db_content_grid">

    {{-- LEFT : Table des réservations récentes --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    Réservations récentes
                    <span class="db_count_pill">{{ $lastReservations->count() }}</span>
                </h3>
                <a href="{{ route('reservations.index') }}" class="db_panel_more">
                    Voir toutes <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if($lastReservations->count() > 0)
            <div style="overflow-x:auto;">
                <table class="db_table">
                    <thead>
                        <tr>
                            <th>N° Réservation</th>
                            <th>Véhicule</th>
                            <th>Période</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lastReservations as $res)
                        <tr>
                            <td><span class="tc_num">{{ $res->reservation_number }}</span></td>
                            <td><span class="tc_name">{{ $res->vehicle->name ?? 'N/A' }}</span></td>
                            <td style="white-space:nowrap;color:#111827;">
                                {{ $res->start_date->format('d/m/Y') }}<br>
                                <span style="color:#111827;font-size:10px;">&rarr; {{ $res->end_date->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="tc_amt">{{ number_format($res->total) }}</span>
                                <span style="font-size:9px;color:#111827;"> FCFA</span>
                            </td>
                            <td><span class="db_badge {{ $res->status }}">{{ $res->status_label }}</span></td>
                            <td>
                                <a href="{{ route('reservations.show', $res) }}" class="db_go">
                                    Voir <i class="fas fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="db_empty">
                <i class="fas fa-car-side"></i>
                <p>Aucune réservation pour le moment.</p>
                <a href="{{ route('fleet') }}" class="db_go">
                    Réserver un véhicule <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif

        </div>
    </div>
    {{-- END LEFT --}}


    {{-- RIGHT : CTA + Réservations actives --}}
    <div>

        {{-- CTA Card --}}
        <div class="db_cta_card">
            <h4>Nouvelle réservation</h4>
            <p>Parcourez notre flotte et réservez le véhicule de votre choix en quelques clics.</p>
            <a href="{{ route('fleet') }}" class="cta_btn">
                <i class="fas fa-car"></i> Voir les véhicules
            </a>
        </div>

        {{-- Active reservations panel --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    En cours
                    <span class="db_count_pill {{ $activeCount > 0 ? 'green' : '' }}">{{ $activeCount }}</span>
                </h3>
                <a href="{{ route('reservations.index') }}" class="db_panel_more">
                    Tout voir <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if(isset($activeReservations) && $activeReservations->count() > 0)
                @foreach($activeReservations as $res)
                <a href="{{ route('reservations.show', $res) }}" style="text-decoration:none;display:block;">
                    <div class="db_res_item">

                        @if($res->vehicle)
                            <img class="db_res_thumb" src="{{ $res->vehicle->photo_url }}" alt="{{ $res->vehicle->name }}">
                        @else
                            <div class="db_res_thumb">
                                <i class="fas fa-car" style="color:#ccc;font-size:16px;"></i>
                            </div>
                        @endif

                        <div style="flex:1;min-width:0;">
                            <div class="db_res_name">{{ $res->vehicle->name ?? 'Véhicule' }}</div>
                            <div class="db_res_dates">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $res->start_date->format('d/m/Y') }} &rarr; {{ $res->end_date->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="db_res_right">
                            <span class="db_res_amount">{{ number_format($res->total) }}<br>
                                <span style="font-size:9px;color:#111827;font-weight:400;">FCFA</span>
                            </span>
                            <span class="db_res_timer countdown_item"
                                  data-end="{{ $res->end_date->format('Y-m-d') }}T{{ $res->return_time ?? '18:00' }}">—</span>
                        </div>

                    </div>
                </a>
                @endforeach
            @else
            <div class="db_empty">
                <i class="fas fa-clock"></i>
                <p>Aucune réservation active.</p>
            </div>
            @endif

        </div>

    </div>
    {{-- END RIGHT --}}

</div>

@endsection

@push('scripts')
<script>
$(function () {
    function tick() {
        $('.countdown_item[data-end]').each(function () {
            var end  = new Date($(this).attr('data-end'));
            var diff = end - new Date();
            if (isNaN(end.getTime())) return;
            if (diff <= 0) { $(this).css('color','#DC2626').text('Terminée'); return; }
            var d = Math.floor(diff / 86400000),
                h = Math.floor((diff % 86400000) / 3600000),
                m = Math.floor((diff % 3600000) / 60000),
                p = [];
            if (d) p.push(d + 'j');
            if (h) p.push(h + 'h');
            if (m) p.push(m + 'min');
            $(this).text(p.length ? p.join(' ') : '< 1 min');
        });
    }
    tick();
    setInterval(tick, 60000);
});
</script>
@endpush
