@extends('layouts.dashboard')

@section('title', 'Mon profil')
@section('page_title', 'Mon profil')

@push('styles')
<style>

    /* ── SHARED PANEL ─────────────────────────────────── */
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
    }
    .db_panel_title {
        font-family: 'Sora', sans-serif;
        font-size: 14px; font-weight: 700; color: #111827;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .db_panel_title i { color: #860000; font-size: 13px; }

    /* ── AVATAR HERO ──────────────────────────────────── */
    .pf_hero {
        display: flex; align-items: center; gap: 20px;
        padding: 24px 24px 20px;
        border-bottom: 1px solid #F3F4F6;
    }
    .pf_avatar {
        width: 64px; height: 64px; border-radius: 50%;
        background: #860000; color: #fff;
        font-family: 'Sora', sans-serif;
        font-size: 22px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pf_hero_name {
        font-family: 'Sora', sans-serif;
        font-size: 18px; font-weight: 700; color: #111827;
        margin-bottom: 3px;
    }
    .pf_hero_email { font-size: 12px; color: #9CA3AF; }
    .pf_hero_badge {
        display: inline-block;
        background: #D1FAE5; color: #065F46;
        font-size: 10px; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: 0.4px;
        margin-top: 5px;
    }

    /* ── GRID ─────────────────────────────────────────── */
    .pf_grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }

    /* ── FORM ─────────────────────────────────────────── */
    .pf_form { padding: 22px 24px; }
    .pf_field { margin-bottom: 16px; }
    .pf_field:last-of-type { margin-bottom: 0; }
    .pf_label {
        display: block;
        font-family: 'Sora', sans-serif;
        font-size: 11px; font-weight: 700;
        color: #374151;
        text-transform: uppercase; letter-spacing: 0.4px;
        margin-bottom: 6px;
    }
    .pf_input {
        width: 100%; padding: 10px 14px;
        border: 1.5px solid #E5E7EB; border-radius: 8px;
        font-family: 'Sora', sans-serif; font-size: 13px;
        color: #111827; background: #FAFBFC;
        outline: none; transition: border-color 0.15s;
        box-sizing: border-box;
    }
    .pf_input:focus { border-color: #860000; background: #fff; }
    .pf_input.is_error { border-color: #DC2626; background: #FEF2F2; }
    .pf_error {
        font-size: 11px; color: #DC2626; margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .pf_hint { font-size: 11px; color: #9CA3AF; margin-top: 4px; }

    /* ── FORM FOOTER ──────────────────────────────────── */
    .pf_form_footer {
        padding: 14px 24px;
        border-top: 1px solid #F3F4F6;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px;
    }
    .pf_submit {
        display: inline-flex; align-items: center; gap: 7px;
        background: #860000; color: #fff;
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;
        text-transform: uppercase; letter-spacing: 0.3px;
        transition: opacity 0.15s;
    }
    .pf_submit:hover { opacity: 0.85; }
    .pf_submit.gray {
        background: #111827;
    }

    /* ── ALERT ────────────────────────────────────────── */
    .pf_alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 8px;
        font-size: 12px; font-weight: 600; margin: 0 24px 16px;
    }
    .pf_alert.success { background: #D1FAE5; color: #065F46; }
    .pf_alert.error   { background: #FEE2E2; color: #991B1B; }

    /* ── PASSWORD STRENGTH ────────────────────────────── */
    .pf_strength { margin-top: 6px; }
    .pf_strength_bar {
        height: 4px; border-radius: 2px; background: #F3F4F6;
        overflow: hidden; margin-bottom: 4px;
    }
    .pf_strength_fill {
        height: 100%; border-radius: 2px;
        transition: width 0.3s, background 0.3s;
        width: 0;
    }
    .pf_strength_text { font-size: 10px; color: #9CA3AF; }

    /* ── RESPONSIVE ───────────────────────────────────── */
    @media (max-width: 900px) {
        .pf_grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@php
    $parts    = explode(' ', trim($user->name));
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (isset($parts[1])) $initials .= strtoupper(substr($parts[1], 0, 1));
@endphp

{{-- Avatar hero --}}
<div class="db_panel" style="margin-bottom:24px;">
    <div class="pf_hero">
        <div class="pf_avatar">{{ $initials }}</div>
        <div>
            <div class="pf_hero_name">{{ $user->name }}</div>
            <div class="pf_hero_email">{{ $user->email }}</div>
            <span class="pf_hero_badge">Client</span>
        </div>
    </div>
</div>

<div class="pf_grid">

    {{-- ── INFORMATIONS PERSONNELLES ────────────────── --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-user"></i>
                    Informations personnelles
                </h3>
            </div>

            @if(session('success_info'))
                <div class="pf_alert success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success_info') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update.info') }}">
                @csrf
                <div class="pf_form">

                    <div class="pf_field">
                        <label class="pf_label" for="name">Nom complet</label>
                        <input type="text"
                               id="name" name="name"
                               class="pf_input {{ $errors->has('name') ? 'is_error' : '' }}"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf_field">
                        <label class="pf_label" for="email">Adresse e-mail</label>
                        <input type="email"
                               id="email" name="email"
                               class="pf_input {{ $errors->has('email') ? 'is_error' : '' }}"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf_field">
                        <label class="pf_label" for="phone">Téléphone</label>
                        <input type="tel"
                               id="phone" name="phone"
                               class="pf_input {{ $errors->has('phone') ? 'is_error' : '' }}"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="+229 00 00 00 00">
                        @error('phone')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf_field">
                        <label class="pf_label" for="address">Adresse</label>
                        <input type="text"
                               id="address" name="address"
                               class="pf_input {{ $errors->has('address') ? 'is_error' : '' }}"
                               value="{{ old('address', $user->address) }}"
                               placeholder="Cotonou, Bénin">
                        @error('address')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="pf_form_footer">
                    <span style="font-size:11px;color:#9CA3AF;">
                        <i class="fas fa-shield-alt" style="color:#860000;margin-right:4px;"></i>
                        Vos données sont sécurisées
                    </span>
                    <button type="submit" class="pf_submit">
                        <i class="fas fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MOT DE PASSE ────────────────────────────── --}}
    <div>
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title">
                    <i class="fas fa-lock"></i>
                    Mot de passe
                </h3>
            </div>

            @if(session('success_password'))
                <div class="pf_alert success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success_password') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update.password') }}">
                @csrf
                <div class="pf_form">

                    <div class="pf_field">
                        <label class="pf_label" for="current_password">Mot de passe actuel</label>
                        <input type="password"
                               id="current_password" name="current_password"
                               class="pf_input {{ $errors->has('current_password') ? 'is_error' : '' }}"
                               autocomplete="current-password">
                        @error('current_password')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf_field">
                        <label class="pf_label" for="password">Nouveau mot de passe</label>
                        <input type="password"
                               id="password" name="password"
                               class="pf_input {{ $errors->has('password') ? 'is_error' : '' }}"
                               autocomplete="new-password"
                               oninput="checkStrength(this.value)">
                        <div class="pf_strength">
                            <div class="pf_strength_bar">
                                <div class="pf_strength_fill" id="strength_fill"></div>
                            </div>
                            <span class="pf_strength_text" id="strength_text"></span>
                        </div>
                        @error('password')
                            <div class="pf_error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pf_field">
                        <label class="pf_label" for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password"
                               id="password_confirmation" name="password_confirmation"
                               class="pf_input"
                               autocomplete="new-password">
                        <div class="pf_hint">Minimum 8 caractères.</div>
                    </div>

                </div>
                <div class="pf_form_footer">
                    <span style="font-size:11px;color:#9CA3AF;">
                        <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                        Vous serez toujours connecté
                    </span>
                    <button type="submit" class="pf_submit gray">
                        <i class="fas fa-key"></i> Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function checkStrength(val) {
    var fill = document.getElementById('strength_fill');
    var text = document.getElementById('strength_text');
    if (!val) { fill.style.width = '0'; text.textContent = ''; return; }
    var score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    var levels = [
        { w: '20%',  bg: '#DC2626', label: 'Très faible' },
        { w: '40%',  bg: '#F59E0B', label: 'Faible' },
        { w: '60%',  bg: '#F59E0B', label: 'Moyen' },
        { w: '80%',  bg: '#10B981', label: 'Fort' },
        { w: '100%', bg: '#065F46', label: 'Très fort' },
    ];
    var lvl = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = lvl.w;
    fill.style.background = lvl.bg;
    text.textContent = lvl.label;
    text.style.color = lvl.bg;
}
</script>
@endpush
