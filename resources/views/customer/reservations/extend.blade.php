@extends('layouts.dashboard')

@section('title', 'Prolonger — ' . $reservation->reservation_number)
@section('page_title', 'Prolonger la réservation')

@push('styles')
<style>
    /* ── SHARED PANEL ─────────────────────────────── */
    .db_panel {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .db_panel_head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #F3F4F6;
        gap: 10px;
    }
    .db_panel_title {
        font-family: 'Sora', sans-serif;
        font-size: 14px; font-weight: 700; color: #111827;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .db_panel_title i { color: #860000; font-size: 13px; }

    /* ── BACK ─────────────────────────────────────── */
    .ex_back {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 700; color: #9CA3AF;
        text-decoration: none; text-transform: uppercase; letter-spacing: 0.4px;
        margin-bottom: 18px; transition: color 0.15s;
    }
    .ex_back:hover { color: #860000; text-decoration: none; }

    /* ── STAT BLOCKS ──────────────────────────────── */
    .ex_stats {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }
    .ex_stat {
        background: #fff;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
    }
    .ex_stat_label {
        font-size: 10px; font-weight: 700; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.6px;
        margin-bottom: 6px;
    }
    .ex_stat_val {
        font-family: 'Sora', sans-serif;
        font-size: 18px; font-weight: 800; color: #111827;
        line-height: 1.1;
    }
    .ex_stat_sub {
        font-size: 10px; color: #9CA3AF; margin-top: 3px;
    }
    .ex_stat.accent .ex_stat_val { color: #860000; }

    /* ── SUMMARY BAR ──────────────────────────────── */
    .ex_summary_bar {
        background: #111827;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    }
    .ex_summary_bar .item {
        font-size: 12px; color: rgba(255,255,255,0.65);
        display: flex; align-items: center; gap: 6px;
    }
    .ex_summary_bar .item strong { color: #fff; }
    .ex_summary_bar .sep { width: 1px; height: 16px; background: rgba(255,255,255,0.12); }

    /* ── GRID ─────────────────────────────────────── */
    .ex_grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }

    /* ── FORM ─────────────────────────────────────── */
    .ex_form { padding: 22px 24px; }
    .ex_field { margin-bottom: 18px; }
    .ex_field:last-child { margin-bottom: 0; }
    .ex_label {
        display: block;
        font-family: 'Sora', sans-serif;
        font-size: 11px; font-weight: 700; color: #374151;
        text-transform: uppercase; letter-spacing: 0.4px;
        margin-bottom: 6px;
    }
    .ex_input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #E5E7EB; border-radius: 8px;
        font-family: var(--font-body); font-size: 13px;
        color: #111827; background: #FAFBFC;
        outline: none; transition: border-color 0.15s;
        box-sizing: border-box;
    }
    .ex_input:focus { border-color: #860000; background: #fff; }
    .ex_hint { font-size: 11px; color: #9CA3AF; margin-top: 4px; }

    .ex_row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* ── PREVIEW BLOCK ────────────────────────────── */
    .ex_preview {
        background: #F5F6FA;
        border-radius: 10px;
        padding: 16px 18px;
        margin-top: 16px;
        display: none;
    }
    .ex_preview_title {
        font-family: 'Sora', sans-serif;
        font-size: 11px; font-weight: 700; color: #374151;
        text-transform: uppercase; letter-spacing: 0.4px;
        margin-bottom: 12px;
        display: flex; align-items: center; gap: 6px;
    }
    .ex_preview_title i { color: #860000; }
    .ex_prow {
        display: flex; align-items: center; justify-content: space-between;
        padding: 7px 0; border-bottom: 1px solid #E5E7EB;
        font-size: 12px;
    }
    .ex_prow:last-child { border-bottom: none; }
    .ex_prow .plabel { color: #9CA3AF; }
    .ex_prow .pval   { font-weight: 700; color: #111827; }
    .ex_prow.ptotal  { margin-top: 4px; padding-top: 10px; border-top: 2px solid #111827; border-bottom: none; }
    .ex_prow.ptotal  .pval { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 800; color: #860000; }
    .ex_prow.pdiscount .pval { color: #059669; }

    /* ── FORM FOOTER ──────────────────────────────── */
    .ex_form_footer {
        padding: 14px 24px;
        border-top: 1px solid #F3F4F6;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px;
    }
    .ex_terms {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; color: #6B7280; cursor: pointer;
    }
    .ex_terms input[type="checkbox"] { width: 15px; height: 15px; cursor: pointer; accent-color: #860000; }
    .ex_submit {
        display: inline-flex; align-items: center; gap: 7px;
        background: #860000; color: #fff;
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        padding: 11px 24px; border-radius: 8px; border: none; cursor: pointer;
        text-transform: uppercase; letter-spacing: 0.3px;
        transition: opacity 0.15s;
    }
    .ex_submit:hover:not(:disabled) { opacity: 0.85; }
    .ex_submit:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ── SIDEBAR INFO ─────────────────────────────── */
    .ex_info_row {
        display: flex; align-items: center; gap: 12px;
        padding: 13px 20px; border-bottom: 1px solid #F3F4F6;
    }
    .ex_info_row:last-child { border-bottom: none; }
    .ex_info_icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: #F3F4F6; color: #374151;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; flex-shrink: 0;
    }
    .ex_info_lbl { font-size: 10px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
    .ex_info_val { font-size: 13px; font-weight: 600; color: #111827; margin-top: 1px; }

    /* ── DISCOUNT TIERS CARD ──────────────────────── */
    .ex_tiers {
        background: #fff;
        border-radius: 12px;
        padding: 20px 22px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.05);
    }
    .ex_tiers_title {
        font-family: 'Sora', sans-serif;
        font-size: 15px; font-weight: 800; color: #111827;
        margin-bottom: 14px;
    }
    .ex_tier_item {
        display: flex; align-items: center; gap: 8px;
        padding: 6px 0;
        font-size: 13px; color: #111827;
    }
    .ex_tier_icon {
        color: #860000; font-size: 12px; flex-shrink: 0;
    }
    .ex_tier_text strong {
        font-weight: 800; color: #111827;
    }
    /* active highlight updated by JS */
    .ex_tier_item.active_tier .ex_tier_text strong {
        color: #860000;
    }

    /* ── ERROR BLOCK ──────────────────────────────── */
    .ex_error_block {
        background: #FEF2F2; border-radius: 12px;
        padding: 24px; text-align: center;
    }
    .ex_error_block i { font-size: 32px; color: #DC2626; margin-bottom: 12px; }
    .ex_error_block h3 { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: #991B1B; margin-bottom: 8px; }
    .ex_error_block p { font-size: 13px; color: #B91C1C; margin-bottom: 16px; }

    @media (max-width: 900px) {
        .ex_stats { grid-template-columns: 1fr 1fr; }
        .ex_grid  { grid-template-columns: 1fr; }
        .ex_row2  { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .ex_stats { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@php
    $totalHoursLeft = max(0, (int) now()->diffInHours($reservation->end_date->endOfDay(), false));
    $daysLeft       = (int) floor($totalHoursLeft / 24);
    $remainHours    = $totalHoursLeft % 24;
    $basePrice = $reservation->type === 'avec_chauffeur'
        ? $reservation->vehicle->price_with_driver
        : $reservation->vehicle->price_without_driver;
    $currentDiscount = \App\Models\Reservation::getDiscountPercentage($reservation->days);
@endphp

<a href="{{ route('reservations.show', $reservation) }}" class="ex_back">
    <i class="fas fa-chevron-left"></i> Retour au détail
</a>

{{-- Erreurs de session --}}
@if(session('error') || $errors->any())
<div style="background:#FEE2E2;border-radius:10px;padding:14px 18px;margin-bottom:18px;display:flex;align-items:flex-start;gap:10px;">
    <i class="fas fa-exclamation-circle" style="color:#DC2626;margin-top:2px;flex-shrink:0;"></i>
    <div style="font-size:12px;color:#991B1B;">
        @if(session('error'))
            {{ session('error') }}
        @endif
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

{{-- STAT BLOCKS ─────────────────────────────────────────────── --}}
<div class="ex_stats">
    <div class="ex_stat">
        <div class="ex_stat_label">Début de location</div>
        <div class="ex_stat_val">{{ $reservation->start_date->format('d/m/Y') }}</div>
        @if($reservation->departure_time)
            <div class="ex_stat_sub">à {{ $reservation->departure_time }}</div>
        @endif
    </div>
    <div class="ex_stat">
        <div class="ex_stat_label">Fin actuelle</div>
        <div class="ex_stat_val">{{ $reservation->end_date->format('d/m/Y') }}</div>
        @if($reservation->return_time)
            <div class="ex_stat_sub">à {{ $reservation->return_time }}</div>
        @endif
    </div>
    <div class="ex_stat {{ $totalHoursLeft > 0 ? 'accent' : '' }}">
        <div class="ex_stat_label">Temps restant</div>
        @if($totalHoursLeft > 0)
            <div class="ex_stat_val">{{ $daysLeft > 0 ? $daysLeft . 'j ' : '' }}{{ $remainHours }}h</div>
            <div class="ex_stat_sub">{{ $totalHoursLeft }} heures exactement</div>
        @else
            <div class="ex_stat_val" style="color:#DC2626;">Expirée</div>
            <div class="ex_stat_sub">La location est terminée</div>
        @endif
    </div>
</div>

{{-- SUMMARY BAR ─────────────────────────────────────────────── --}}
<div class="ex_summary_bar">
    <div class="item"><i class="fas fa-calendar-alt"></i> <strong>{{ $reservation->days }} jours</strong> au total</div>
    <div class="sep"></div>
    <div class="item"><i class="fas fa-money-bill-wave"></i> <strong>{{ number_format($reservation->total) }} FCFA</strong> déjà payés</div>
    <div class="sep"></div>
    <div class="item"><i class="fas fa-car"></i> <strong>{{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}</strong></div>
    <div class="sep"></div>
    <div class="item"><i class="fas fa-tag"></i> <strong>{{ number_format($basePrice) }} FCFA/j</strong></div>
</div>

{{-- CAN'T EXTEND ERROR ──────────────────────────────────────── --}}
@php $blockReason = $reservation->extendBlockReason(); @endphp
@if($blockReason)
<div class="ex_error_block">
    <div><i class="fas fa-exclamation-circle"></i></div>
    <h3>Prolongation impossible</h3>
    <p>{{ $blockReason }}</p>
    <a href="{{ route('reservations.show', $reservation) }}"
       style="display:inline-flex;align-items:center;gap:7px;background:#111827;color:#fff;padding:11px 20px;border-radius:8px;font-family:'Sora',sans-serif;font-size:12px;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:0.3px;">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
@else

{{-- FORM GRID ───────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('reservations.extend', $reservation) }}" id="extendForm">
    @csrf

<div class="ex_grid">

    {{-- LEFT: FORM ────────────────────────────────────────── --}}
    <div>

        {{-- Nouvelle date ──────────────────────────────────── --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-calendar-plus"></i> Extension</h3>
            </div>
            <div class="ex_form">

                <div class="ex_row2">
                    <div class="ex_field">
                        <label class="ex_label" for="new_end_date">Nouvelle date de fin</label>
                        <input type="date"
                               id="new_end_date"
                               name="new_end_date"
                               class="ex_input"
                               min="{{ $reservation->end_date->addDay()->format('Y-m-d') }}"
                               value="{{ old('new_end_date') }}"
                               required>
                        <div class="ex_hint">Minimum le {{ $reservation->end_date->addDay()->format('d/m/Y') }}</div>
                    </div>
                    <div class="ex_field">
                        <label class="ex_label" for="new_return_time">Heure de retour</label>
                        <input type="time"
                               id="new_return_time"
                               name="new_return_time"
                               class="ex_input"
                               value="{{ old('new_return_time', $reservation->return_time) }}">
                        <div class="ex_hint">Pré-remplie avec l'heure actuelle</div>
                    </div>
                </div>

                {{-- Preview résumé ─────────────────────────── --}}
                <div class="ex_preview" id="preview_block">
                    <div class="ex_preview_title"><i class="fas fa-calculator"></i> Résumé de l'extension</div>

                    <div class="ex_prow">
                        <span class="plabel">Nouvelle date de fin</span>
                        <span class="pval" id="prev_new_end">—</span>
                    </div>
                    <div class="ex_prow">
                        <span class="plabel">Jours supplémentaires</span>
                        <span class="pval" id="prev_extra_days">—</span>
                    </div>
                    <div class="ex_prow">
                        <span class="plabel">Durée totale</span>
                        <span class="pval" id="prev_total_days">—</span>
                    </div>
                    <div class="ex_prow">
                        <span class="plabel">Sous-total extension</span>
                        <span class="pval" id="prev_subtotal">—</span>
                    </div>
                    <div class="ex_prow pdiscount" id="prev_discount_row" style="display:none;">
                        <span class="plabel">Réduction (<span id="prev_discount_pct">0</span>%)</span>
                        <span class="pval" id="prev_discount_amt">—</span>
                    </div>
                    <div class="ex_prow ptotal">
                        <span class="plabel" style="font-weight:700;color:#111827;">Total à payer</span>
                        <span class="pval" id="prev_total">—</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Contact ────────────────────────────────────────── --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-address-card"></i> Contact & lieu</h3>
            </div>
            <div class="ex_form">

                <div class="ex_row2">
                    <div class="ex_field">
                        <label class="ex_label" for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" class="ex_input"
                               value="{{ old('email', $reservation->email) }}" required>
                    </div>
                    <div class="ex_field">
                        <label class="ex_label" for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" class="ex_input"
                               value="{{ old('phone', $reservation->phone) }}" required>
                    </div>
                </div>

                <div class="ex_field">
                    <label class="ex_label" for="current_position">Lieu de prise en charge</label>
                    <input type="text" id="current_position" name="current_position" class="ex_input"
                           value="{{ old('current_position', $reservation->current_position) }}"
                           placeholder="Adresse de départ">
                </div>

                <div class="ex_field">
                    <label class="ex_label" for="zone_id">Zone de déploiement</label>
                    <select id="zone_id" name="zone_id" class="ex_input">
                        <option value="">— Aucune zone —</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}"
                                {{ old('zone_id', $reservation->zone_id) == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }}
                                @if($zone->extra_fee > 0) (+{{ number_format($zone->extra_fee) }} FCFA)@endif
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            {{-- hidden fields remplis par JS avant soumission --}}
            <input type="hidden" name="transaction_id" id="kkiapay_txn_id">
            <input type="hidden" name="computed_amount" id="computed_amount" value="0">

            <div class="ex_form_footer">
                <label class="ex_terms">
                    <input type="checkbox" id="terms_check">
                    J'accepte les conditions générales de location
                </label>
                <button type="button" class="ex_submit" id="submit_btn" disabled>
                    <i class="fas fa-credit-card"></i> Procéder au paiement
                </button>
            </div>

            {{-- message d'erreur paiement --}}
            <div id="pay_error" style="display:none;margin:0 24px 16px;background:#FEE2E2;border-radius:8px;padding:12px 16px;font-size:12px;color:#991B1B;display:none;align-items:center;gap:8px;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="pay_error_msg">Le paiement a échoué. Veuillez réessayer.</span>
            </div>
        </div>

    </div>
    {{-- END LEFT ────────────────────────────────────────────── --}}

    {{-- RIGHT: SIDEBAR ───────────────────────────────────────── --}}
    <div>

        {{-- Récapitulatif réservation ─────────────────────── --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-car"></i> Réservation actuelle</h3>
            </div>
            <div class="ex_info_row">
                <div class="ex_info_icon"><i class="fas fa-hashtag"></i></div>
                <div>
                    <div class="ex_info_lbl">N° réservation</div>
                    <div class="ex_info_val">{{ $reservation->reservation_number }}</div>
                </div>
            </div>
            <div class="ex_info_row">
                <div class="ex_info_icon"><i class="fas fa-car"></i></div>
                <div>
                    <div class="ex_info_lbl">Véhicule</div>
                    <div class="ex_info_val">{{ $reservation->vehicle->name ?? '—' }}</div>
                </div>
            </div>
            <div class="ex_info_row">
                <div class="ex_info_icon"><i class="fas fa-calendar"></i></div>
                <div>
                    <div class="ex_info_lbl">Période actuelle</div>
                    <div class="ex_info_val">
                        {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            <div class="ex_info_row">
                <div class="ex_info_icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="ex_info_lbl">Durée actuelle</div>
                    <div class="ex_info_val">{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</div>
                </div>
            </div>
        </div>

        {{-- Paliers de réduction ─────────────────────────── --}}
        <div class="ex_tiers">
            <div class="ex_tiers_title">Réductions disponibles</div>

            <div class="ex_tier_item" id="tier_7">
                <i class="fas fa-tag ex_tier_icon"></i>
                <span class="ex_tier_text">Location 7–13 jours : <strong>−15%</strong></span>
            </div>
            <div class="ex_tier_item" id="tier_14">
                <i class="fas fa-tag ex_tier_icon"></i>
                <span class="ex_tier_text">Location 14–20 jours : <strong>−18%</strong></span>
            </div>
            <div class="ex_tier_item" id="tier_21">
                <i class="fas fa-tag ex_tier_icon"></i>
                <span class="ex_tier_text">Location 21+ jours : <strong>−20%</strong></span>
            </div>
        </div>

    </div>
    {{-- END RIGHT ───────────────────────────────────────────── --}}

</div>
</form>
@endif

@endsection

@push('scripts')
{{-- KKiaPay SDK --}}
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
(function () {

    const BASE_DAYS    = {{ (int) $reservation->days }};
    const DAILY_RATE   = {{ (int) $basePrice }};
    const END_DATE_STR = "{{ $reservation->end_date->format('Y-m-d') }}";

    // Montant calculé, partagé avec les listeners KKiaPay
    let currentTotal = 0;

    function getDiscountPct(totalDays) {
        if (totalDays >= 21) return 20;
        if (totalDays >= 14) return 18;
        if (totalDays >= 7)  return 15;
        return 0;
    }

    function fmtNum(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '\u00a0');
    }

    function fmtDate(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }

    function updateTiers(totalDays) {
        ['tier_7', 'tier_14', 'tier_21'].forEach(function(id) {
            document.getElementById(id).classList.remove('active_tier');
        });
        if (totalDays >= 21)      document.getElementById('tier_21').classList.add('active_tier');
        else if (totalDays >= 14) document.getElementById('tier_14').classList.add('active_tier');
        else if (totalDays >= 7)  document.getElementById('tier_7').classList.add('active_tier');
    }

    function updatePreview(newEndDateStr) {
        if (!newEndDateStr) {
            document.getElementById('preview_block').style.display = 'none';
            currentTotal = 0;
            document.getElementById('computed_amount').value = 0;
            return;
        }

        const endDate   = new Date(END_DATE_STR + 'T00:00:00');
        const newEnd    = new Date(newEndDateStr + 'T00:00:00');
        const extraDays = Math.round((newEnd - endDate) / 86400000);

        if (extraDays <= 0) {
            document.getElementById('preview_block').style.display = 'none';
            currentTotal = 0;
            document.getElementById('computed_amount').value = 0;
            return;
        }

        const totalDays   = BASE_DAYS + extraDays;
        const subtotal    = DAILY_RATE * extraDays;
        const discountPct = getDiscountPct(totalDays);
        const discountAmt = Math.round(subtotal * discountPct / 100);
        const total       = subtotal - discountAmt;

        // Mettre à jour le montant partagé
        currentTotal = total;
        document.getElementById('computed_amount').value = total;

        // Mettre à jour l'affichage du résumé
        document.getElementById('prev_new_end').textContent    = fmtDate(newEndDateStr);
        document.getElementById('prev_extra_days').textContent = extraDays + ' jour' + (extraDays > 1 ? 's' : '');
        document.getElementById('prev_total_days').textContent = totalDays + ' jours au total';
        document.getElementById('prev_subtotal').textContent   = fmtNum(subtotal) + ' FCFA';
        document.getElementById('prev_total').textContent      = fmtNum(total) + ' FCFA';

        if (discountPct > 0) {
            document.getElementById('prev_discount_row').style.display = '';
            document.getElementById('prev_discount_pct').textContent   = discountPct + '%';
            document.getElementById('prev_discount_amt').textContent   = '− ' + fmtNum(discountAmt) + ' FCFA';
        } else {
            document.getElementById('prev_discount_row').style.display = 'none';
        }

        document.getElementById('preview_block').style.display = 'block';
        updateTiers(totalDays);
        updateBtn();
    }

    function updateBtn() {
        const dateOk  = document.getElementById('new_end_date').value !== '' && currentTotal > 0;
        const termsOk = document.getElementById('terms_check').checked;
        document.getElementById('submit_btn').disabled = !(dateOk && termsOk);
    }

    // ── Listeners ─────────────────────────────────────────────
    document.getElementById('new_end_date').addEventListener('change', function () {
        updatePreview(this.value);
    });
    document.getElementById('terms_check').addEventListener('change', updateBtn);

    // Restaurer si old() présent (erreur validation)
    if (document.getElementById('new_end_date').value) {
        updatePreview(document.getElementById('new_end_date').value);
    }

    // ── Bouton → ouvrir KKiaPay ───────────────────────────────
    document.getElementById('submit_btn').addEventListener('click', function () {
        if (currentTotal <= 0) return;

        var phoneRaw = document.getElementById('phone').value.replace(/\D/g, '');
        var name     = "{{ addslashes(auth()->user()->name) }}";
        var email    = document.getElementById('email').value;

        openKkiapayWidget({
            amount:  currentTotal,
            api_key: "{{ config('kkiapay.public_key') }}",
            sandbox: {{ config('kkiapay.sandbox') ? 'true' : 'false' }},
            phone:   phoneRaw,
            name:    name,
            email:   email,
            data:    "EXT-{{ $reservation->reservation_number }}",
        });
    });

    // ── KKiaPay succès → soumettre le formulaire ──────────────
    addSuccessListener(function (response) {
        document.getElementById('kkiapay_txn_id').value = response.transactionId;
        document.getElementById('extendForm').submit();
    });

    // ── KKiaPay échec → afficher message ─────────────────────
    addFailedListener(function () {
        var errDiv = document.getElementById('pay_error');
        errDiv.style.display = 'flex';
        window.scrollTo({ top: errDiv.offsetTop - 100, behavior: 'smooth' });
    });

})();
</script>
@endpush
