@extends('layouts.admin')
@section('title', 'Tableau de bord')
@section('page_title', 'Tableau de bord')

@section('content')

{{-- ── STAT GRID ── --}}
<div class="db_stat_grid" style="grid-template-columns:repeat(6,1fr);">

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-car"></i></div>
            <span class="db_stat_badge">Parc</span>
        </div>
        <div class="db_stat_val" data-counter="{{ $vehiclesTotal }}">{{ $vehiclesTotal }}</div>
        <div class="db_stat_label">Véhicules</div>
    </div>

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon" ><i class="fas fa-check-circle"></i></div>
            <span class="db_stat_badge">Dispo</span>
        </div>
        <div class="db_stat_val" data-counter="{{ $vehiclesAvailable }}">{{ $vehiclesAvailable }}</div>
        <div class="db_stat_label">Disponibles</div>
    </div>

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-calendar-check"></i></div>
            <span class="db_stat_badge">Location</span>
        </div>
        <div class="db_stat_val" data-counter="{{ $vehiclesReserved }}">{{ $vehiclesReserved }}</div>
        <div class="db_stat_label">Réservés</div>
    </div>

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon" style="background:#FEF3C7;color:#92400E;"><i class="fas fa-tools"></i></div>
            <span class="db_stat_badge">Atelier</span>
        </div>
        <div class="db_stat_val" style="color:#92400E;" data-counter="{{ $vehiclesMaintenance }}">{{ $vehiclesMaintenance }}</div>
        <div class="db_stat_label">Maintenance</div>
    </div>

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-users"></i></div>
            <span class="db_stat_badge">Inscrits</span>
        </div>
        <div class="db_stat_val" data-counter="{{ $clientsCount }}">{{ $clientsCount }}</div>
        <div class="db_stat_label">Clients</div>
    </div>

    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon" style="color:#065F46; background-color:#D1FAE5"><i class="fas fa-play-circle"></i></div>
            <span class="db_stat_badge">Actives</span>
        </div>
        <div class="db_stat_val" style="color:#065F46;" data-counter="{{ $reservationsActive }}">{{ $reservationsActive }}</div>
        <div class="db_stat_label">En cours</div>
    </div>

</div>

{{-- ── ROW 2 ── --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;margin-bottom:20px;align-items:start;">

    {{-- Revenue card --}}
    <div class="db_panel" style="background:#111827;border-color:#111827;margin-bottom:0;">
        <div class="db_panel_body" style="padding:28px;">
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.4px;color:rgba(255,255,255,0.35);margin-bottom:10px;">Revenus du mois</div>
            <div style="font-size:42px;font-weight:800;color:#fff;line-height:1;font-family:var(--font-display);" data-counter="{{ $monthlyRevenue }}">
                {{ number_format($monthlyRevenue) }}
                <span style="font-size:18px;font-weight:500;color:rgba(255,255,255,0.4);margin-left:4px;">FCFA</span>
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,0.4);margin-top:10px;">
                Réductions accordées :
                <span style="color:#860000;font-weight:700;">{{ number_format($monthlyDiscounts) }} FCFA</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-top:22px;">
                <div style="background:rgba(255,255,255,0.06);border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:22px;font-weight:800;color:#fff;">{{ $avgReservationDays }}j</div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.3);margin-top:3px;text-transform:uppercase;letter-spacing:0.8px;">Durée moy.</div>
                </div>
                <div style="background:rgba(255,255,255,0.06);border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:18px;font-weight:800;color:#fff;">{{ number_format($avgReservationValue) }}</div>
                    <div style="font-size:10px;color:rgba(255,255,255,0.3);margin-top:3px;text-transform:uppercase;letter-spacing:0.8px;">Val. moy.</div>
                </div>
                <div style="background:rgba(255, 255, 255, 1);border-radius:10px;padding:14px;text-align:center;">
                    <div style="font-size:22px;font-weight:800;color:#860000;">{{ $occupancyRate }}%</div>
                    <div style="font-size:10px;color:#860000;margin-top:3px;text-transform:uppercase;letter-spacing:0.8px;">Occupation</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions + stats --}}
    <div>
        <div class="db_panel" style="margin-bottom:16px;">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-bolt"></i> Actions rapides</h3>
            </div>
            <div class="db_panel_body" style="padding:14px;display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('admin.vehicles.create') }}" class="adm_btn red" style="justify-content:center;">
                    <i class="fas fa-plus-circle"></i> Ajouter un véhicule
                </a>
                <a href="{{ route('admin.reservations.create') }}" class="adm_btn dark" style="justify-content:center;">
                    <i class="fas fa-plus-circle"></i> Créer une réservation
                </a>
                <a href="{{ route('admin.reservations.active') }}" class="adm_btn gray" style="justify-content:center;">
                    <i class="fas fa-play-circle text_red"></i> Réservations en cours
                </a>
                <a href="{{ route('admin.statistics') }}" class="adm_btn gray" style="justify-content:center;">
                    <i class="fas fa-chart-bar text_muted"></i> Statistiques
                </a>
            </div>
        </div>

        <div class="db_panel" style="margin-bottom:0;">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-calendar-alt"></i> Réservations</h3>
            </div>
            <div class="db_panel_body">
                <div style="display:flex;gap:10px;margin-bottom:12px;">
                    <div style="flex:1;background:#F5F6FA;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#111827;">{{ $reservationsTotal }}</div>
                        <div style="font-size:10px;color:#9CA3AF;margin-top:2px;">Total</div>
                    </div>
                    <div style="flex:1;background:#F5F6FA;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#860000;">{{ $reservationsWithDiscount }}</div>
                        <div style="font-size:10px;color:#9CA3AF;margin-top:2px;">Avec remise</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── ROW 3 : Répartition + Dernières réservations ── --}}
