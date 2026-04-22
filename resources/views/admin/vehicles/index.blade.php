@extends('layouts.admin')
@section('title', 'Véhicules')
@section('page_title', 'Flotte')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Flotte de véhicules</h2>
        <p>{{ $vehicles->total() }} véhicule{{ $vehicles->total() > 1 ? 's' : '' }} enregistré{{ $vehicles->total() > 1 ? 's' : '' }}</p>
    </div>
    <a href="{{ route('admin.vehicles.create') }}" class="adm_btn red"><i class="fas fa-plus"></i> Ajouter un véhicule</a>
</div>

@php
    $allVehicles = \App\Models\Vehicle::all();
    $totalCount  = $allVehicles->count();
    $dispoCount  = $allVehicles->where('status','disponible')->count();
    $resvCount   = $allVehicles->where('status','reservee')->count();
    $maintCount  = $allVehicles->where('status','maintenance')->count();
@endphp

<div class="db_stat_grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:24px;">
    <div class="db_stat">
        <div class="db_stat_top"><div class="db_stat_icon"><i class="fas fa-car"></i></div><span class="db_stat_badge">Total</span></div>
        <div class="db_stat_val">{{ $totalCount }}</div>
        <div class="db_stat_label">Véhicules</div>
    </div>
    <div class="db_stat">
        <div class="db_stat_top"><div class="db_stat_icon" style="background:#D1FAE5;color:#065F46;"><i class="fas fa-check-circle"></i></div><span class="db_stat_badge">Dispo</span></div>
        <div class="db_stat_val" style="color:#065F46;">{{ $dispoCount }}</div>
        <div class="db_stat_label">Disponibles</div>
    </div>
    <div class="db_stat">
        <div class="db_stat_top"><div class="db_stat_icon"><i class="fas fa-calendar-check"></i></div><span class="db_stat_badge">Location</span></div>
        <div class="db_stat_val">{{ $resvCount }}</div>
        <div class="db_stat_label">Réservés</div>
    </div>
    <div class="db_stat">
        <div class="db_stat_top"><div class="db_stat_icon" style="background:#FEF3C7;color:#92400E;"><i class="fas fa-tools"></i></div><span class="db_stat_badge">Atelier</span></div>
        <div class="db_stat_val" style="color:#92400E;">{{ $maintCount }}</div>
        <div class="db_stat_label">Maintenance</div>
    </div>
</div>

<form method="GET" action="{{ route('admin.vehicles.index') }}">
<div class="adm_filter_bar">
    <input type="text" name="search" class="adm_search" placeholder="Nom, marque, modèle…" value="{{ request('search') }}">
    <select name="status" class="adm_filter_select" onchange="this.form.submit()">
        <option value="">Tous les statuts</option>
        <option value="disponible"  {{ request('status') === 'disponible'  ? 'selected' : '' }}>Disponibles</option>
        <option value="reservee"    {{ request('status') === 'reservee'    ? 'selected' : '' }}>Réservés</option>
        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>
    <button type="submit" class="adm_btn dark sm"><i class="fas fa-search"></i> Filtrer</button>
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.vehicles.index') }}" class="adm_btn gray sm"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
</form>

<div class="db_panel">
    <table class="db_table">
        <thead>
            <tr>
                <th style="width:64px;">Photo</th>
                <th>Véhicule</th>
                <th>Statut</th>
                <th>Sans chauffeur</th>
                <th>Avec chauffeur</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $v)
            @php $vs = ['disponible'=>'available','reservee'=>'reserved','maintenance'=>'maintenance']; @endphp
            <tr>
                <td>
                    <img src="{{ $v->photo_url }}" alt="{{ $v->name }}"
                         style="width:52px;height:38px;object-fit:cover;border-radius:6px;">
                </td>
                <td>
                    <div class="fw7">{{ $v->name }}</div>
                    <div class="text_muted" style="font-size:11px;">{{ $v->brand }} {{ $v->model }} · {{ $v->year }}</div>
                </td>
                <td>
                    <span class="db_badge {{ $vs[$v->status] ?? 'completed' }}">
                        {{ ['disponible'=>'Disponible','reservee'=>'Réservée','maintenance'=>'Maintenance'][$v->status] ?? $v->status }}
                    </span>
                </td>
                <td class="fw7 no_wrap">{{ number_format($v->price_without_driver) }} <span class="text_muted" style="font-size:11px;font-weight:400;">FCFA/j</span></td>
                <td class="fw7 no_wrap">{{ number_format($v->price_with_driver) }} <span class="text_muted" style="font-size:11px;font-weight:400;">FCFA/j</span></td>
                <td>
                    <div class="gap_row">
                        <a href="{{ route('admin.vehicles.edit', $v) }}" class="adm_btn dark sm"><i class="fas fa-pen"></i> Modifier</a>
                        <button type="button" class="adm_btn outline sm"
                            onclick="openDeleteModal({{ $v->id }}, '{{ addslashes($v->name) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="adm_empty"><i class="fas fa-car"></i><p>Aucun véhicule trouvé</p></div></td></tr>
            @endforelse
        </tbody>
    </table>

    @if($vehicles->hasPages())
    <div class="adm_pager">
        <span>Page {{ $vehicles->currentPage() }} / {{ $vehicles->lastPage() }}</span>
        {{ $vehicles->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Delete hidden forms --}}
@foreach($vehicles as $v)
<form id="deleteForm_{{ $v->id }}" action="{{ route('admin.vehicles.destroy', $v) }}" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

{{-- Delete Modal --}}
<div class="adm_modal_overlay" id="deleteModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Supprimer le véhicule</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <div class="adm_modal_body">
            <p style="font-size:13px;color:#374151;">Supprimer définitivement <strong id="deleteVehicleName"></strong> ? Cette action est irréversible.</p>
        </div>
        <div class="adm_modal_foot">
            <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Annuler</button>
            <button type="button" class="adm_btn red" id="deleteConfirmBtn"><i class="fas fa-trash"></i> Supprimer</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var deleteVehicleId = null;
function openDeleteModal(id, name) {
    deleteVehicleId = id;
    document.getElementById('deleteVehicleName').textContent = name;
    document.getElementById('deleteModal').classList.add('open');
}
document.getElementById('deleteConfirmBtn').addEventListener('click', function() {
    if (deleteVehicleId) document.getElementById('deleteForm_' + deleteVehicleId).submit();
});
</script>
@endpush
