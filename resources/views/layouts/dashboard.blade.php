<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tableau de bord') — WidriveU</title>
    <link rel="shortcut icon" href="{{ asset('logo/widriveu-logo.png') }}">

    <!-- Fonts: Sora (display) + Poppins (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">

    <style>
        /* ── FONT SWITCH ───────────────────────────────────────
           Pour revenir à Sora uniquement, changer --font-body
           en 'Sora', sans-serif  dans les 3 layouts.
        ─────────────────────────────────────────────────────── */
        :root {
            --font-body:    'Poppins', sans-serif;
            --font-display: 'Sora', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: var(--font-body);
            background: #F5F6FA;
            color: #111827;
            font-size: 14px;
        }

        /* ============================================================
           APP SHELL
           ============================================================ */
        .app_shell {
            display: flex;
            min-height: 100vh;
        }

        /* ============================================================
           SIDEBAR
           ============================================================ */
        .app_sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid #F0F1F3;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 200;
            overflow-y: auto;
        }

        /* Logo */
        .sb_logo {
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #F5F5F5;
            flex-shrink: 0;
        }

        .sb_logo_mark {
            width: 34px;
            height: 34px;
            background: #860000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb_logo_mark i { color: #fff; font-size: 14px; }

        .sb_logo_name {
            font-size: 17px;
            font-weight: 800;
            color: #000C21;
            letter-spacing: -0.3px;
        }

        .sb_logo_name span { color: #860000; }

        /* Nav sections */
        .sb_section { padding: 18px 12px 4px; }

        .sb_section_label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #9CA3AF;
            padding: 0 8px;
            margin-bottom: 4px;
            display: block;
        }

        .sb_link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #6B7280;
            text-decoration: none !important;
            transition: all 0.15s ease;
            margin-bottom: 1px;
            white-space: nowrap;
        }

        .sb_link_icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            transition: background 0.15s;
        }

        .sb_link:hover {
            color: #111827;
            background: #F5F6FA;
        }

        .sb_link:hover .sb_link_icon {
            background: #EBEBEB;
        }

        .sb_link.is_active {
            color: #fff;
            background: #860000;
        }

        .sb_link.is_active .sb_link_icon {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        .sb_sep {
            height: 1px;
            background: #F5F5F5;
            margin: 6px 20px;
        }

        /* Sidebar spacer */
        .sb_spacer { flex: 1; }

        /* User card at bottom */
        .sb_user {
            padding: 12px;
            border-top: 1px solid #F5F5F5;
            flex-shrink: 0;
        }

        .sb_user_card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 8px;
            background: #F5F6FA;
            text-decoration: none !important;
            transition: background 0.15s;
        }
        .sb_user_card:hover {
            background: #EBEBEB;
        }

        .sb_user_avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #860000;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb_user_name {
            font-size: 12px;
            font-weight: 700;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sb_user_role {
            font-size: 10px;
            color: #9CA3AF;
        }

        /* ============================================================
           MAIN WRAPPER
           ============================================================ */
        .app_main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ============================================================
           TOPBAR
           ============================================================ */
        .app_topbar {
            height: 62px;
            background: #fff;
            border-bottom: 1px solid #F0F1F3;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 14px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }

        .topbar_title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .topbar_spacer { flex: 1; }

        .topbar_actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar_icon_btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #F5F6FA;
            border: none;
            color: #6B7280;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.15s;
        }

        .topbar_icon_btn:hover {
            background: #EBEBEB;
            color: #111827;
            text-decoration: none;
        }

        .topbar_avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #860000;
            color: #fff !important;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-left: 4px;
            text-decoration: none !important;
            transition: opacity 0.15s;
        }
        .topbar_avatar:hover {
            opacity: 0.85;
            color: #fff !important;
            text-decoration: none !important;
        }

        /* ============================================================
           PAGE CONTENT
           ============================================================ */
        .app_content {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
        }

        .overflow-x-hidden {
        overflow-x: hidden;
        }
    </style>

    @stack('styles')
</head>
<body class="overflow-x-hidden">

@php
    $__parts    = explode(' ', trim(auth()->user()->name));
    $__initials = strtoupper(substr($__parts[0], 0, 1));
    if (isset($__parts[1])) $__initials .= strtoupper(substr($__parts[1], 0, 1));
@endphp

<div class="app_shell">

    <!-- ===================== SIDEBAR ===================== -->
    <aside class="app_sidebar">

        <div class="sb_logo">
            <img src="{{ asset('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:52px;object-fit:contain;">
        </div>

        <div class="sb_section">
            <span class="sb_section_label">Menu principal</span>

            <a href="{{ route('dashboard') }}"
               class="sb_link {{ request()->routeIs('dashboard') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-th-large"></i></span>
                Tableau de bord
            </a>

            <a href="{{ route('reservations.index') }}"
               class="sb_link {{ request()->routeIs('reservations.*') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-calendar-check"></i></span>
                Mes réservations
            </a>

            <a href="{{ route('fleet') }}" class="sb_link">
                <span class="sb_link_icon"><i class="fas fa-car"></i></span>
                Nos véhicules
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Autre</span>

            <a href="{{ route('profile.edit') }}"
               class="sb_link {{ request()->routeIs('profile.*') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-user-cog"></i></span>
                Mon profil
            </a>

            <a href="{{ route('home') }}" class="sb_link">
                <span class="sb_link_icon"><i class="fas fa-globe"></i></span>
                Retour au site
            </a>

            <a href="#" class="sb_link"
               onclick="event.preventDefault();document.getElementById('topbar_logout').submit();">
                <span class="sb_link_icon"><i class="fas fa-sign-out-alt"></i></span>
                Déconnexion
            </a>

            <form id="topbar_logout" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>

        <div class="sb_spacer"></div>

        <div class="sb_user">
            <div class="sb_user_card" style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:8px;background:#F5F6FA;transition:background 0.15s;">
                <div class="sb_user_avatar">{{ $__initials }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="sb_user_name">{{ auth()->user()->name }}</div>
                    <div class="sb_user_role">Client</div>
                </div>
            </div>
        </div>

    </aside>
    <!-- ===================== END SIDEBAR ===================== -->


    <!-- ===================== MAIN ===================== -->
    <div class="app_main">

        <!-- Topbar -->
        <header class="app_topbar">
            <h1 class="topbar_title">@yield('page_title', 'Tableau de bord')</h1>
            <div class="topbar_spacer"></div>
            <div class="topbar_actions">
                <a href="{{ route('fleet') }}" class="topbar_icon_btn" title="Réserver un véhicule">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{ route('home') }}" class="topbar_icon_btn" title="Site web">
                    <i class="fas fa-home"></i>
                </a>
            </div>
        </header>

        <!-- Page content -->
        <main class="app_content">
            @yield('content')
        </main>

    </div>
    <!-- ===================== END MAIN ===================== -->

</div>

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script>AOS.init({ duration: 400, once: true, offset: 20 });</script>

@stack('scripts')
</body>
</html>
