@extends('layouts.admin')
@section('title', 'Statistiques')
@section('page_title', 'Statistiques')

@section('content')

@php
    $totalRes12  = array_sum($reservationsPerMonth ?? []);
    $totalRev12  = array_sum($revenuePerMonth ?? []);
    $totalDisc12 = array_sum($discountsPerMonth ?? []);
    $avgPerRes   = $totalRes12 > 0 ? round($totalRev12 / $totalRes12) : 0;
@endphp

<div class="adm_page_hd">
    <div>
        <h2>Statistiques</h2>
        <p>Vue détaillée sur les 12 derniers mois</p>
    </div>
</div>

{{-- Stats --}}
<div class="db_stat_grid" style="margin-bottom:20px;">
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-calendar-check"></i></div>
        <div class="db_stat_val">{{ $totalRes12 }}</div>
        <div class="db_stat_lbl">Réservations <span class="db_stat_sub">12 mois</span></div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-coins"></i></div>
        <div class="db_stat_val" style="font-size:1.3rem;">{{ number_format($totalRev12) }}</div>
        <div class="db_stat_lbl">Revenus nets <span class="db_stat_sub">FCFA</span></div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-chart-line"></i></div>
        <div class="db_stat_val" style="font-size:1.3rem;">{{ number_format($avgPerRes) }}</div>
        <div class="db_stat_lbl">Revenu moyen <span class="db_stat_sub">FCFA / résa</span></div>
    </div>
    <div class="db_stat">
        <div class="db_stat_icon"><i class="fas fa-tag"></i></div>
        <div class="db_stat_val" style="font-size:1.3rem;">{{ number_format($totalDisc12) }}</div>
        <div class="db_stat_lbl">Réductions <span class="db_stat_sub">FCFA offertes</span></div>
    </div>
</div>

{{-- Charts row --}}
<div class="adm_grid" style="margin-bottom:20px;">

    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-chart-bar"></i> Réservations / mois</h3>
                <span style="font-size:12px;color:#9CA3AF;">12 derniers mois</span>
            </div>
            <div class="db_panel_body">
                <canvas id="reservationsChart" height="160"></canvas>
            </div>
        </div>
    </div>

    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-chart-pie"></i> Répartition revenus</h3>
            </div>
            <div class="db_panel_body" style="display:flex;align-items:center;justify-content:center;">
                <canvas id="revenueDonut" height="200" style="max-width:220px;"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- Revenue line chart --}}
<div class="db_panel" style="margin-bottom:20px;">
    <div class="db_panel_head">
        <h3 class="db_panel_title"><i class="fas fa-chart-area"></i> Revenus mensuels nets (FCFA)</h3>
        <span style="font-size:12px;color:#9CA3AF;">12 derniers mois</span>
    </div>
    <div class="db_panel_body">
        <canvas id="revenueChart" height="80"></canvas>
    </div>
</div>

{{-- Tableau mensuel --}}
<div class="db_panel">
    <div class="db_panel_head">
        <h3 class="db_panel_title"><i class="fas fa-table"></i> Tableau détaillé mensuel</h3>
        <button onclick="window.print()" class="adm_btn gray sm">
            <i class="fas fa-print"></i> Imprimer
        </button>
    </div>
    <table class="db_table">
        <thead>
            <tr>
                <th>Mois</th>
                <th style="text-align:center;">Réservations</th>
                <th style="text-align:right;">Revenus bruts</th>
                <th style="text-align:right;">Réductions</th>
                <th style="text-align:right;">Revenus nets</th>
                <th style="width:130px;">Part</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = array_sum($revenuePerMonth ?? []); @endphp
            @foreach($months ?? [] as $i => $month)
            @php
                $res   = $reservationsPerMonth[$i] ?? 0;
                $disc  = $discountsPerMonth[$i] ?? 0;
                $net   = $revenuePerMonth[$i] ?? 0;
                $gross = $net + $disc;
                $pct   = $grandTotal > 0 ? round(($net / $grandTotal) * 100, 1) : 0;
            @endphp
            <tr>
                <td class="fw7">{{ $month }}</td>
                <td style="text-align:center;">
                    @if($res > 0)
                    <span class="db_badge dark">{{ $res }}</span>
                    @else
                    <span class="text_muted">—</span>
                    @endif
                </td>
                <td style="text-align:right;" class="text_muted">{{ $gross > 0 ? number_format($gross) . ' FCFA' : '—' }}</td>
                <td style="text-align:right;color:#860000;font-weight:600;">{{ $disc > 0 ? '-' . number_format($disc) . ' FCFA' : '—' }}</td>
                <td style="text-align:right;" class="fw7">{{ $net > 0 ? number_format($net) . ' FCFA' : '—' }}</td>
                <td>
                    @if($pct > 0)
                    <div class="adm_progress_track">
                        <div class="adm_progress_bar" style="width:{{ min(100,$pct) }}%;"></div>
                    </div>
                    <div style="font-size:11px;color:#9CA3AF;margin-top:2px;">{{ $pct }}%</div>
                    @else
                    <span class="text_muted" style="font-size:12px;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background:#111827;color:#fff;">
                <td style="padding:12px 14px;font-weight:700;">TOTAL</td>
                <td style="text-align:center;padding:12px 14px;font-weight:700;">{{ $totalRes12 }}</td>
                <td style="text-align:right;padding:12px 14px;font-weight:700;">{{ number_format($totalRev12 + $totalDisc12) }} FCFA</td>
                <td style="text-align:right;padding:12px 14px;font-weight:700;color:#860000;">-{{ number_format($totalDisc12) }} FCFA</td>
                <td style="text-align:right;padding:12px 14px;font-weight:700;color:#4ADE80;">{{ number_format($totalRev12) }} FCFA</td>
                <td style="padding:12px 14px;color:rgba(255,255,255,.5);">100%</td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
var months       = @json($months ?? []);
var reservations = @json($reservationsPerMonth ?? []);
var revenues     = @json($revenuePerMonth ?? []);
var discounts    = @json($discountsPerMonth ?? []);

// Bar: réservations
new Chart(document.getElementById('reservationsChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Réservations',
            data: reservations,
            backgroundColor: 'rgba(234,0,30,0.75)',
            borderColor: '#860000',
            borderWidth: 1,
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Line: revenus
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Revenus nets (FCFA)',
                data: revenues,
                borderColor: '#22C55E',
                backgroundColor: 'rgba(34,197,94,0.07)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#22C55E',
                borderWidth: 2
            },
            {
                label: 'Réductions (FCFA)',
                data: discounts,
                borderColor: '#860000',
                backgroundColor: 'rgba(234,0,30,0.05)',
                fill: true,
                tension: 0.4,
                borderDash: [5,4],
                pointBackgroundColor: '#860000',
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true } }
    }
});

// Donut
var totalNet  = revenues.reduce(function(a,b){ return a+b; }, 0);
var totalDisc = discounts.reduce(function(a,b){ return a+b; }, 0);
new Chart(document.getElementById('revenueDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Revenus nets', 'Réductions'],
        datasets: [{
            data: [totalNet, totalDisc],
            backgroundColor: ['#22C55E', '#860000'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        return ctx.label + ' : ' + ctx.raw.toLocaleString('fr-FR') + ' FCFA';
                    }
                }
            }
        }
    }
});
</script>
@endpush
