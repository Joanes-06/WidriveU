@extends('layouts.app')

@section('title', 'Connexion')
@section('header_class', 'secondary_header')

@section('breadcrumb_title', 'Connexion')
@section('breadcrumb')
    <li>Connexion</li>
@endsection

@push('styles')
<style>
    .register_section .register_card {
        border-radius: 4px;
        overflow: hidden;
    }
    .reg_form {
        padding: 40px;
    }
    .reg_form .form_title {
        font-family: 'Sora', sans-serif;
        font-size: 28px;
        color: #000C21;
        margin-bottom: 10px;
    }
    .reg_form p {
        color: #666;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .reg_form .new_account {
        display: block;
        margin-bottom: 20px;
        font-size: 14px;
        color: #555;
    }
    .reg_form .new_account a {
        color: #860000;
        font-weight: 600;
        text-decoration: none;
    }
    .reg_form .new_account a:hover {
        text-decoration: underline;
    }
    .reg_form .reset_pass {
        display: block;
        margin-top: 15px;
        font-size: 13px;
        text-align: right;
    }
    .reg_form .reset_pass a {
        color: #860000;
        text-decoration: none;
    }
    .reg_form .reset_pass a:hover {
        text-decoration: underline;
    }
    .form_item .is-invalid-input {
        border-color: #dc3545 !important;
    }
    .invalid-feedback-custom {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        display: block;
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
    .reg_image img {
        width: 100%;
        height: 100%;
        min-height: 400px;
        object-fit: cover;
        display: block;
    }
    @media (max-width: 991px) {
        .reg_image { display: none; }
        .reg_form { padding: 30px 20px; }
    }
    .checkbox_input label {
        cursor: pointer;
        font-size: 13px;
        color: #555;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endpush

@section('content')

<!-- register_section - start -->
<section class="register_section sec_ptb_100 clearfix">
    <div class="container">

        <div class="register_card mb-0" data-bg-color="#F2F2F2" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-stretch">

                {{-- Left: image --}}
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="reg_image">
                        <img src="{{ asset('assets/images/about/locationAuto.png') }}" alt="WidriveU connexion">
                    </div>
                </div>

                {{-- Right: form --}}
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="reg_form" data-aos="fade-up" data-aos-delay="300">

                        <h3 class="form_title">Connexion à votre compte</h3>
                        <p>Accédez à votre espace personnel pour gérer vos réservations de véhicules.</p>
                        <span class="new_account mb_15">
                            Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
                        </span>

                        {{-- Validation errors --}}
                        @if($errors->any())
                            <div class="alert-errors">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            {{-- Email --}}
                            <div class="form_item" data-aos="fade-up" data-aos-delay="400">
                                <input type="email"
                                       name="email"
                                       placeholder="Votre adresse email *"
                                       value="{{ old('email') }}"
                                       class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}"
                                       required
                                       autofocus>
                                @error('email')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form_item" data-aos="fade-up" data-aos-delay="500">
                                <input type="password"
                                       name="password"
                                       placeholder="Votre mot de passe *"
                                       class="{{ $errors->has('password') ? 'is-invalid-input' : '' }}"
                                       required>
                                @error('password')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Remember me --}}
                            <div class="checkbox_input mb_15" data-aos="fade-up" data-aos-delay="600">
                                <label for="remember_me">
                                    <input type="checkbox" id="remember_me" name="remember">
                                    Se souvenir de moi
                                </label>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="custom_btn bg_default_red text-uppercase"
                                    data-aos="fade-up" data-aos-delay="700">
                                Se connecter <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
                            </button>

                            {{-- Forgot password --}}
                            <span class="reset_pass mb_15" data-aos="fade-up" data-aos-delay="800">
                                <a href="#!">Mot de passe oublié ?</a>
                            </span>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<!-- register_section - end -->

@endsection
