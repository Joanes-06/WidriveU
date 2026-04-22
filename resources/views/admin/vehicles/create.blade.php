@extends('layouts.admin')
@section('title', 'Ajouter un véhicule')
@section('page_title', 'Ajouter un véhicule')

@section('content')

<a href="{{ route('admin.vehicles.index') }}" class="adm_back"><i class="fas fa-chevron-left"></i> Retour à la flotte</a>

<div class="adm_page_hd">
    <div><h2>Ajouter un véhicule</h2></div>
</div>

<form method="POST" action="{{ route('admin.vehicles.store') }}" enctype="multipart/form-data">
@csrf

<div class="adm_grid wide">

    {{-- LEFT --}}
    <div>

        {{-- Informations générales --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-info-circle"></i> Informations générales</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Nom du véhicule <span class="req">*</span></label>
                        <input type="text" name="name" class="adm_input {{ $errors->has('name') ? 'is_invalid' : '' }}"
                               value="{{ old('name') }}" placeholder="Ex: Mercedes-Benz C200 2021" required>
                        @error('name')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Marque <span class="req">*</span></label>
                        <input type="text" name="brand" class="adm_input {{ $errors->has('brand') ? 'is_invalid' : '' }}"
                               value="{{ old('brand') }}" placeholder="Ex: Mercedes-Benz" required>
                        @error('brand')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="adm_form_row cols3">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Modèle</label>
                        <input type="text" name="model" class="adm_input" value="{{ old('model') }}" placeholder="C200">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Année</label>
                        <input type="number" name="year" class="adm_input" value="{{ old('year', date('Y')) }}" min="2000" max="{{ date('Y')+1 }}">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Immatriculation</label>
                        <input type="text" name="license_plate" class="adm_input" value="{{ old('license_plate') }}" placeholder="AB-1234-CD">
                    </div>
                </div>
                <div class="adm_form_row cols3">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Catégorie</label>
                        <select name="category" class="adm_input adm_select">
                            @foreach(\App\Models\Vehicle::CATEGORIES as $val => $label)
                            <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Sièges</label>
                        <select name="seats" class="adm_input adm_select">
                            @for($i=2;$i<=9;$i++)
                            <option value="{{ $i }}" {{ old('seats','5') == $i ? 'selected' : '' }}>{{ $i }} places</option>
                            @endfor
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Transmission</label>
                        <select name="transmission" class="adm_input adm_select">
                            <option value="automatique" {{ old('transmission','automatique') === 'automatique' ? 'selected' : '' }}>Automatique</option>
                            <option value="manuelle"    {{ old('transmission') === 'manuelle'    ? 'selected' : '' }}>Manuelle</option>
                        </select>
                    </div>
                </div>
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Carburant</label>
                        <select name="fuel_type" class="adm_input adm_select">
                            @foreach(['essence'=>'Essence','diesel'=>'Diesel','hybride'=>'Hybride','electrique'=>'Électrique'] as $val => $label)
                            <option value="{{ $val }}" {{ old('fuel_type','essence') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Statut initial</label>
                        <select name="status" class="adm_input adm_select">
                            <option value="disponible"  {{ old('status','disponible') === 'disponible'  ? 'selected' : '' }}>Disponible</option>
                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarification --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-tags"></i> Tarification</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Prix sans chauffeur <span class="req">*</span></label>
                        <input type="number" name="price_without_driver" id="priceWithout"
                               class="adm_input {{ $errors->has('price_without_driver') ? 'is_invalid' : '' }}"
                               value="{{ old('price_without_driver') }}" placeholder="65000" min="0" required oninput="updateSimulator()">
                        <span class="adm_form_hint">FCFA / jour</span>
                        @error('price_without_driver')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Prix avec chauffeur <span class="req">*</span>
                            <button type="button" onclick="applyMultiplier()" style="font-size:10px;background:#F5F6FA;border:1px solid #E5E7EB;border-radius:4px;padding:2px 8px;cursor:pointer;margin-left:6px;font-weight:600;color:#374151;">
                                × {{ \App\Models\Setting::get('price_with_driver_multiplier', 1.5) }} auto
                            </button>
                        </label>
                        <input type="number" name="price_with_driver" id="priceWith"
                               class="adm_input {{ $errors->has('price_with_driver') ? 'is_invalid' : '' }}"
                               value="{{ old('price_with_driver') }}" placeholder="90000" min="0" required oninput="updateSimulator()">
                        <span class="adm_form_hint">FCFA / jour</span>
                        @error('price_with_driver')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div id="priceSimulator" style="display:none;background:#F5F6FA;border-radius:8px;padding:14px;font-size:12px;">
                    <div class="adm_section_lbl" style="margin-bottom:10px;">Simulation (sans chauffeur)</div>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;" id="simGrid"></div>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-camera"></i> Photos</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_form_group">
                    <label class="adm_form_label">Photo principale <span class="req">*</span></label>
                    <div class="adm_upload_zone" onclick="document.getElementById('photoInput').click()">
                        <i class="fas fa-image" id="photoIcon"></i>
                        <p id="photoText">Cliquer pour choisir une photo</p>
                        <span>JPG, PNG — max 5 Mo</span>
                        <img id="photoPreview" src="" alt="" style="display:none;max-width:100%;max-height:140px;border-radius:6px;margin-top:10px;">
                    </div>
                    <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)" {{ $errors->has('photo') ? 'class=is_invalid' : '' }}>
                    @error('photo')<span class="adm_form_error">{{ $message }}</span>@enderror
                </div>
                <div class="adm_form_group">
                    <label class="adm_form_label">Photos supplémentaires</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                        @foreach([2,3,4] as $g)
                        <div class="adm_upload_zone" onclick="document.getElementById('gallInput_{{ $g }}').click()" style="padding:16px;">
                            <i class="fas fa-plus" style="font-size:20px;" id="gallIcon_{{ $g }}"></i>
                            <p style="font-size:11px;">Photo {{ $g - 1 }}</p>
                            <img id="gallPreview_{{ $g }}" src="" alt="" style="display:none;max-width:100%;max-height:80px;border-radius:4px;margin-top:6px;">
                        </div>
                        <input type="file" id="gallInput_{{ $g }}" name="image_{{ $g }}" accept="image/*" style="display:none;"
                               onchange="previewGallery(this, {{ $g }})">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-check-circle"></i> Récapitulatif</h3>
            </div>
            <div class="db_panel_body">
                <p class="text_muted" style="font-size:12px;margin-bottom:16px;">Remplissez le formulaire pour voir le récapitulatif.</p>
                <div style="background:#F5F6FA;border-radius:8px;padding:14px;">
                    <div class="adm_info_row" style="border:none;padding:6px 0;">
                        <div class="adm_info_icon"><i class="fas fa-car"></i></div>
                        <div><div class="adm_info_lbl">Nom</div><div class="adm_info_val" id="recap_name">—</div></div>
                    </div>
                    <div class="adm_info_row" style="border:none;padding:6px 0;">
                        <div class="adm_info_icon"><i class="fas fa-tag"></i></div>
                        <div><div class="adm_info_lbl">Prix sans chauffeur</div><div class="adm_info_val" id="recap_price_without">—</div></div>
                    </div>
                    <div class="adm_info_row" style="border:none;padding:6px 0;">
                        <div class="adm_info_icon"><i class="fas fa-user-tie"></i></div>
                        <div><div class="adm_info_lbl">Prix avec chauffeur</div><div class="adm_info_val" id="recap_price_with">—</div></div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="adm_btn red" style="width:100%;justify-content:center;padding:14px;font-size:14px;">
            <i class="fas fa-save"></i> Enregistrer le véhicule
        </button>

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

</form>
@endsection

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
            document.getElementById('photoIcon').style.display = 'none';
            document.getElementById('photoText').textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewGallery(input, gNum) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('gallPreview_'+gNum).src = e.target.result;
            document.getElementById('gallPreview_'+gNum).style.display = 'block';
            document.getElementById('gallIcon_'+gNum).style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
var driverMultiplier = {{ \App\Models\Setting::get('price_with_driver_multiplier', 1.5) }};
function applyMultiplier() {
    var pw = parseInt(document.getElementById('priceWithout').value) || 0;
    if (pw > 0) {
        document.getElementById('priceWith').value = Math.round(pw * driverMultiplier);
        updateSimulator();
    }
}
// Update recap
document.querySelector('[name="name"]').addEventListener('input', function() {
    document.getElementById('recap_name').textContent = this.value || '—';
});
function updateSimulator() {
    var pw = parseInt(document.getElementById('priceWithout').value) || 0;
    var pwith = parseInt(document.getElementById('priceWith').value) || 0;
    document.getElementById('recap_price_without').textContent = pw ? pw.toLocaleString() + ' FCFA/j' : '—';
    document.getElementById('recap_price_with').textContent = pwith ? pwith.toLocaleString() + ' FCFA/j' : '—';
    if (!pw) { document.getElementById('priceSimulator').style.display='none'; return; }
    document.getElementById('priceSimulator').style.display = 'block';
    var tiers = [
        [3,  0],
        [7,  {{ (int)\App\Models\Setting::get('discount_7_days', 15) }}],
        [14, {{ (int)\App\Models\Setting::get('discount_14_days', 18) }}],
        [21, {{ (int)\App\Models\Setting::get('discount_21_days', 20) }}]
    ];
    var html = '';
    tiers.forEach(function(t) {
        var total = pw * t[0] * (1 - t[1]/100);
        html += '<div style="background:#fff;border-radius:6px;padding:10px;text-align:center;">'
            + '<div style="font-size:13px;font-weight:700;">'+Math.round(total).toLocaleString()+'</div>'
            + '<div style="font-size:10px;color:#9CA3AF;">'+t[0]+'j'+(t[1]?'<span style="color:#860000;margin-left:3px;">-'+t[1]+'%</span>':'')+'</div>'
            + '</div>';
    });
    document.getElementById('simGrid').innerHTML = html;
}
</script>
@endpush