<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;margin-bottom:20px;align-items:start;">

    {{-- Répartition --}}
    <div class="db_panel" style="margin-bottom:0;">
        <div class="db_panel_head">
            <h3 class="db_panel_title"><i class="fas fa-car-side"></i> Répartition</h3>
        </div>
        <div class="db_panel_body">
            @php
                $totalR = ($sansChauffeurCount + $chauffeurCount) ?: 1;
                $sansP  = round($sansChauffeurCount / $totalR * 100);
                $avecP  = round($chauffeurCount / $totalR * 100);
            @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;">
                    <span style="color:#6B7280;">Sans chauffeur</span>
                    <span class="fw7">{{ $sansP }}% <span class="text_muted" style="font-weight:400;">({{ $sansChauffeurCount }})</span></span>
                </div>
                <div class="adm_progress"><div class="adm_progress_bar" style="width:{{ $sansP }}%;background:#111827;"></div></div>
            </div>
            <div style="margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;">
                    <span style="color:#6B7280;">Avec chauffeur</span>
                    <span class="fw7 text_red">{{ $avecP }}% <span class="text_muted" style="font-weight:400;">({{ $chauffeurCount }})</span></span>
                </div>
                <div class="adm_progress"><div class="adm_progress_bar" style="width:{{ $avecP }}%;"></div></div>
            </div>

            <div class="adm_section_lbl">Paliers de réduction</div>
            @php
                $tiers = [
                    ['-15%','7–13 j',$discountTiers['tier_7']],
                    ['-18%','14–20 j',$discountTiers['tier_14']],
                    ['-20%','21+ j',$discountTiers['tier_21']],
                ];
            @endphp
            @foreach($tiers as [$badge,$label,$count])
            @php $pct = $reservationsTotal > 0 ? round($count / $reservationsTotal * 100) : 0; @endphp
            <div style="margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;margin-bottom:5px;">
                    <span>
                        <span style="background:#111827;color:#fff;border-radius:4px;padding:1px 6px;font-size:10px;font-weight:700;">{{ $badge }}</span>
                        <span class="text_muted" style="margin-left:5px;">{{ $label }}</span>
                    </span>
                    <span class="fw7">{{ $count }}</span>
                </div>
                <div class="adm_progress"><div class="adm_progress_bar" style="width:{{ $pct }}%;opacity:0.65;"></div></div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Dernières réservations --}}
    <div class="db_panel" style="margin-bottom:0;">
        <div class="db_panel_head">
            <h3 class="db_panel_title"><i class="fas fa-history"></i> Dernières réservations</h3>
            <a href="{{ route('admin.reservations.index') }}" class="db_panel_act">Tout voir →</a>
        </div>
        <table class="db_table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Véhicule</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservations as $r)
                <tr class="clickable" onclick="window.location='{{ route('admin.reservations.show', $r) }}'">
                    <td class="mono text_muted">{{ $r->reservation_number }}</td>
                    <td class="fw7">{{ $r->user->name ?? '—' }}</td>
                    <td class="text_muted">{{ $r->vehicle->name ?? '—' }}</td>
                    <td class="fw7 no_wrap">{{ number_format($r->total) }} <span class="text_muted" style="font-weight:400;font-size:11px;">FCFA</span></td>
                    <td>
                        @php $statusMap = ['active'=>'active','pending'=>'pending','completed'=>'completed','cancelled'=>'cancelled']; @endphp
                        <span class="db_badge {{ $statusMap[$r->status] ?? 'completed' }}">
                            {{ ['active'=>'En cours','pending'=>'En attente','completed'=>'Terminée','cancelled'=>'Annulée'][$r->status] ?? $r->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="adm_empty"><i class="fas fa-calendar"></i><p>Aucune réservation</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ── ROW 4 : Véhicules récents ── --}}
