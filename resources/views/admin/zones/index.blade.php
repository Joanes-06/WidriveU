@extends('layouts.admin')
@section('title', 'Zones')
@section('page_title', 'Zones de déploiement')

@section('content')

<div class="adm_page_hd">
    <div><h2>Zones de déploiement</h2><p>Gérez les zones de service disponibles</p></div>
</div>

<div class="adm_grid equal">

    {{-- ADD FORM --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-plus-circle"></i> Ajouter une zone</h3>
            </div>
            <div class="db_panel_body">
                <form method="POST" action="{{ route('admin.zones.store') }}">
                    @csrf
                    <div class="adm_form_group">
                        <label class="adm_form_label">Nom de la zone <span class="req">*</span></label>
                        <input type="text" name="name"
                               class="adm_input {{ $errors->has('name') ? 'is_invalid' : '' }}"
                               value="{{ old('name') }}" placeholder="Ex: Cotonou, Abomey-Calavi…" required>
                        @error('name')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="adm_btn red"><i class="fas fa-plus"></i> Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ZONES LIST --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-map-marker-alt"></i> Zones existantes</h3>
                <span style="font-size:12px;color:#9CA3AF;">{{ $zones->count() }} zone{{ $zones->count() > 1 ? 's' : '' }}</span>
            </div>
            <table class="db_table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Réservations</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                    <tr>
                        <td class="fw7">{{ $zone->name }}</td>
                        <td>
                            @if($zone->reservations_count > 0)
                            <span class="db_badge dark">{{ $zone->reservations_count }}</span>
                            @else
                            <span class="text_muted">0</span>
                            @endif
                        </td>
                        <td>
                            <div class="gap_row">
                                <button type="button" class="tc_icon_btn" title="Modifier"
                                    onclick="openEditModal({{ $zone->id }}, '{{ addslashes($zone->name) }}')">
                                    <i class="fas fa-pen" style="color:#374151;"></i>
                                </button>
                                @if($zone->reservations_count > 0)
                                <button type="button" class="tc_icon_btn" title="Ne peut pas être supprimée (réservations liées)" disabled style="opacity:0.4;cursor:not-allowed;">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @else
                                <button type="button" class="tc_icon_btn red" title="Supprimer"
                                    onclick="openDeleteModal({{ $zone->id }}, '{{ addslashes($zone->name) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3"><div class="adm_empty"><i class="fas fa-map-marker-alt"></i><p>Aucune zone</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Delete hidden forms --}}
@foreach($zones as $zone)
<form id="deleteZone_{{ $zone->id }}" action="{{ route('admin.zones.destroy', $zone) }}" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

{{-- Edit Modal --}}
<div class="adm_modal_overlay" id="editModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Modifier la zone</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form id="editZoneForm" method="POST">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <div class="adm_form_group">
                    <label class="adm_form_label">Nom de la zone</label>
                    <input type="text" name="name" id="editZoneName" class="adm_input" required>
                </div>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Annuler</button>
                <button type="submit" class="adm_btn dark"><i class="fas fa-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div class="adm_modal_overlay" id="deleteZoneModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Supprimer la zone</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <div class="adm_modal_body">
            <p style="font-size:13px;color:#374151;">Supprimer la zone <strong id="deleteZoneName"></strong> ? Cette action est irréversible.</p>
        </div>
        <div class="adm_modal_foot">
            <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Annuler</button>
            <button type="button" class="adm_btn red" id="deleteZoneConfirm"><i class="fas fa-trash"></i> Supprimer</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var deleteZoneId = null;
function openEditModal(id, name) {
    document.getElementById('editZoneForm').action = '/admin/zones/' + id;
    document.getElementById('editZoneName').value = name;
    document.getElementById('editModal').classList.add('open');
}
function openDeleteModal(id, name) {
    deleteZoneId = id;
    document.getElementById('deleteZoneName').textContent = name;
    document.getElementById('deleteZoneModal').classList.add('open');
}
document.getElementById('deleteZoneConfirm').addEventListener('click', function() {
    if (deleteZoneId) document.getElementById('deleteZone_' + deleteZoneId).submit();
});
</script>
@endpush
