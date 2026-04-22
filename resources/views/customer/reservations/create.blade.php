@extends('layouts.app')

@section('title', 'Réservation — ' . $vehicle->name)
@section('header_class', 'secondary_header')

@section('breadcrumb_title', 'Réservation')
@section('breadcrumb')
    <li><a href="{{ route('fleet') }}">Notre Flotte</a></li>
    <li>Réservation</li>
@endsection

@push('styles')
<style>
    /* -------- Form labels -------- */
    .form_item h4.input_title {
        font-size: 13px;
        font-weight: 600;
        color: #000C21;
        margin-bottom: 6px;
        font-family: 'Sora', sans-serif;
        letter-spacing: 0.5px;
    }
    .form_item input[type="date"],
    .form_item input[type="time"],
    .form_item input[type="text"],
    .form_item input[type="tel"],
    .form_item input[type="email"],
    .form_item select {
        width: 100%;
    }
    .form_item select {
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px;
        padding-right: 36px;
    }

    /* -------- Type radio section -------- */
    .reservation_offer_checkbox {
        margin: 24px 0;
    }
    .reservation_offer_checkbox h4.input_title {
        font-size: 14px;
        font-weight: 700;
        color: #000C21;
        margin-bottom: 14px;
        text-transform: uppercase;
        font-family: 'Sora', sans-serif;
    }
    .checkbox_input {
        margin-bottom: 10px;
    }
    .checkbox_input label {
        cursor: pointer;
        font-size: 14px;
        color: #555;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .checkbox_input label input[type="radio"],
    .checkbox_input label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #860000;
        flex-shrink: 0;
    }

    /* -------- Summary box -------- */
    .reservation_summary {
        border-radius: 4px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .reservation_summary h4 {
        font-family: 'Sora', sans-serif;
        font-size: 18px;
        color: #000C21;
        margin-bottom: 16px;
        border-bottom: 2px solid #860000;
        padding-bottom: 8px;
    }
    .reservation_summary ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .reservation_summary ul li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
        color: #555;
    }
    .reservation_summary ul li:last-child {
        border-bottom: none;
    }
    .reservation_summary ul li.total_row {
        font-size: 16px;
        color: #860000;
        font-weight: 700;
        margin-top: 6px;
        /* border-top: 2px solid #860000; */
        padding-top: 10px;
    }
    .reservation_summary ul li strong {
        color: #000C21;
    }
    .reservation_summary ul li.total_row strong {
        color: #860000;
        font-size: 18px;
    }

    /* -------- Section headers -------- */
    .form_section_title {
        font-family: 'Sora', sans-serif;
        font-size: 16px;
        color: #000C21;
        margin: 24px 0 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
        text-transform: uppercase;
    }

    /* -------- Invalid ------ */
    .invalid-feedback-custom {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
    .form_item .is-invalid-input {
        border-color: #dc3545 !important;
    }
    .alert-errors {
        background: #fff0f0;
        border: 1px solid #860000;
        border-radius: 4px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }
    .alert-errors ul {
        margin: 0;
        padding-left: 18px;
    }
    .alert-errors ul li {
        color: #860000;
        font-size: 13px;
    }

    /* Disable state */
    #submit_btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Terms link */
    .terms_condition {
        font-size: 13px;
        color: #860000;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 10px;
    }
    .terms_condition:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

<!-- reservation_section - start -->
<section class="reservation_section sec_ptb_100 clearfix">
    <div class="container">

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert-errors" data-aos="fade-up">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-lg-between justify-content-md-center justify-content-sm-center">

            {{-- LEFT: Vehicle info card --}}
            <div class="col-lg-4 col-md-8 col-sm-10 col-xs-12">

                {{-- Vehicle card — dark style --}}
                <div data-aos="fade-up" data-aos-delay="100" style="border-radius:6px;overflow:hidden;margin-bottom:24px;">
                    {{-- Image with overlay + price badge --}}
                    <div style="position:relative;">
                        <img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}"
                             style="width:100%;height:220px;object-fit:cover;display:block;">
                        <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.65) 100%);"></div>
                        <span class="bg_default_blue" style="position:absolute;bottom:14px;left:14px;padding:5px 14px;color:#fff;font-size:14px;font-weight:700;border-radius:3px;">
                            {{ number_format($vehicle->price_without_driver) }} FCFA/Jour
                        </span>
                    </div>
                    {{-- Name + link --}}
                    <div style="background:#F2F2F2;padding:16px 18px;">
                        <h3 style="font-size:17px;font-weight:700;color:#000000;margin-bottom:8px;">
                            {{ $vehicle->name }}
                        </h3>
                        <a href="{{ route('vehicle.show', $vehicle) }}"
                           style="font-size:13px;font-weight:700;color:#860000;text-transform:uppercase;letter-spacing:1px;text-decoration:none;">
                            Voir le détail
                            <img src="{{ asset('assets/images/icons/icon_02.png') }}" alt="→" style="height:12px;margin-left:6px;">
                        </a>
                    </div>
                </div>

                {{-- Summary box (sticky sidebar) --}}
                <div class="reservation_summary mt_30" data-bg-color="#F2F2F2" data-aos="fade-up" data-aos-delay="300">
                    <h4>Récapitulatif</h4>
                    <ul>
                        <li>
                            Véhicule
                            <strong>{{ $vehicle->name }}</strong>
                        </li>
                        <li>
                            Durée
                            <strong id="summary_days">— jours</strong>
                        </li>
                        <li>
                            Prix/jour
                            <strong id="summary_price_per_day">—</strong>
                        </li>
                        <li>
                            Sous-total
                            <strong id="summary_subtotal">—</strong>
                        </li>
                        <li id="discount_row" style="display:none; font-size:14px; font-weight:500; margin-top:6px; padding-top:10px; color:#555555;">
                            Réduction
                            <strong id="summary_discount" style="color:#28a745; font-size:14px;">—</strong>
                        </li>
                        <li class="total_row">
                            Total
                            <strong id="summary_total">—</strong>
                        </li>
                    </ul>
                </div>

            </div>
            {{-- end LEFT --}}

            {{-- RIGHT: Reservation form --}}
            <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">

                <div class="reservation_form" data-aos="fade-up" data-aos-delay="100">
                    <form action="{{ route('reservation.store') }}" method="POST" id="reservationForm">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        {{-- Section: Dates et Heures --}}
                        <h4 class="form_section_title">
                            Dates et Heures
                        </h4>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <h4 class="input_title">Date de début *</h4>
                                    <input type="date"
                                           name="start_date"
                                           id="start_date"
                                           value="{{ old('start_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="{{ $errors->has('start_date') ? 'is-invalid-input' : '' }}"
                                           required>
                                    @error('start_date')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <h4 class="input_title">Date de fin *</h4>
                                    <input type="date"
                                           name="end_date"
                                           id="end_date"
                                           value="{{ old('end_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="{{ $errors->has('end_date') ? 'is-invalid-input' : '' }}"
                                           required>
                                    @error('end_date')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <h4 class="input_title">Heure de départ *</h4>
                                    <select name="departure_time" id="departure_time"
                                            class="{{ $errors->has('departure_time') ? 'is-invalid-input' : '' }}"
                                            required>
                                        @foreach(array_map(fn($h) => sprintf('%02d:%02d', intdiv($h, 2), ($h % 2) * 30), range(12, 44)) as $t)
                                            <option value="{{ $t }}" {{ old('departure_time', '08:00') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                    @error('departure_time')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <h4 class="input_title">Heure de retour</h4>
                                    <input type="text" id="return_time_display" value="{{ old('departure_time', '08:00') }}"
                                           readonly
                                           style="background:#f5f5f5;color:#888;cursor:not-allowed;"
                                           title="Automatiquement identique à l'heure de départ">
                                    <input type="hidden" name="return_time" id="return_time" value="{{ old('return_time', '08:00') }}">
                                    <small style="color:#999;font-size:11px;">Définie automatiquement selon l'heure de départ</small>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-0">

                        {{-- Section: Type de réservation --}}
                        <div class="reservation_offer_checkbox">
                            <h4 class="input_title">
                                Type de réservation
                            </h4>
                            <div class="checkbox_input">
                                <label for="type_sans">
                                    <input type="radio"
                                           id="type_sans"
                                           name="type"
                                           value="sans_chauffeur"
                                           {{ old('type', 'sans_chauffeur') === 'sans_chauffeur' ? 'checked' : '' }}>
                                    Sans chauffeur &mdash;
                                    <strong>{{ number_format($vehicle->price_without_driver) }} FCFA/jour</strong>
                                </label>
                            </div>
                            <div class="checkbox_input">
                                <label for="type_avec">
                                    <input type="radio"
                                           id="type_avec"
                                           name="type"
                                           value="avec_chauffeur"
                                           {{ old('type') === 'avec_chauffeur' ? 'checked' : '' }}>
                                    Avec chauffeur &mdash;
                                    <strong>{{ number_format($vehicle->price_with_driver) }} FCFA/jour</strong>
                                </label>
                            </div>
                        </div>

                        <hr class="mt-0">

                        {{-- Section: Informations client --}}
                        <h4 class="form_section_title">
                            Informations client
                        </h4>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form_item">
                                    <h4 class="input_title">Position actuelle / Lieu de prise en charge</h4>
                                    <div class="position-relative">
                                        <input type="text"
                                               id="current_position"
                                               name="current_position"
                                               placeholder="Ex : Carrefour Cadjehoun, Cotonou"
                                               value="{{ old('current_position') }}"
                                               class="{{ $errors->has('current_position') ? 'is-invalid-input' : '' }}">
                                        <label for="current_position" class="input_icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </label>
                                    </div>
                                    @error('current_position')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if($zones->count())
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form_item">
                                    <h4 class="input_title">Zone de déplacement</h4>
                                    <select name="zone_id" id="zone_id">
                                        <option value="">— Choisir une zone —</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}"
                                                    {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('zone_id')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form_item">
                                    <h4 class="input_title">Téléphone *</h4>
                                    <input type="tel"
                                           name="phone"
                                           placeholder="+229 94 08 08 08"
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                           class="{{ $errors->has('phone') ? 'is-invalid-input' : '' }}"
                                           required>
                                    @error('phone')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form_item">
                                    <h4 class="input_title">Email *</h4>
                                    <input type="email"
                                           name="email"
                                           placeholder="votre@email.com"
                                           value="{{ old('email', auth()->user()->email) }}"
                                           class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}"
                                           required>
                                    @error('email')
                                        <span class="invalid-feedback-custom">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Terms + Submit --}}
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <a class="terms_condition" href="#!">
                                    <i class="fas fa-info-circle"></i>
                                    Conditions générales de location WidriveU
                                </a>
                                <div class="checkbox_input mb-0">
                                    <label for="terms_check">
                                        <input type="checkbox" id="terms_check">
                                        J'accepte les conditions générales de location
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 text-lg-end mt-3 mt-lg-0">
                                <button type="submit"
                                        id="submit_btn"
                                        class="custom_btn bg_default_red btn_width text-uppercase"
                                        disabled>
                                    Procéder au paiement
                                    <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            {{-- end RIGHT --}}

        </div>
    </div>
