@extends('layouts.admin')
@section('title', 'Réservations en cours')
@section('page_title', 'Réservations en cours')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Réservations en cours</h2>
        <p>Locations actives à ce jour</p>
    </div>
    <a href="{{ route('admin.reservations.create') }}" class="adm_btn red"><i class="fas fa-plus"></i> Créer</a>
</div>

<div class="db_stat_grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:24px;">
    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-play-circle"></i></div>
            <span class="db_stat_badge">Actives</span>
        </div>
        <div class="db_stat_val">{{ $stats['count'] ?? $reservations->count() }}</div>
        <div class="db_stat_label">En cours</div>
    </div>
    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-coins"></i></div>
            <span class="db_stat_badge">Revenus</span>
        </div>
        <div class="db_stat_val" style="font-size:20px;">{{ number_format($stats['revenue'] ?? 0) }}</div>
        <div class="db_stat_label">FCFA actifs</div>
    </div>
    <div class="db_stat">
        <div class="db_stat_top">
            <div class="db_stat_icon"><i class="fas fa-hourglass-half"></i></div>
            <span class="db_stat_badge">Durée</span>
        </div>
        <div class="db_stat_val">{{ $stats['avg_days'] ?? '—' }}j</div>
        <div class="db_stat_label">Durée moyenne</div>
    </div>
    <div class="db_stat" style="border-color:#FEF3C7;background:#FFFBEB;">
        <div class="db_stat_top">
            <div class="db_stat_icon" style="background:#FEF3C7;color:#92400E;"><i class="fas fa-exclamation-triangle"></i></div>
            <span class="db_stat_badge" style="color:#92400E;">Urgent</span>
        </div>
        <div class="db_stat_val" style="color:#92400E;">{{ $stats['expiring_soon'] ?? 0 }}</div>
        <div class="db_stat_label" style="color:#92400E;">Expirent ≤ 48h</div>
    </div>
</div>

<div class="db_panel">
    <table class="db_table">
        <thead>
            <tr>
                <th>N° Réservation</th>
                <th>Client</th>
                <th>Véhicule</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Temps restant</th>
                <th>Ext.</th>
                <th>Montant</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $r)
            @php
                $endDt = $r->end_date->copy();
                if ($r->return_time) {
                    $parts = explode(':', $r->return_time);
                    $endDt->setTime((int)$parts[0], (int)($parts[1] ?? 0));
                } else {
                    $endDt->setTime(23, 59);
                }
                $hoursLeft = (int) now()->diffInHours($endDt, false);
                $daysLeft  = (int) floor(max(0, $hoursLeft) / 24);
                $hLeft     = max(0, $hoursLeft) % 24;
                $isOverdue = $hoursLeft < 0;
                $isUrgent  = !$isOverdue && $hoursLeft <= 48;
            @endphp
            <tr class="clickable" onclick="window.location='{{ route('admin.reservations.show', $r) }}'">
                <td class="mono text_muted">{{ $r->reservation_number }}</td>
                <td class="fw7">{{ $r->user->name ?? '—' }}</td>
                <td class="text_muted">{{ $r->vehicle->name ?? '—' }}</td>
                <td class="no_wrap" style="font-size:12px;">{{ $r->start_date->format('d/m/Y') }}</td>
                <td class="no_wrap" style="font-size:12px;">{{ $r->end_date->format('d/m/Y') }}</td>
                <td>
                    @if($isOverdue)
                        <span class="db_badge cancelled">Expiré</span>
                    @elseif($isUrgent)
                        <span class="db_badge pending">{{ $daysLeft > 0 ? $daysLeft.'j ' : '' }}{{ $hLeft }}h</span>
                    @else
                        <span class="db_badge active">{{ $daysLeft > 0 ? $daysLeft.'j ' : '' }}{{ $hLeft }}h</span>
                    @endif
                </td>
                <td>
                    @php $extCount = $r->extensions->count(); @endphp
                    @if($extCount > 0)
                    <span class="db_badge dark">+{{ $extCount }}</span>
                    @else
                    <span class="text_muted">—</span>
                    @endif
                </td>
                <td class="fw7 no_wrap">{{ number_format($r->total) }} <span class="text_muted" style="font-size:11px;font-weight:400;">FCFA</span></td>
                <td onclick="event.stopPropagation();">
                    <div class="gap_row">
                        <a href="{{ route('admin.reservations.show', $r) }}" class="tc_icon_btn dark"><i class="fas fa-eye"></i></a>
                        <button type="button" class="tc_icon_btn" title="Terminer"
                            onclick="openCompleteModal({{ $r->id }}, '{{ $r->reservation_number }}')">
                            <i class="fas fa-check" style="color:#059669;"></i>
                        </button>
                        <button type="button" class="tc_icon_btn" title="Annuler"
                            onclick="openCancelModal({{ $r->id }}, '{{ $r->reservation_number }}')">
                            <i class="fas fa-times" style="color:#860000;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="9"><div class="adm_empty"><i class="fas fa-check-circle" style="color:#D1FAE5;"></i><p>Aucune réservation en cours</p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

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

{{-- Cancel Modal --}}
<div class="adm_modal_overlay" id="cancelModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Annuler la réservation</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form id="cancelForm" method="POST">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;margin-bottom:16px;">Annuler <strong id="cancelNum"></strong> ?</p>
                <div class="adm_form_group">
                    <label class="adm_form_label">Motif</label>
                    <textarea name="cancellation_reason" class="adm_input adm_textarea" placeholder="Raison…"></textarea>
                </div>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Fermer</button>
                <button type="submit" class="adm_btn red"><i class="fas fa-times"></i> Confirmer</button>
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
function openCancelModal(id, num) {
    document.getElementById('cancelForm').action = '/admin/reservations/' + id + '/annuler';
    document.getElementById('cancelNum').textContent = num;
    document.getElementById('cancelModal').classList.add('open');
}
</script>
@endpush
