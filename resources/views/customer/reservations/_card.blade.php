{{--
    Partial: Single reservation card (dashboard style)
    Variables:
      $reservation  - Reservation model
      $showExtend   - bool: show "Prolonger" button
      $showCancel   - bool: show "Annuler" button
--}}
<div class="res_card" data-aos="fade-up">

    {{-- Vehicle image --}}
    <div class="rc_image">
        @if($reservation->vehicle && $reservation->vehicle->photo_url)
            <img src="{{ $reservation->vehicle->photo_url }}" alt="{{ $reservation->vehicle->name }}">
        @else
            <div class="rc_image_placeholder">
                <i class="fas fa-car"></i>
            </div>
        @endif
    </div>

    {{-- Main content --}}
    <div class="rc_body">

        {{-- Top row: number + badge --}}
        <div class="rc_top">
            <span class="rc_num">{{ $reservation->reservation_number }}</span>
            <span class="rc_badge {{ $reservation->status }}">{{ $reservation->status_label }}</span>
        </div>

        {{-- Vehicle name --}}
        <div class="rc_vehicle">{{ $reservation->vehicle->name ?? 'Véhicule' }}</div>

        {{-- Info row --}}
        <div class="rc_info_row">
            <span class="rc_info_item">
                <i class="fas fa-calendar-alt"></i>
                {{ $reservation->start_date->format('d/m/Y') }} &rarr; {{ $reservation->end_date->format('d/m/Y') }}
            </span>
            <span class="rc_info_item">
                <i class="fas fa-hourglass-half"></i>
                {{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}
            </span>
            <span class="rc_info_item">
                <i class="fas fa-car"></i>
                {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
            </span>
            @if($reservation->zone)
            <span class="rc_info_item">
                <i class="fas fa-map-marker-alt"></i>
                {{ $reservation->zone->name }}
            </span>
            @endif
        </div>

        {{-- Price + countdown --}}
        <div class="rc_bottom">
            <span class="rc_price">
                {{ number_format($reservation->total) }} FCFA
                @if($reservation->discount_percentage > 0)
                    <span class="rc_discount">(-{{ $reservation->discount_percentage }}%)</span>
                @endif
            </span>
            @if($reservation->status === 'active')
            <span class="rc_timer">
                <i class="fas fa-clock"></i>
                Reste :
                <span class="countdown_inline"
                      data-end="{{ $reservation->end_date->format('Y-m-d') }}T{{ $reservation->return_time ?? '18:00' }}">—</span>
            </span>
            @endif
        </div>

    </div>

    {{-- Actions --}}
    <div class="rc_actions">

        <a href="{{ route('reservations.show', $reservation) }}" class="rc_btn rc_btn_dark">
            <i class="fas fa-eye"></i> Détails
        </a>

        @if($showExtend)
        <button type="button"
                class="rc_btn rc_btn_blue open_extend_modal"
                data-res-id="{{ $reservation->id }}"
                data-extend-url="{{ route('reservations.extend', $reservation) }}"
                data-end-date="{{ $reservation->end_date->format('Y-m-d') }}">
            <i class="fas fa-calendar-plus"></i> Prolonger
        </button>
        @endif

        @if($showCancel)
        <button type="button"
                class="rc_btn rc_btn_outline_red open_cancel_modal"
                data-res-id="{{ $reservation->id }}"
                data-res-number="{{ $reservation->reservation_number }}"
                data-cancel-url="{{ route('reservations.cancel', $reservation) }}">
            <i class="fas fa-times"></i> Annuler
        </button>
        @endif

    </div>

</div>
