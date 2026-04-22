<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — WidriveU</title>
    <link rel="shortcut icon" href="{{ asset('logo/widriveu-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">

    <style>
        :root {
            --font-body:    'Poppins', sans-serif;
            --font-display: 'Sora', sans-serif;
            --red:   #860000;
            --dark:  #111827;
            --gray:  #6B7280;
            --light: #F5F6FA;
            --border:#F0F1F3;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; height: 100%; font-family: var(--font-body); background: #F5F6FA; color: #111827; font-size: 14px; }

        /* ── APP SHELL ─────────────────────────────── */
        .app_shell { display: flex; min-height: 100vh; }

        /* ── SIDEBAR ───────────────────────────────── */
        .app_sidebar {
            width: 240px; flex-shrink: 0; background: #fff;
            border-right: 1px solid var(--border); display: flex;
            flex-direction: column; position: fixed; left: 0; top: 0;
            bottom: 0; z-index: 200; overflow-y: auto;
        }
        .sb_logo { padding: 22px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #F5F5F5; flex-shrink: 0; }
        .sb_logo_mark { width: 34px; height: 34px; background: var(--red); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sb_logo_mark i { color: #fff; font-size: 14px; }
        .sb_logo_text { display: flex; flex-direction: column; }
        .sb_logo_name { font-size: 17px; font-weight: 800; color: #000C21; letter-spacing: -0.3px; line-height: 1.1; }
        .sb_logo_name span { color: var(--red); }
        .sb_logo_badge { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: var(--red); }

        .sb_section { padding: 18px 12px 4px; }
        .sb_section_label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.4px; color: #9CA3AF; padding: 0 8px; margin-bottom: 4px; display: block; }
        .sb_sep { height: 1px; background: #F5F5F5; margin: 6px 20px; }
        .sb_spacer { flex: 1; }

        .sb_linko { display: flex; align-items: center; gap: 6px; padding: 5px 8px; border-radius: 8px; font-size: 13px; font-weight: 600; color: #6B7280; text-decoration: none !important; transition: all 0.15s; margin-bottom: 1px; white-space: nowrap;  }
        .sb_linko { color: #ffffff; background: #860000; }
        .sb_linko:hover { color: #ffffff; background-color: #a50015 }

        .sb_link { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 8px; font-size: 13px; font-weight: 600; color: #6B7280; text-decoration: none !important; transition: all 0.15s; margin-bottom: 1px; white-space: nowrap; }
        .sb_link_icon { width: 30px; height: 30px; border-radius: 7px; background: transparent; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; transition: background 0.15s; }
        .sb_link:hover { color: #111827; background: #F5F6FA; }
        .sb_link:hover .sb_link_icon { background: #EBEBEB; }
        .sb_link.is_active { color: #fff; background: var(--red); }
        .sb_link.is_active .sb_link_icon { background: rgba(255,255,255,0.18); color: #fff; }

        .sb_user { padding: 12px; border-top: 1px solid #F5F5F5; flex-shrink: 0; }
        .sb_user_card { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 8px; background: #F5F6FA; transition: background 0.15s; }
        .sb_user_card:hover { background: #EBEBEB; }
        .sb_user_avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--dark); color: #fff; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sb_user_name { font-size: 12px; font-weight: 700; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb_user_role { font-size: 10px; color: var(--red); font-weight: 600; }

        /* ── MAIN ──────────────────────────────────── */
        .app_main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .app_topbar { height: 62px; background: #fff; border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 28px; gap: 14px; position: sticky; top: 0; z-index: 100; flex-shrink: 0; }
        .topbar_title { font-family: var(--font-display); font-size: 17px; font-weight: 700; color: #111827; margin: 0; }
        .topbar_spacer { flex: 1; }
        .topbar_actions { display: flex; align-items: center; gap: 6px; }
        .topbar_icon_btn { width: 36px; height: 36px; border-radius: 8px; background: #F5F6FA; border: none; color: #6B7280; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 13px; text-decoration: none; transition: all 0.15s; }
        .topbar_icon_btn:hover { background: #EBEBEB; color: #111827; text-decoration: none; }
        .topbar_avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--dark); color: #fff !important; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; margin-left: 4px; text-decoration: none !important; transition: opacity 0.15s; }
        .topbar_avatar:hover { opacity: 0.85; color: #fff !important; }
        .app_content { flex: 1; padding: 28px; overflow-y: auto; }

        /* ── FLASH MESSAGES ────────────────────────── */
        .flash_msg { padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .flash_msg.success { background: #D1FAE5; color: #065F46; }
        .flash_msg.error   { background: #FEE2E2; color: #991B1B; }
        .flash_msg.warning { background: #FEF3C7; color: #92400E; }

        /* ── STAT CARDS ────────────────────────────── */
        .db_stat_grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .db_stat { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 20px; }
        .db_stat.accent { background: var(--dark); border-color: var(--dark); }
        .db_stat.accent .db_stat_val,
        .db_stat.accent .db_stat_label { color: #fff; }
        .db_stat.accent .db_stat_icon { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); }
        
        .db_stat.accent .db_stat_sub { color: rgba(255,255,255,0.4); }
        .db_stat.red_accent { background: var(--red); border-color: var(--red); }
        .db_stat.red_accent .db_stat_val,
        .db_stat.red_accent .db_stat_label { color: #fff; }
        .db_stat.red_accent .db_stat_icon { background: rgba(255,255,255,0.2); color: #fff; }
        .db_stat_top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .db_stat_icon { width: 38px; height: 38px; border-radius: 9px; background: #F5F6FA; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #6B7280; }
        .db_stat_badge { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #9CA3AF; }
        .db_stat_val { font-size: 28px; font-weight: 800; color: #111827; line-height: 1; font-family: var(--font-display); }
        .db_stat_val.lg { font-size: 36px; }
        .db_stat_label { font-size: 11px; color: #6B7280; margin-top: 4px; font-weight: 500; }
        .db_stat_sub { font-size: 10px; color: #9CA3AF; margin-top: 3px; }

        /* ── PANELS ────────────────────────────────── */
        .db_panel { background: #fff; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 20px; overflow: hidden; }
        .db_panel_head { padding: 16px 20px; border-bottom: 1px solid #F5F5F5; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .db_panel_title { font-size: 13px; font-weight: 700; color: #111827; display: flex; align-items: center; gap: 8px; margin: 0; }
        .db_panel_title i { color: var(--red); font-size: 11px; }
        .db_panel_act { font-size: 11px; color: var(--red); font-weight: 600; text-decoration: none !important; }
        .db_panel_act:hover { text-decoration: underline !important; }
        .db_panel_body { padding: 20px; }

        /* ── TABLE ─────────────────────────────────── */
        .db_table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .db_table thead tr { background: #111827; }
        .db_table thead th { padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.6); white-space: nowrap; }
        .db_table tbody tr { border-bottom: 1px solid #F5F6FA; transition: background 0.1s; }
        .db_table tbody tr:last-child { border-bottom: none; }
        .db_table tbody tr:hover { background: #FAFAFA; }
        .db_table tbody tr.clickable { cursor: pointer; }
        .db_table tbody td { padding: 13px 16px; vertical-align: middle; color: #374151; }
        .db_table tfoot td { padding: 10px 16px; font-size: 12px; color: #9CA3AF; border-top: 1px solid #F0F1F3; }

        /* ── BADGES ────────────────────────────────── */
        .db_badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase; white-space: nowrap; }
        .db_badge.active      { background: #D1FAE5; color: #065F46; }
        .db_badge.pending     { background: #FEF3C7; color: #92400E; }
        .db_badge.completed   { background: #F3F4F6; color: #374151; }
        .db_badge.cancelled   { background: #FEE2E2; color: #991B1B; }
        .db_badge.available   { background: #D1FAE5; color: #065F46; }
        .db_badge.reserved    { background: #FEE2E2; color: #991B1B; }
        .db_badge.maintenance { background: #FEF3C7; color: #92400E; }
        .db_badge.dark        { background: var(--dark); color: #fff; }

        /* ── BUTTONS ───────────────────────────────── */
        .adm_btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none !important; transition: all 0.15s; white-space: nowrap; font-family: var(--font-body); outline: none; }
        .adm_btn:focus { outline: none; }
        .adm_btn.red   { background: var(--red); color: #fff; }
        .adm_btn.red:hover { background: #c40019; color: #fff; }
        .adm_btn.dark  { background: var(--dark); color: #fff; }
        .adm_btn.dark:hover { background: #000; color: #fff; }
        .adm_btn.gray  { background: #F5F6FA; color: #374151; border: 1px solid #E5E7EB; }
        .adm_btn.gray:hover { background: #EBEBEB; color: #111827; }
        .adm_btn.outline { background: transparent; color: var(--red); border: 1.5px solid var(--red); }
        .adm_btn.outline:hover { background: var(--red); color: #fff; }
        .adm_btn.sm { padding: 6px 12px; font-size: 11px; }
        .adm_btn.icon_only { padding: 8px 12px; }
        .tc_icon_btn { width: 32px; height: 32px; border-radius: 7px; background: #F5F6FA; border: 1px solid #E5E7EB; color: #6B7280; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; cursor: pointer; text-decoration: none !important; transition: all 0.15s; outline: none; }
        .tc_icon_btn:focus { outline: none; }
        .tc_icon_btn:hover { background: #EBEBEB; color: #111827; }
        .tc_icon_btn.dark { background: #111827; border-color: #111827; color: #fff; }
        .tc_icon_btn.dark:hover { background: #000; }
        .tc_icon_btn.red { background: var(--red); border-color: var(--red); color: #fff; }

        /* ── FORM ELEMENTS ─────────────────────────── */
        .adm_form_row { display: grid; gap: 16px; margin-bottom: 0; }
        .adm_form_row.cols2 { grid-template-columns: 1fr 1fr; }
        .adm_form_row.cols3 { grid-template-columns: 1fr 1fr 1fr; }
        .adm_form_group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 16px; }
        .adm_form_label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6B7280; }
        .adm_form_label .req { color: var(--red); margin-left: 2px; }
        .adm_input { width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 13px; color: #111827; background: #fff; outline: none; font-family: var(--font-body); transition: border-color 0.15s; }
        .adm_input:focus { border-color: #111827; box-shadow: 0 0 0 3px rgba(17,24,39,0.06); }
        .adm_input.is_invalid { border-color: var(--red); }
        .adm_select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; cursor: pointer; }
        .adm_textarea { min-height: 90px; resize: vertical; }
        .adm_form_hint { font-size: 11px; color: #9CA3AF; }
        .adm_form_error { font-size: 11px; color: var(--red); margin-top: 2px; }

        /* ── FILTER BAR ────────────────────────────── */
        .adm_filter_bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .adm_search { flex: 1; min-width: 200px; padding: 10px 14px 10px 38px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 13px; background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 12px center; outline: none; color: #111827; font-family: var(--font-body); }
        .adm_search:focus { border-color: #111827; }
        .adm_filter_select { padding: 10px 36px 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 13px; background: #fff; outline: none; color: #374151; font-family: var(--font-body); appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; cursor: pointer; }
        .adm_filter_select:focus { border-color: #111827; }

        /* ── INFO ROWS ─────────────────────────────── */
        .adm_info_row { display: flex; gap: 12px; padding: 11px 0; border-bottom: 1px solid #F5F6FA; align-items: flex-start; }
        .adm_info_row:last-child { border-bottom: none; }
        .adm_info_icon { width: 30px; height: 30px; border-radius: 7px; background: #F5F6FA; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #6B7280; flex-shrink: 0; }
        .adm_info_lbl { font-size: 10px; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .adm_info_val { font-size: 13px; font-weight: 600; color: #111827; margin-top: 1px; }

        /* ── GRIDS ─────────────────────────────────── */
        .adm_grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
        .adm_grid.wide { grid-template-columns: 1fr 360px; }
        .adm_grid.equal { grid-template-columns: 1fr 1fr; }

        /* ── PAGE HEADER ───────────────────────────── */
        .adm_page_hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; gap: 12px; }
        .adm_page_hd h2 { font-family: var(--font-display); font-size: 20px; font-weight: 700; color: #111827; margin: 0; }
        .adm_page_hd p { font-size: 12px; color: #9CA3AF; margin: 3px 0 0; }

        /* ── BACK LINK ─────────────────────────────── */
        .adm_back { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 1px; text-decoration: none !important; margin-bottom: 20px; transition: color 0.15s; }
        .adm_back:hover { color: #111827; }

        /* ── MODALS ────────────────────────────────── */
        .adm_modal_overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 999; align-items: center; justify-content: center; }
        .adm_modal_overlay.open { display: flex; }
        .adm_modal { background: #fff; border-radius: 14px; width: 100%; max-width: 460px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
        .adm_modal_head { padding: 20px 24px 16px; border-bottom: 1px solid #F0F1F3; display: flex; align-items: center; justify-content: space-between; }
        .adm_modal_title { font-size: 15px; font-weight: 700; color: #111827; margin: 0; }
        .adm_modal_close { width: 30px; height: 30px; border-radius: 7px; background: #F5F6FA; border: none; cursor: pointer; font-size: 13px; color: #6B7280; display: flex; align-items: center; justify-content: center; }
        .adm_modal_body { padding: 20px 24px; }
        .adm_modal_foot { padding: 14px 24px; border-top: 1px solid #F0F1F3; display: flex; gap: 10px; justify-content: flex-end; }

        /* ── PAGINATION ────────────────────────────── */
        .adm_pager { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid #F5F6FA; font-size: 12px; color: #9CA3AF; flex-wrap: wrap; gap: 10px; }
        .adm_pager .page-link { color: #374151; border-radius: 6px; padding: 5px 10px; font-size: 12px; }
        .adm_pager .page-item.active .page-link { background: var(--dark); border-color: var(--dark); color: #fff; }

        /* ── UPLOAD ────────────────────────────────── */
        .adm_upload_zone { border: 2px dashed #E5E7EB; border-radius: 10px; padding: 24px; text-align: center; cursor: pointer; transition: border-color 0.15s; }
        .adm_upload_zone:hover { border-color: #111827; }
        .adm_upload_zone i { font-size: 28px; color: #D1D5DB; margin-bottom: 8px; display: block; }
        .adm_upload_zone p { font-size: 12px; color: #9CA3AF; margin: 0; }

        /* ── SECTION LABEL ─────────────────────────── */
        .adm_section_lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #9CA3AF; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #F0F1F3; display: flex; align-items: center; gap: 8px; }

        /* ── PROGRESS ──────────────────────────────── */
        .adm_progress { height: 5px; background: #F0F1F3; border-radius: 3px; overflow: hidden; }
        .adm_progress_bar { height: 100%; background: var(--red); border-radius: 3px; transition: width 0.8s ease; }

        /* ── EMPTY STATE ───────────────────────────── */
        .adm_empty { padding: 48px 20px; text-align: center; }
        .adm_empty i { font-size: 36px; color: #E5E7EB; margin-bottom: 12px; display: block; }
        .adm_empty p { font-size: 14px; color: #9CA3AF; margin: 0; }

        /* ── HELPERS ───────────────────────────────── */
        .text_red   { color: var(--red) !important; }
        .text_muted { color: #000000 !important; }
        .text_green { color: #059669 !important; }
        .fw7 { font-weight: 700 !important; }
        .mono { font-family: 'Courier New', monospace; font-size: 12px; }
        .no_wrap { white-space: nowrap; }
        .gap_row { display: flex; align-items: center; gap: 6px; }

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

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <aside class="app_sidebar">

        <div class="sb_logo">
            <img src="{{ asset('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:52px;object-fit:contain;flex-shrink:0;">
        </div>
        

        <div class="sb_section">
            <span class="sb_section_label">Principal</span>
            <a href="{{ route('admin.dashboard') }}"
               class="sb_link {{ request()->routeIs('admin.dashboard') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-th-large"></i></span>
                Tableau de bord
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Parc auto</span>
            <a href="{{ route('admin.vehicles.index') }}"
               class="sb_link {{ request()->routeIs('admin.vehicles.index') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-car"></i></span>
                Véhicules
            </a>
            <a href="{{ route('admin.vehicles.create') }}"
               class="sb_link {{ request()->routeIs('admin.vehicles.create') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-plus-circle"></i></span>
                Ajouter
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Réservations</span>
            <a href="{{ route('admin.reservations.index') }}"
               class="sb_link {{ request()->routeIs('admin.reservations.index') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-list"></i></span>
                Toutes
            </a>
            <a href="{{ route('admin.reservations.active') }}"
               class="sb_link {{ request()->routeIs('admin.reservations.active') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-play-circle"></i></span>
                En cours
            </a>
            <a href="{{ route('admin.reservations.expired') }}"
               class="sb_link {{ request()->routeIs('admin.reservations.expired') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-exclamation-triangle"></i></span>
                Expirées
            </a>
            <a href="{{ route('admin.reservations.create') }}"
               class="sb_link {{ request()->routeIs('admin.reservations.create') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-plus"></i></span>
                Créer
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Clients</span>
            <a href="{{ route('admin.users.index') }}"
               class="sb_link {{ request()->routeIs('admin.users.*') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-users"></i></span>
                Liste des clients
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Analytique & Système</span>
            <a href="{{ route('admin.statistics') }}"
               class="sb_link {{ request()->routeIs('admin.statistics') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-chart-bar"></i></span>
                Statistiques
            </a>
            <a href="{{ route('admin.zones.index') }}"
               class="sb_link {{ request()->routeIs('admin.zones.index') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-map-marker-alt"></i></span>
                Zones
            </a>
            <a href="{{ route('admin.settings.index') }}"
               class="sb_link {{ request()->routeIs('admin.settings.*') ? 'is_active' : '' }}">
                <span class="sb_link_icon"><i class="fas fa-cog"></i></span>
                Paramètres
            </a>
        </div>

        <div class="sb_section">
            <div class="sb_sep"></div>
            <span class="sb_section_label">Autre</span>
            <a href="{{ route('home') }}" class="sb_link">
                <span class="sb_link_icon"><i class="fas fa-globe"></i></span>
                Site web
            </a>            
        </div>

        <div class="sb_spacer"></div>

        <div class="sb_user">
            <div class="sb_user_card">
                <div class="sb_user_avatar">{{ $__initials }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="sb_user_name">{{ auth()->user()->name }}</div>
                    <div class="sb_user_role">Administrateur</div>
                </div>
            </div>
        </div>

    </aside>
    <!-- ══════════════ END SIDEBAR ══════════════ -->

    <!-- ══════════════ MAIN ══════════════ -->
    <div class="app_main">

        <header class="app_topbar">
            <h1 class="topbar_title">@yield('page_title', 'Administration')</h1>
            <div class="topbar_spacer"></div>
            <div class="topbar_actions">
                <a href="{{ route('admin.vehicles.create') }}" class="topbar_icon_btn" title="Ajouter un véhicule">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{ route('home') }}" class="topbar_icon_btn" title="Site web">
                    <i class="fas fa-home"></i>
                </a>
                 <a href="#" class="sb_linko"
               onclick="event.preventDefault();document.getElementById('sb_logout').submit();">
                <span class="sb_link_icon"><i class="fas fa-sign-out-alt"></i></span>
                Déconnexion
            </a>
            <form id="sb_logout" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>

        </header>

        <main class="app_content">

            @if(session('success'))
            <div class="flash_msg success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash_msg error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif
            @if(session('warning'))
            <div class="flash_msg warning">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
            @endif

            @yield('content')
        </main>

    </div>
    <!-- ══════════════ END MAIN ══════════════ -->

</div>

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

@stack('scripts')
</body>
</html>
