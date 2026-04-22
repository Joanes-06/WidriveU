@extends('layouts.admin')
@section('title', 'Client — ' . $user->name)
@section('page_title', 'Profil client')

@section('content')

<a href="{{ route('admin.users.index') }}" class="adm_back"><i class="fas fa-chevron-left"></i> Retour aux clients</a>

<div class="adm_page_hd">
    <div>
        <h2 style="display:flex;align-items:center;gap:10px;">
            {{ $user->name }}
            <span class="db_badge completed">Client</span>
        </h2>
        <p>Inscrit le {{ $user->created_at->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('admin.reservations.create') }}?user_id={{ $user->id }}" class="adm_btn red">
        <i class="fas fa-plus"></i> Créer une réservation
    </a>
</div>

<div class="adm_grid">

    {{-- LEFT : Historique --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-history"></i> Historique des réservations</h3>
            </div>
            <table class="db_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Véhicule</th>
                        <th>Période</th>
                        <th>Jours</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $r)
                    @php
                        $sc = ['active'=>'active','pending'=>'pending','completed'=>'completed','cancelled'=>'cancelled'][$r->status] ?? 'completed';
                        $sl = ['active'=>'En cours','pending'=>'En attente','completed'=>'Terminée','cancelled'=>'Annulée'][$r->status] ?? $r->status;
                    @endphp
                    <tr>
                        <td class="mono text_muted">{{ $r->reservation_number }}</td>
                        <td class="fw7">{{ $r->vehicle->name ?? '—' }}</td>
                        <td class="text_muted no_wrap" style="font-size:12px;">
                            {{ $r->start_date->format('d/m/Y') }}<br>→ {{ $r->end_date->format('d/m/Y') }}
                        </td>
                        <td>{{ $r->days }}j</td>
                        <td class="fw7 no_wrap">{{ number_format($r->total) }} <span class="text_muted" style="font-size:11px;font-weight:400;">FCFA</span></td>
                        <td><span class="db_badge {{ $sc }}">{{ $sl }}</span></td>
                        <td>
                            <a href="{{ route('admin.reservations.show', $r) }}" class="tc_icon_btn dark">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="adm_empty"><i class="fas fa-calendar"></i><p>Aucune réservation</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($reservations->hasPages())
            <div class="adm_pager">
                <span>Page {{ $reservations->currentPage() }} / {{ $reservations->lastPage() }}</span>
                {{ $reservations->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT : Profil + Stats --}}
    <div>

        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-user"></i> Profil</h3>
            </div>
            <div class="db_panel_body">
                <div style="text-align:center;margin-bottom:16px;">
                    <div style="width:60px;height:60px;border-radius:50%;background:#111827;color:#fff;font-size:20px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <div class="fw7" style="font-size:14px;">{{ $user->name }}</div>
                    <div class="text_muted" style="font-size:12px;">{{ $user->email }}</div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-phone"></i></div>
                    <div><div class="adm_info_lbl">Téléphone</div><div class="adm_info_val">{{ $user->phone ?? '—' }}</div></div>
                </div>
                @if($user->address)
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div><div class="adm_info_lbl">Adresse</div><div class="adm_info_val">{{ $user->address }}</div></div>
                </div>
                @endif
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-calendar"></i></div>
                    <div><div class="adm_info_lbl">Inscrit le</div><div class="adm_info_val">{{ $user->created_at->format('d/m/Y') }}</div></div>
                </div>
            </div>
        </div>

        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-chart-bar"></i> Statistiques</h3>
            </div>
            <div class="db_panel_body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
                    <div style="background:#F5F6FA;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#111827;">{{ $stats['total'] }}</div>
                        <div style="font-size:10px;color:#9CA3AF;margin-top:2px;">Total</div>
                    </div>
                    <div style="background:#D1FAE5;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#065F46;">{{ $stats['active'] }}</div>
                        <div style="font-size:10px;color:#065F46;margin-top:2px;">Actives</div>
                    </div>
                    <div style="background:#F3F4F6;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#374151;">{{ $stats['completed'] }}</div>
                        <div style="font-size:10px;color:#9CA3AF;margin-top:2px;">Terminées</div>
                    </div>
                    <div style="background:#FEE2E2;border-radius:8px;padding:12px;text-align:center;">
                        <div style="font-size:22px;font-weight:800;color:#991B1B;">{{ $stats['cancelled'] }}</div>
                        <div style="font-size:10px;color:#991B1B;margin-top:2px;">Annulées</div>
                    </div>
                </div>
                <div style="background:#111827;border-radius:8px;padding:14px;text-align:center;">
                    <div style="font-size:10px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">Total dépensé</div>
                    <div style="font-size:24px;font-weight:800;color:#fff;">{{ number_format($stats['total_spent']) }}</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.4);">FCFA</div>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.reservations.create') }}?user_id={{ $user->id }}" class="adm_btn red" style="width:100%;justify-content:center;padding:12px;">
            <i class="fas fa-plus"></i> Créer une réservation
        </a>

    </div>
</div>

@endsection
