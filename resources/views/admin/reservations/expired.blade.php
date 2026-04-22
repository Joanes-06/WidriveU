@extends('layouts.admin')
@section('title', 'Réservations expirées')
@section('page_title', 'Réservations expirées')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Réservations expirées</h2>
        <p>Réservations actives dont la date de fin est dépassée</p>
    </div>
</div>

@if($reservations->count() === 0)
<div class="db_panel">
    <div class="adm_empty">
        <i class="fas fa-check-circle" style="color:#D1FAE5;font-size:48px;"></i>
        <p style="font-weight:700;font-size:15px;">Aucune réservation expirée</p>
        <span>Toutes les locations actives sont dans les délais.</span>
    </div>
</div>
@else

<div class="flash_msg warning" style="margin-bottom:20px;">
    <i class="fas fa-exclamation-triangle"></i>
    <span>Ces réservations sont actives mais leur date de fin est dépassée. Pensez à les clôturer ou à rendre les véhicules disponibles.</span>
</div>

<div class="db_panel">
    <table class="db_table">
        <thead>
            <tr>
                <th>N° Réservation</th>
                <th>Client</th>
                <th>Véhicule</th>
                <th>Date de fin prévue</th>
                <th>Dépassement</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $r)
            @php
                $overdueDays = (int) $r->end_date->diffInDays(now(), false);
            @endphp
            <tr class="clickable" onclick="window.location='{{ route('admin.reservations.show', $r) }}'">
                <td class="mono text_muted">{{ $r->reservation_number }}</td>
                <td class="fw7">{{ $r->user->name ?? '—' }}</td>
                <td class="text_muted">{{ $r->vehicle->name ?? '—' }}</td>
                <td class="no_wrap" style="font-size:12px;">{{ $r->end_date->format('d/m/Y') }}</td>
                <td>
                    <span class="db_badge cancelled">+{{ $overdueDays }}j de retard</span>
                </td>
                <td class="fw7 no_wrap">{{ number_format($r->total) }} <span class="text_muted" style="font-size:11px;font-weight:400;">FCFA</span></td>
                <td onclick="event.stopPropagation();">
                    <div class="gap_row">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="tc_icon_btn dark"><i class="fas fa-eye"></i></a>
                        <button type="button" class="tc_icon_btn" title="Terminer"
                            onclick="openCompleteModal({{ $r->id }}, '{{ $r->reservation_number }}')">
                            <i class="fas fa-check" style="color:#059669;"></i>
                        </button>
                        <button type="button" class="tc_icon_btn" title="Rendre disponible"
                            onclick="openAvailableModal({{ $r->id }}, '{{ $r->vehicle->name ?? '' }}')">
                            <i class="fas fa-car" style="color:#6B7280;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Complete Modal --}}
<div class="adm_modal_overlay" id="completeModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Terminer la réservation</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form id="completeForm" method="POST">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;">Marquer <strong id="completeNum"></strong> comme terminée ? Le véhicule redeviendra disponible.</p>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Annuler</button>
                <button type="submit" class="adm_btn dark"><i class="fas fa-check"></i> Confirmer</button>
            </div>
        </form>
    </div>
</div>

{{-- Available Modal --}}
<div class="adm_modal_overlay" id="availableModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Rendre le véhicule disponible</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form id="availableForm" method="POST">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;">Remettre <strong id="availableVehicle"></strong> en statut disponible ?</p>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Annuler</button>
                <button type="submit" class="adm_btn dark"><i class="fas fa-car"></i> Confirmer</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openCompleteModal(id, num) {
    document.getElementById('completeForm').action = '/admin/reservations/' + id + '/terminer';
    document.getElementById('completeNum').textContent = num;
    document.getElementById('completeModal').classList.add('open');
}
function openAvailableModal(id, vehicle) {
    document.getElementById('availableForm').action = '/admin/reservations/' + id + '/disponible';
    document.getElementById('availableVehicle').textContent = vehicle;
    document.getElementById('availableModal').classList.add('open');
}
</script>
@endpush
