@extends('layouts.admin')
@section('title', 'Réservations')
@section('page_title', 'Réservations')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Réservations</h2>
        <p>{{ $reservations->total() }} réservation{{ $reservations->total() > 1 ? 's' : '' }} au total</p>
    </div>
    <a href="{{ route('admin.reservations.create') }}" class="adm_btn red">
        <i class="fas fa-plus"></i> Créer
    </a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.reservations.index') }}">
<div class="adm_filter_bar">
    <input type="text" name="search" class="adm_search" placeholder="N°, client, véhicule…" value="{{ request('search') }}">
    <select name="status" class="adm_filter_select" onchange="this.form.submit()">
        <option value="">Tous les statuts</option>
        <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>En cours</option>
        <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Terminées</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulées</option>
    </select>
    <select name="type" class="adm_filter_select" onchange="this.form.submit()">
        <option value="">Tous les types</option>
        <option value="sans_chauffeur" {{ request('type') === 'sans_chauffeur' ? 'selected' : '' }}>Sans chauffeur</option>
        <option value="avec_chauffeur" {{ request('type') === 'avec_chauffeur' ? 'selected' : '' }}>Avec chauffeur</option>
    </select>
    <button type="submit" class="adm_btn dark sm"><i class="fas fa-search"></i> Filtrer</button>
    @if(request()->hasAny(['search','status','type']))
    <a href="{{ route('admin.reservations.index') }}" class="adm_btn gray sm"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
</form>

<div class="db_panel">
    <table class="db_table">
        <thead>
            <tr>
                <th>N° Réservation</th>
                <th>Client</th>
                <th>Véhicule</th>
                <th>Période</th>
                <th>Jours</th>
                <th>Montant</th>
                <th>Type</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $r)
            @php
                $statusClass = ['active'=>'active','pending'=>'pending','completed'=>'completed','cancelled'=>'cancelled'][$r->status] ?? 'completed';
                $statusLabel = ['active'=>'En cours','pending'=>'En attente','completed'=>'Terminée','cancelled'=>'Annulée'][$r->status] ?? $r->status;
            @endphp
            <tr class="clickable" onclick="window.location='{{ route('admin.reservations.show', $r) }}'">
                <td class="mono">{{ $r->reservation_number }}</td>
                <td class="fw7">{{ $r->user->name ?? '—' }}</td>
                <td class="text_muted">{{ $r->vehicle->name ?? '—' }}</td>
                <td class="no_wrap text_muted" style="font-size:12px;">
                    {{ $r->start_date->format('d/m/Y') }}<br>
                    <span>→</span> {{ $r->end_date->format('d/m/Y') }}
                </td>
                <td class="fw7">{{ $r->days }}j</td>
                <td class="fw7 no_wrap">
                    {{ number_format($r->total) }}
                    <span class="text_muted" style="font-weight:400;font-size:11px;">FCFA</span>
                    @if($r->discount_percentage > 0)
                    <br><span class="text_red" style="font-size:10px;font-weight:600;">-{{ $r->discount_percentage }}%</span>
                    @endif
                </td>
                <td>
                    <span class="db_badge {{ $r->type === 'avec_chauffeur' ? 'active' : 'completed' }}" style="font-size:9px;">
                        {{ $r->type === 'avec_chauffeur' ? 'Avec' : 'Sans' }} chauffeur
                    </span>
                </td>
                <td><span class="db_badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                <td onclick="event.stopPropagation();">
                    <div class="gap_row">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="tc_icon_btn dark" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($r->status === 'active')
                        <button type="button" class="tc_icon_btn" title="Annuler"
                            onclick="openCancelModal({{ $r->id }}, '{{ $r->reservation_number }}')">
                            <i class="fas fa-times" style="color:#860000;"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="adm_empty">
                        <i class="fas fa-calendar-times"></i>
                        <p>Aucune réservation trouvée</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($reservations->hasPages())
    <div class="adm_pager">
        <span>Page {{ $reservations->currentPage() }} / {{ $reservations->lastPage() }}</span>
        {{ $reservations->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Cancel Modal --}}
<div class="adm_modal_overlay" id="cancelModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Annuler la réservation</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="cancelForm" method="POST">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;margin-bottom:16px;">
                    Annuler la réservation <strong id="cancelNum"></strong> ? Cette action est irréversible.
                </p>
                <div class="adm_form_group">
                    <label class="adm_form_label">Motif d'annulation</label>
                    <textarea name="cancellation_reason" class="adm_input adm_textarea" placeholder="Raison de l'annulation…"></textarea>
                </div>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Fermer</button>
                <button type="submit" class="adm_btn red"><i class="fas fa-times"></i> Confirmer l'annulation</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openCancelModal(id, num) {
    document.getElementById('cancelForm').action = '/admin/reservations/' + id + '/annuler';
    document.getElementById('cancelNum').textContent = num;
    document.getElementById('cancelModal').classList.add('open');
}
// Auto-submit search after 600ms
var searchTimer;
document.querySelector('.adm_search')?.addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => this.form.submit(), 600);
});
</script>
@endpush