<div class="db_panel">
    <div class="db_panel_head">
        <h3 class="db_panel_title"><i class="fas fa-car"></i> Véhicules récents</h3>
        <a href="{{ route('admin.vehicles.index') }}" class="db_panel_act">Voir tous →</a>
    </div>
    <table class="db_table">
        <thead>
            <tr>
                <th style="width:60px;">Photo</th>
                <th>Véhicule</th>
                <th>Statut</th>
                <th>Sans chauffeur</th>
                <th>Avec chauffeur</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentVehicles as $v)
            <tr>
                <td><img src="{{ $v->photo_url }}" alt="{{ $v->name }}" style="width:48px;height:36px;object-fit:cover;border-radius:6px;"></td>
                <td>
                    <div class="fw7">{{ $v->name }}</div>
                    <div class="text_muted" style="font-size:11px;">{{ $v->brand }} {{ $v->model }} · {{ $v->year }}</div>
                </td>
                <td>
                    @php $vs = ['disponible'=>'available','reservee'=>'reserved','maintenance'=>'maintenance']; @endphp
                    <span class="db_badge {{ $vs[$v->status] ?? 'completed' }}">
                        {{ ['disponible'=>'Disponible','reservee'=>'Réservée','maintenance'=>'Maintenance'][$v->status] ?? $v->status }}
                    </span>
                </td>
                <td class="fw7 no_wrap">{{ number_format($v->price_without_driver) }} <span class="text_muted" style="font-weight:400;font-size:11px;">FCFA</span></td>
                <td class="fw7 no_wrap">{{ number_format($v->price_with_driver) }} <span class="text_muted" style="font-weight:400;font-size:11px;">FCFA</span></td>
                <td><a href="{{ route('admin.vehicles.edit', $v) }}" class="adm_btn dark sm"><i class="fas fa-pen"></i> Modifier</a></td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="adm_empty"><i class="fas fa-car"></i><p>Aucun véhicule</p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
$(function() {
    $('[data-counter]').each(function() {
        var $el = $(this), end = parseInt($el.data('counter')) || 0;
        if (!end) return;
        var cur = 0, step = Math.max(1, Math.ceil(end / 40));
        var t = setInterval(function() {
            cur = Math.min(cur + step, end);
            $el.text(cur.toLocaleString());
            if (cur >= end) clearInterval(t);
        }, 25);
    });
    setTimeout(function() {
        $('.adm_progress_bar').each(function() {
            var w = $(this).css('width');
            $(this).css('width', 0).animate({ width: w }, 800);
        });
    }, 200);
});
</script>
@endpush