</section>
<!-- reservation_section - end -->

@endsection

@push('scripts')
<script>
$(function () {

    // Vehicle prices from server
    var priceWithout = {{ (int)$vehicle->price_without_driver }};
    var priceWith    = {{ (int)$vehicle->price_with_driver }};

    /**
     * Format number as FCFA with thousand separator
     */
    function formatFCFA(n) {
        return n.toLocaleString('fr-FR') + ' FCFA';
    }

    /**
     * Get discount percentage based on number of days
     */
    function getDiscount(days) {
        if (days >= 21) return 20;
        if (days >= 14) return 18;
        if (days >= 7)  return 15;
        return 0;
    }

    /**
     * Get current daily price based on selected type
     */
    function getCurrentPrice() {
        return $('input[name="type"]:checked').val() === 'avec_chauffeur'
            ? priceWith
            : priceWithout;
    }

    /**
     * Recalculate and update the summary panel
     */
    function updateSummary() {
        var start = $('#start_date').val();
        var end   = $('#end_date').val();

        if (!start || !end) {
            resetSummary();
            return;
        }

        var startDate = new Date(start);
        var endDate   = new Date(end);

        if (endDate <= startDate) {
            resetSummary();
            return;
        }

        var ms   = endDate - startDate;
        var days = Math.round(ms / (1000 * 60 * 60 * 24));

        var pricePerDay = getCurrentPrice();
        var subtotal    = days * pricePerDay;
        var discPct     = getDiscount(days);
        var discAmt     = Math.round(subtotal * discPct / 100);
        var total       = subtotal - discAmt;

        // Update DOM
        $('#summary_days').text(days + ' jour' + (days > 1 ? 's' : ''));
        $('#summary_price_per_day').text(formatFCFA(pricePerDay));
        $('#summary_subtotal').text(formatFCFA(subtotal));
        $('#summary_total').text(formatFCFA(total));

        if (discPct > 0) {
            $('#summary_discount').text('− ' + formatFCFA(discAmt) + ' (' + discPct + '%)');
            $('#discount_row').show();
        } else {
            $('#discount_row').hide();
        }

        // Ensure end date >= start date
        $('#end_date').attr('min', start);
    }

    /**
     * Reset summary to default dashes
     */
    function resetSummary() {
        $('#summary_days').text('— jours');
        $('#summary_price_per_day').text('—');
        $('#summary_subtotal').text('—');
        $('#summary_total').text('—');
        $('#discount_row').hide();
    }

    /**
     * Enable / disable submit button based on terms checkbox
     */
    function toggleSubmit() {
        var allFilled =
            $('#start_date').val() !== '' &&
            $('#end_date').val() !== '' &&
            $('#departure_time').val() !== '' &&
            $('input[name="type"]:checked').length > 0 &&
            $('input[name="current_position"]').val().trim() !== '' &&
            $('input[name="phone"]').val().trim() !== '' &&
            $('input[name="email"]').val().trim() !== '' &&
            $('#terms_check').is(':checked');

        $('#submit_btn').prop('disabled', !allFilled);
    }

    // Sync return_time = departure_time automatiquement
    function syncReturnTime() {
        var val = $('#departure_time').val();
        $('#return_time').val(val);
        $('#return_time_display').val(val);
    }
    $('#departure_time').on('change', syncReturnTime);
    syncReturnTime(); // init

    // Event bindings
    $('#start_date, #end_date').on('change', function () {
        // Sync min for end_date
        if ($(this).attr('id') === 'start_date') {
            var startVal = $(this).val();
            $('#end_date').attr('min', startVal);
            // Clear end if now invalid
            if ($('#end_date').val() && $('#end_date').val() < startVal) {
                $('#end_date').val('');
            }
        }
        updateSummary();
    });

    $('input[name="type"]').on('change', updateSummary);

    // Écoute globale sur tous les champs du formulaire
    $('#reservationForm').on('change input keyup blur', 'input, select', toggleSubmit);

    // Init
    updateSummary();
    toggleSubmit();

});
</script>
@endpush
