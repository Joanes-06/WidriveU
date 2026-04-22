@extends('layouts.admin')
@section('title', 'Créer une réservation')
@section('page_title', 'Créer une réservation')

@section('content')

<a href="{{ route('admin.reservations.index') }}" class="adm_back"><i class="fas fa-chevron-left"></i> Retour aux réservations</a>

<div class="adm_page_hd">
    <div><h2>Créer une réservation</h2></div>
</div>

<form method="POST" action="{{ route('admin.reservations.store') }}" id="reservationForm">
@csrf

<div class="adm_grid wide">

    {{-- LEFT --}}
    <div>

        {{-- Client --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-user"></i> Client</h3>
            </div>
            <div class="db_panel_body">

                {{-- Toggle mode --}}
                <div style="display:flex;border:1.5px solid #E5E7EB;border-radius:6px;overflow:hidden;margin-bottom:20px;">
                    <button type="button" id="btnExisting" onclick="setMode('existing')"
                        style="flex:1;padding:11px;font-size:13px;font-weight:600;border:none;cursor:pointer;background:#111827;color:#fff;transition:all .2s;">
                        <i class="fas fa-search"></i> Client inscrit
                    </button>
                    <button type="button" id="btnWalkin" onclick="setMode('walkin')"
                        style="flex:1;padding:11px;font-size:13px;font-weight:600;border:none;cursor:pointer;background:#F5F6FA;color:#9CA3AF;transition:all .2s;">
                        <i class="fas fa-user-plus"></i> Nouveau (présentiel)
                    </button>
                </div>

                {{-- Mode : client existant --}}
                <div id="modeExisting">
                    <input type="hidden" name="client_mode" value="existing" id="clientModeInput">
                    <input type="hidden" name="user_id" id="userIdHidden" value="{{ old('user_id', request('user_id')) }}">
                    <div class="adm_form_group" style="position:relative;">
                        <label class="adm_form_label">Rechercher un client inscrit</label>
                        <div style="position:relative;">
                            <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3AF;pointer-events:none;"></i>
                            <input type="text" id="clientSearch" class="adm_input {{ $errors->has('user_id') ? 'is_invalid' : '' }}"
                                   placeholder="Tapez un nom ou email…"
                                   autocomplete="off"
                                   style="padding-left:36px;"
                                   value="{{ old('user_id') ? ($clients->find(old('user_id'))?->name.' — '.($clients->find(old('user_id'))?->email ?? '')) : '' }}">
                        </div>
                        <div id="clientDropdown" style="display:none;position:absolute;left:0;right:0;top:100%;z-index:999;background:#fff;border:1.5px solid #E5E7EB;border-top:none;border-radius:0 0 6px 6px;max-height:220px;overflow-y:auto;box-shadow:0 4px 12px rgba(0,0,0,0.08);"></div>
                        @error('user_id')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_row cols2">
                        <div class="adm_form_group">
                            <label class="adm_form_label">Email</label>
                            <input type="email" name="existing_email" id="clientEmail" class="adm_input"
                                   value="{{ old('existing_email') }}" placeholder="Pré-rempli automatiquement">
                        </div>
                        <div class="adm_form_group">
                            <label class="adm_form_label">Téléphone</label>
                            <input type="tel" name="existing_phone" id="clientPhone" class="adm_input"
                                   value="{{ old('existing_phone') }}" placeholder="Pré-rempli automatiquement">
                        </div>
                    </div>
                </div>

                {{-- Mode : nouveau client présentiel --}}
                <div id="modeWalkin" style="display:none;">
                    <div style="background:#FEF3C7;border:1px solid #FCD34D;border-radius:6px;padding:12px 15px;margin-bottom:16px;font-size:13px;color:#92400E;">
                        <i class="fas fa-info-circle" style="margin-right:6px;"></i>
                        Un compte client sera créé automatiquement. Le client pourra s'y connecter plus tard.
                    </div>
                    <div class="adm_form_row cols2">
                        <div class="adm_form_group">
                            <label class="adm_form_label">Prénom <span class="req">*</span></label>
                            <input type="text" name="walkin_firstname" class="adm_input {{ $errors->has('walkin_firstname') ? 'is_invalid' : '' }}"
                                   value="{{ old('walkin_firstname') }}" placeholder="Prénom">
                            @error('walkin_firstname')<span class="adm_form_error">{{ $message }}</span>@enderror
                        </div>
                        <div class="adm_form_group">
                            <label class="adm_form_label">Nom <span class="req">*</span></label>
                            <input type="text" name="walkin_lastname" class="adm_input {{ $errors->has('walkin_lastname') ? 'is_invalid' : '' }}"
                                   value="{{ old('walkin_lastname') }}" placeholder="Nom de famille">
                            @error('walkin_lastname')<span class="adm_form_error">{{ $message }}</span>@enderror
                        </div>
                        <div class="adm_form_group">
                            <label class="adm_form_label">Téléphone <span class="req">*</span></label>
                            <input type="tel" name="walkin_phone" class="adm_input {{ $errors->has('walkin_phone') ? 'is_invalid' : '' }}"
                                   value="{{ old('walkin_phone') }}" placeholder="+229 XX XX XX XX">
                            @error('walkin_phone')<span class="adm_form_error">{{ $message }}</span>@enderror
                        </div>
                        <div class="adm_form_group">
                            <label class="adm_form_label">Email <small class="text_muted">(optionnel)</small></label>
                            <input type="email" name="walkin_email" class="adm_input {{ $errors->has('walkin_email') ? 'is_invalid' : '' }}"
                                   value="{{ old('walkin_email') }}" placeholder="email@exemple.com">
                            @error('walkin_email')<span class="adm_form_error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Adresse <small class="text_muted">(optionnel)</small></label>
                        <input type="text" name="walkin_address" class="adm_input" value="{{ old('walkin_address') }}" placeholder="Quartier, ville…">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Mot de passe provisoire <span class="req">*</span></label>
                        <div style="display:flex;gap:8px;">
                            <input type="text" name="walkin_password" id="walkinPassword" class="adm_input {{ $errors->has('walkin_password') ? 'is_invalid' : '' }}"
                                   value="{{ old('walkin_password', \Illuminate\Support\Str::random(8)) }}" placeholder="À communiquer au client" style="flex:1;">
                            <button type="button" class="adm_btn gray sm" onclick="document.getElementById('walkinPassword').value = Math.random().toString(36).slice(2,10);" title="Régénérer">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <span class="adm_form_hint" style="color:#860000;"><i class="fas fa-exclamation-circle"></i> Communiquez ce mot de passe au client — il en aura besoin pour se connecter.</span>
                        @error('walkin_password')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- Véhicule & Type --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-car"></i> Véhicule &amp; Type</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_form_group">
                    <label class="adm_form_label">Véhicule disponible <span class="req">*</span></label>
                    <select name="vehicle_id" id="vehicleSelect" class="adm_input adm_select {{ $errors->has('vehicle_id') ? 'is_invalid' : '' }}" required onchange="updatePrice()">
                        <option value="">— Choisir un véhicule —</option>
                        @foreach($vehicles as $v)
                        <option value="{{ $v->id }}"
                                data-price-without="{{ $v->price_without_driver }}"
                                data-price-with="{{ $v->price_with_driver }}"
                                {{ old('vehicle_id', optional($selectedVehicle ?? null)->id) == $v->id ? 'selected' : '' }}>
                            {{ $v->name }} — {{ number_format($v->price_without_driver) }} FCFA/j (sans ch.) / {{ number_format($v->price_with_driver) }} FCFA/j (avec ch.)
                        </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')<span class="adm_form_error">{{ $message }}</span>@enderror
                </div>
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Type de location <span class="req">*</span></label>
                        <select name="type" id="typeSelect" class="adm_input adm_select" required onchange="updatePrice()">
                            <option value="sans_chauffeur" {{ old('type','sans_chauffeur') === 'sans_chauffeur' ? 'selected' : '' }}>Sans chauffeur</option>
                            <option value="avec_chauffeur" {{ old('type') === 'avec_chauffeur' ? 'selected' : '' }}>Avec chauffeur</option>
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Zone de desserte</label>
                        <select name="zone_id" class="adm_input adm_select">
                            <option value="">— Aucune zone —</option>
                            @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="adm_form_group">
                    <label class="adm_form_label">Position / Adresse de prise en charge</label>
                    <input type="text" name="current_position" class="adm_input" value="{{ old('current_position') }}" placeholder="Ex : Agence WidriveU, Cotonou centre…">
                </div>
            </div>
        </div>

        {{-- Dates --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-calendar-alt"></i> Période de location</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Date de début <span class="req">*</span></label>
                        <input type="date" name="start_date" id="startDate" class="adm_input {{ $errors->has('start_date') ? 'is_invalid' : '' }}"
                               value="{{ old('start_date', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               required onchange="onStartDateChange()">
                        @error('start_date')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Date de fin <span class="req">*</span></label>
                        <input type="date" name="end_date" id="endDate" class="adm_input {{ $errors->has('end_date') ? 'is_invalid' : '' }}"
                               value="{{ old('end_date') }}"
                               min="{{ old('start_date', date('Y-m-d')) }}"
                               required onchange="updatePrice()">
                        @error('end_date')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Heure de départ</label>
                        <input type="time" name="departure_time" id="adminDepartureTime"
                               class="adm_input" value="{{ old('departure_time', '08:00') }}"
                               onchange="syncAdminReturnTime()">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Heure de retour</label>
                        <input type="time" name="return_time" id="adminReturnTime"
                               class="adm_input"
                               value="{{ old('return_time', old('departure_time', '08:00')) }}"
                               readonly
                               style="background:#F5F6FA;color:#6B7280;cursor:not-allowed;">
                        <span class="adm_form_hint">Définie automatiquement selon l'heure de départ</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div>
        <div style="position:sticky;top:80px;">

            {{-- Tarif estimé --}}
            <div class="db_panel">
                <div class="db_panel_head">
                    <h3 class="db_panel_title"><i class="fas fa-receipt"></i> Tarif estimé</h3>
                </div>
                <div class="db_panel_body">

                    <div id="priceEmpty" style="text-align:center;padding:16px 0;">
                        <i class="fas fa-calculator" style="font-size:28px;color:#D1D5DB;display:block;margin-bottom:10px;"></i>
                        <p class="text_muted" style="font-size:13px;">Sélectionnez un véhicule et des dates.</p>
                    </div>

                    <div id="priceBox" style="display:none;">
                        <div style="background:#F5F6FA;border-radius:8px;padding:14px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
                                <span class="text_muted">Durée</span><strong id="recapDays">—</strong>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
                                <span class="text_muted">Prix/jour</span><strong id="recapDayPrice">—</strong>
                            </div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
                                <span class="text_muted">Sous-total</span><strong id="recapSubtotal">—</strong>
                            </div>
                            <div id="recapDiscountRow" style="display:none;justify-content:space-between;margin-bottom:8px;font-size:13px;color:#22C55E;">
                                <span>Réduction</span><strong id="recapDiscount">—</strong>
                            </div>
                            <div style="border-top:1px solid #E5E7EB;margin:10px 0;"></div>
                            <div style="display:flex;justify-content:space-between;font-size:15px;font-weight:700;">
                                <span>Total</span>
                                <span id="recapTotal" style="color:#860000;">—</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Paiement --}}
            <div class="db_panel">
                <div class="db_panel_head">
                    <h3 class="db_panel_title"><i class="fas fa-money-bill-wave"></i> Paiement</h3>
                </div>
                <div class="db_panel_body">
                    <label id="paidLabel" style="display:flex;align-items:flex-start;gap:10px;padding:12px;border:1.5px solid #E5E7EB;border-radius:6px;cursor:pointer;transition:all .2s;">
                        <input type="checkbox" name="paid" value="1" id="paidCheck" style="width:17px;height:17px;margin-top:2px;flex-shrink:0;" onchange="togglePaid()">
                        <div>
                            <div style="font-weight:600;font-size:13px;color:#111827;">Paiement reçu (présentiel)</div>
                            <div style="font-size:12px;color:#9CA3AF;margin-top:2px;">Le client a payé en espèces ou sur place</div>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="adm_btn red" style="width:100%;justify-content:center;padding:14px;font-size:14px;margin-bottom:10px;">
                <i class="fas fa-check-circle"></i> Enregistrer la réservation
            </button>
            <a href="{{ route('admin.reservations.index') }}" class="adm_btn gray" style="width:100%;justify-content:center;padding:12px;">
                <i class="fas fa-times"></i> Annuler
            </a>

            @if($errors->any())
            <div class="flash_msg error" style="margin-top:16px;">
                <div><i class="fas fa-exclamation-circle"></i> <strong>Erreurs :</strong>
                <ul style="margin:6px 0 0 16px;font-size:12px;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul></div>
            </div>
            @endif

        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
var currentMode = 'existing';

function setMode(mode) {
    currentMode = mode;
    document.getElementById('clientModeInput').value = mode;
    if (mode === 'existing') {
        document.getElementById('modeExisting').style.display = 'block';
        document.getElementById('modeWalkin').style.display   = 'none';
        document.getElementById('btnExisting').style.background = '#111827';
        document.getElementById('btnExisting').style.color     = '#fff';
        document.getElementById('btnWalkin').style.background  = '#F5F6FA';
        document.getElementById('btnWalkin').style.color       = '#9CA3AF';
    } else {
        document.getElementById('modeExisting').style.display = 'none';
        document.getElementById('modeWalkin').style.display   = 'block';
        document.getElementById('btnWalkin').style.background  = '#111827';
        document.getElementById('btnWalkin').style.color       = '#fff';
        document.getElementById('btnExisting').style.background = '#F5F6FA';
        document.getElementById('btnExisting').style.color      = '#9CA3AF';
    }
}

// ── CLIENT SEARCH ──────────────────────────────────────────
var clientsData = {!! json_encode($clients->map(function($c) { return ['id'=>$c->id,'name'=>$c->name,'email'=>$c->email,'phone'=>$c->phone ?? '']; })->values()) !!};

function fillClientInfo(id, name, email, phone) {
    document.getElementById('userIdHidden').value   = id;
    document.getElementById('clientSearch').value   = name + ' — ' + email;
    document.getElementById('clientEmail').value    = email;
    document.getElementById('clientPhone').value    = phone;
    document.getElementById('clientDropdown').style.display = 'none';
}

(function initClientSearch() {
    var input    = document.getElementById('clientSearch');
    var dropdown = document.getElementById('clientDropdown');

    input.addEventListener('input', function() {
        var q = this.value.trim().toLowerCase();
        document.getElementById('userIdHidden').value = '';
        document.getElementById('clientEmail').value  = '';
        document.getElementById('clientPhone').value  = '';

        if (q.length < 2) { dropdown.style.display = 'none'; return; }

        var results = clientsData.filter(function(c) {
            return c.name.toLowerCase().includes(q) || c.email.toLowerCase().includes(q);
        });

        if (!results.length) {
            dropdown.innerHTML = '<div style="padding:12px 14px;color:#9CA3AF;font-size:13px;">Aucun client trouvé</div>';
        } else {
            dropdown.innerHTML = results.slice(0, 10).map(function(c) {
                return '<div class="client-result" data-id="'+c.id+'" data-name="'+c.name+'" data-email="'+c.email+'" data-phone="'+c.phone+'" '
                    + 'style="padding:10px 14px;cursor:pointer;border-bottom:1px solid #F3F4F6;font-size:13px;" '
                    + 'onmouseover="this.style.background=\'#F5F6FA\'" onmouseout="this.style.background=\'#fff\'">'
                    + '<strong>'+c.name+'</strong><br><span style="color:#9CA3AF;">'+c.email+'</span>'
                    + '</div>';
            }).join('');
        }
        dropdown.style.display = 'block';

        dropdown.querySelectorAll('.client-result').forEach(function(el) {
            el.addEventListener('mousedown', function(e) {
                e.preventDefault();
                fillClientInfo(this.dataset.id, this.dataset.name, this.dataset.email, this.dataset.phone);
            });
        });
    });

    input.addEventListener('blur', function() {
        setTimeout(function() { dropdown.style.display = 'none'; }, 150);
    });
    input.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) this.dispatchEvent(new Event('input'));
    });
})();

