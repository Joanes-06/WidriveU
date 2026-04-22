@extends('layouts.admin')
@section('title', 'Modifier — ' . $vehicle->name)
@section('page_title', 'Modifier un véhicule')

@section('content')

<a href="{{ route('admin.vehicles.index') }}" class="adm_back"><i class="fas fa-chevron-left"></i> Retour à la flotte</a>

<div class="adm_page_hd">
    <div>
        <h2>Modifier : {{ $vehicle->name }}</h2>
        <p>Dernière modification le {{ $vehicle->updated_at->format('d/m/Y') }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.vehicles.update', $vehicle) }}" enctype="multipart/form-data">
@csrf @method('PUT')

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
                               value="{{ old('name', $vehicle->name) }}" required>
                        @error('name')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Marque <span class="req">*</span></label>
                        <input type="text" name="brand" class="adm_input {{ $errors->has('brand') ? 'is_invalid' : '' }}"
                               value="{{ old('brand', $vehicle->brand) }}" required>
                        @error('brand')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="adm_form_row cols3">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Modèle</label>
                        <input type="text" name="model" class="adm_input" value="{{ old('model', $vehicle->model) }}">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Année</label>
                        <input type="number" name="year" class="adm_input" value="{{ old('year', $vehicle->year) }}" min="2000" max="{{ date('Y')+1 }}">
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Immatriculation</label>
                        <input type="text" name="license_plate" class="adm_input" value="{{ old('license_plate', $vehicle->license_plate) }}">
                    </div>
                </div>
                <div class="adm_form_row cols3">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Catégorie</label>
                        <select name="category" class="adm_input adm_select">
                            @foreach(\App\Models\Vehicle::CATEGORIES as $val => $label)
                            <option value="{{ $val }}" {{ old('category', $vehicle->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Sièges</label>
                        <select name="seats" class="adm_input adm_select">
                            @for($i=2;$i<=9;$i++)
                            <option value="{{ $i }}" {{ old('seats', $vehicle->seats) == $i ? 'selected' : '' }}>{{ $i }} places</option>
                            @endfor
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Transmission</label>
                        <select name="transmission" class="adm_input adm_select">
                            <option value="automatique" {{ old('transmission', $vehicle->transmission) === 'automatique' ? 'selected' : '' }}>Automatique</option>
                            <option value="manuelle"    {{ old('transmission', $vehicle->transmission) === 'manuelle'    ? 'selected' : '' }}>Manuelle</option>
                        </select>
                    </div>
                </div>
                <div class="adm_form_row cols2">
                    <div class="adm_form_group">
                        <label class="adm_form_label">Carburant</label>
                        <select name="fuel_type" class="adm_input adm_select">
                            @foreach(['essence'=>'Essence','diesel'=>'Diesel','hybride'=>'Hybride','electrique'=>'Électrique'] as $val => $label)
                            <option value="{{ $val }}" {{ old('fuel_type', $vehicle->fuel_type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Statut</label>
                        <select name="status" class="adm_input adm_select">
                            <option value="disponible"  {{ old('status', $vehicle->status) === 'disponible'  ? 'selected' : '' }}>Disponible</option>
                            <option value="reservee"    {{ old('status', $vehicle->status) === 'reservee'    ? 'selected' : '' }}>Réservée</option>
                            <option value="maintenance" {{ old('status', $vehicle->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @if($vehicle->status === 'reservee')
                        <span class="adm_form_hint" style="color:#860000;"><i class="fas fa-exclamation-triangle"></i> Ce véhicule a une réservation active.</span>
                        @endif
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
                        <input type="number" name="price_without_driver"
                               class="adm_input {{ $errors->has('price_without_driver') ? 'is_invalid' : '' }}"
                               value="{{ old('price_without_driver', $vehicle->price_without_driver) }}" min="0" required>
                        <span class="adm_form_hint">FCFA / jour</span>
                        @error('price_without_driver')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                    <div class="adm_form_group">
                        <label class="adm_form_label">Prix avec chauffeur <span class="req">*</span></label>
                        <input type="number" name="price_with_driver"
                               class="adm_input {{ $errors->has('price_with_driver') ? 'is_invalid' : '' }}"
                               value="{{ old('price_with_driver', $vehicle->price_with_driver) }}" min="0" required>
                        <span class="adm_form_hint">FCFA / jour</span>
                        @error('price_with_driver')<span class="adm_form_error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-camera"></i> Photos</h3>
            </div>
            <div class="db_panel_body">
                {{-- Current photo --}}
                @if($vehicle->photo)
                <div class="adm_form_group">
                    <label class="adm_form_label">Photo actuelle</label>
                    <img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}"
                         style="width:200px;height:130px;object-fit:cover;border-radius:8px;margin-bottom:10px;">
                </div>
                @endif
                <div class="adm_form_group">
                    <label class="adm_form_label">{{ $vehicle->photo ? 'Remplacer la photo' : 'Photo principale *' }}</label>
                    <div class="adm_upload_zone" onclick="document.getElementById('photoInput').click()">
                        <i class="fas fa-image" id="photoIcon"></i>
                        <p id="photoText">Cliquer pour choisir une nouvelle photo</p>
                        <span>JPG, PNG — max 5 Mo</span>
                        <img id="photoPreview" src="" alt="" style="display:none;max-width:100%;max-height:140px;border-radius:6px;margin-top:10px;">
                    </div>
                    <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                </div>

                {{-- Gallery photos actuelles --}}
                @php $galleryFields = ['image_2'=>'Photo 2','image_3'=>'Photo 3','image_4'=>'Photo 4']; @endphp
                @foreach($galleryFields as $field => $label)
                <div class="adm_form_group">
                    <label class="adm_form_label">{{ $label }}</label>
                    @if($vehicle->$field)
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <img src="{{ asset('uploads/vehicles/' . $vehicle->$field) }}" alt="{{ $label }}"
                             style="width:80px;height:60px;object-fit:cover;border-radius:6px;">
                        <label style="display:flex;align-items:center;gap:6px;font-size:12px;color:#860000;cursor:pointer;">
                            <input type="checkbox" name="delete_{{ $field }}" value="1">
                            Supprimer cette photo
                        </label>
                    </div>
                    @endif
                    <input type="file" name="{{ $field }}" accept="image/*" class="adm_input" style="font-size:12px;">
                    <span class="adm_form_hint">{{ $vehicle->$field ? 'Choisir un fichier pour remplacer.' : 'Optionnel.' }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div>
        <div class="db_panel" style="margin-bottom:16px;">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-car"></i> Véhicule actuel</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-car"></i></div>
                    <div><div class="adm_info_lbl">Nom</div><div class="adm_info_val">{{ $vehicle->name }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-tag"></i></div>
                    <div><div class="adm_info_lbl">Statut</div>
                    <div class="adm_info_val">
                        @php $vs = ['disponible'=>'available','reservee'=>'reserved','maintenance'=>'maintenance']; @endphp
                        <span class="db_badge {{ $vs[$vehicle->status] ?? 'completed' }}">
                            {{ ['disponible'=>'Disponible','reservee'=>'Réservée','maintenance'=>'Maintenance'][$vehicle->status] ?? $vehicle->status }}
                        </span>
                    </div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-coins"></i></div>
                    <div><div class="adm_info_lbl">Prix sans chauffeur</div><div class="adm_info_val">{{ number_format($vehicle->price_without_driver) }} FCFA/j</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-user-tie"></i></div>
                    <div><div class="adm_info_lbl">Prix avec chauffeur</div><div class="adm_info_val">{{ number_format($vehicle->price_with_driver) }} FCFA/j</div></div>
                </div>
            </div>
        </div>

        <button type="submit" class="adm_btn dark" style="width:100%;justify-content:center;padding:14px;font-size:14px;margin-bottom:10px;">
            <i class="fas fa-save"></i> Enregistrer les modifications
        </button>
        <a href="{{ route('admin.vehicles.index') }}" class="adm_btn gray" style="width:100%;justify-content:center;padding:14px;">
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
// Highlight gallery delete checkboxes
document.querySelectorAll('[name^="delete_image"]').forEach(function(cb) {
    cb.addEventListener('change', function() {
        this.closest('label').previousElementSibling.style.opacity = this.checked ? '0.4' : '1';
    });
});
</script>
@endpush
