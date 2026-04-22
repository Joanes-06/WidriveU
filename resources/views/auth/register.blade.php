@extends('layouts.app')

@section('title', "S'inscrire")
@section('header_class', 'secondary_header')

@section('breadcrumb_title', 'Inscription')
@section('breadcrumb')
    <li>Inscription</li>
@endsection

@push('styles')
<style>
    .register_section .register_card {
        border-radius: 4px;
        overflow: hidden;
    }
    .section_title .title_text span {
        color: #860000;
    }
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
    .already_account {
        font-size: 14px;
        color: #555;
        margin-top: 15px;
        display: block;
    }
    .already_account a {
        color: #860000;
        font-weight: 600;
        text-decoration: none;
    }
    .already_account a:hover {
        text-decoration: underline;
    }
    .register_note {
        font-size: 13px;
        color: #777;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')

<!-- register_section - start -->
<section class="register_section sec_ptb_100 clearfix">
    <div class="container">

        <div class="register_card mb-0" data-bg-color="#F2F2F2" data-aos="fade-up" data-aos-delay="100">

            <div class="section_title mb_30 text-center">
                <h2 class="title_text mb-0" data-aos="fade-up" data-aos-delay="200">
                    <span>Créer un compte</span>
                </h2>
                <p class="mt-2 mb-0" style="color:#666;font-size:14px;">
                    Rejoignez WidriveU et réservez votre véhicule facilement au Bénin.
                </p>
            </div>

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="alert-errors" data-aos="fade-up" data-aos-delay="100">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="row justify-content-lg-between">

                    {{-- Left column --}}
                    <div class="col-lg-6 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="300">

                        {{-- Name --}}
                        <div class="form_item">
                            <input type="text"
                                   name="name"
                                   placeholder="Nom complet *"
                                   value="{{ old('name') }}"
                                   class="{{ $errors->has('name') ? 'is-invalid-input' : '' }}"
                                   required>
                            @error('name')
                                <span class="invalid-feedback-custom">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form_item">
                            <input type="email"
                                   name="email"
                                   placeholder="Adresse email *"
                                   value="{{ old('email') }}"
                                   class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}"
                                   required>
                            @error('email')
                                <span class="invalid-feedback-custom">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="form_item">
                            <input type="tel"
                                   name="phone"
                                   placeholder="Numéro de téléphone (ex: +229 94 08 08 08)"
                                   value="{{ old('phone') }}"
                                   class="{{ $errors->has('phone') ? 'is-invalid-input' : '' }}">
                            @error('phone')
                                <span class="invalid-feedback-custom">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    {{-- Right column --}}
                    <div class="col-lg-6 col-md-6 col-sm-12" data-aos="fade-up" data-aos-delay="500">

                        {{-- Password --}}
                        <div class="form_item">
                            <input type="password"
                                   name="password"
                                   placeholder="Mot de passe *"
                                   class="{{ $errors->has('password') ? 'is-invalid-input' : '' }}"
                                   required>
                            @error('password')
                                <span class="invalid-feedback-custom">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form_item">
                            <input type="password"
                                   name="password_confirmation"
                                   placeholder="Confirmer le mot de passe *"
                                   required>
                        </div>

                        {{-- Note --}}
                        <p class="register_note">
                            Vos données personnelles seront utilisées pour gérer votre compte et vos réservations de véhicules conformément à notre politique de confidentialité.
                        </p>

                        {{-- Submit --}}
                        <button type="submit" class="custom_btn bg_default_red text-uppercase mb-0">
                            Créer mon compte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
                        </button>

                        {{-- Already have account --}}
                        <span class="already_account">
                            Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
                        </span>

                    </div>

                </div>
            </form>

        </div>

    </div>
</section>
<!-- register_section - end -->

@endsection