function updatePrice() {
    var vSel  = document.getElementById('vehicleSelect');
    var tSel  = document.getElementById('typeSelect');
    var start = document.getElementById('startDate').value;
    var end   = document.getElementById('endDate').value;
    if (!vSel.value || !start || !end) {
        document.getElementById('priceBox').style.display   = 'none';
        document.getElementById('priceEmpty').style.display = 'block';
        return;
    }
    var opt      = vSel.options[vSel.selectedIndex];
    var dayPrice = tSel.value === 'avec_chauffeur'
        ? parseInt(opt.dataset.priceWith)
        : parseInt(opt.dataset.priceWithout);
    var days = Math.round((new Date(end) - new Date(start)) / 86400000);
    if (days < 1) days = 1;
    var subtotal = dayPrice * days;
    var discPct  = days >= 21 ? 20 : days >= 14 ? 18 : days >= 7 ? 15 : 0;
    var discAmt  = Math.round(subtotal * discPct / 100);
    var total    = subtotal - discAmt;

    document.getElementById('recapDays').textContent     = days + ' jour(s)';
    document.getElementById('recapDayPrice').textContent = dayPrice.toLocaleString('fr-FR') + ' FCFA';
    document.getElementById('recapSubtotal').textContent = subtotal.toLocaleString('fr-FR') + ' FCFA';
    document.getElementById('recapTotal').textContent    = total.toLocaleString('fr-FR') + ' FCFA';

    var discRow = document.getElementById('recapDiscountRow');
    if (discPct > 0) {
        discRow.style.display = 'flex';
        document.getElementById('recapDiscount').textContent = '-' + discAmt.toLocaleString('fr-FR') + ' FCFA (' + discPct + '%)';
    } else {
        discRow.style.display = 'none';
    }

    document.getElementById('priceBox').style.display   = 'block';
    document.getElementById('priceEmpty').style.display = 'none';
}

function togglePaid() {
    var lbl = document.getElementById('paidLabel');
    var chk = document.getElementById('paidCheck').checked;
    lbl.style.borderColor = chk ? '#22C55E' : '#E5E7EB';
    lbl.style.background  = chk ? '#F0FDF4' : '';
}

function onStartDateChange() {
    var startVal = document.getElementById('startDate').value;
    var endInput = document.getElementById('endDate');
    endInput.min = startVal;
    if (endInput.value && endInput.value < startVal) {
        endInput.value = startVal;
    }
    updatePrice();
}

function syncAdminReturnTime() {
    var val = document.getElementById('adminDepartureTime').value;
    document.getElementById('adminReturnTime').value = val;
}

// Restore on validation error
(function() {
    var oldMode = '{{ old("client_mode", "existing") }}';
    setMode(oldMode);
    // client search auto-init handled by initClientSearch()
    if (document.getElementById('vehicleSelect').value) updatePrice();
    syncAdminReturnTime();
})();
</script>
@endpush
