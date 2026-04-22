<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #1a1a1a;
        background: #fff;
    }
    a { text-decoration: none; color: inherit; }

    /* ══════════════════════════════════════════
       HEADER BAND
    ══════════════════════════════════════════ */
    .header {
        background: #C8001A;
        padding: 0;
    }
    .header-inner {
        display: table;
        width: 100%;
    }
    .header-left {
        display: table-cell;
        vertical-align: middle;
        padding: 22px 28px;
        width: 55%;
    }
    .header-right {
        display: table-cell;
        vertical-align: middle;
        padding: 22px 28px;
        text-align: right;
    }
    .doc-title {
        font-size: 30px;
        font-weight: bold;
        color: #fff;
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .doc-subtitle {
        font-size: 10px;
        color: rgba(255,255,255,0.65);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-top: 4px;
    }
    .company-name {
        font-size: 14px;
        font-weight: bold;
        color: #fff;
    }
    .company-info {
        font-size: 9px;
        color: rgba(255,255,255,0.75);
        line-height: 1.7;
        margin-top: 3px;
    }

    /* ══════════════════════════════════════════
       BODY
    ══════════════════════════════════════════ */
    .body { padding: 28px 28px 0; }

    /* ── CLIENT + META ── */
    .info-block {
        display: table;
        width: 100%;
        margin-bottom: 24px;
    }
    .client-cell {
        display: table-cell;
        vertical-align: top;
        width: 52%;
        padding-right: 20px;
    }
    .meta-cell {
        display: table-cell;
        vertical-align: top;
    }
    .block-label {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #C8001A;
        margin-bottom: 8px;
        border-bottom: 1.5px solid #C8001A;
        padding-bottom: 4px;
    }
    .client-name {
        font-size: 13px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 3px;
    }
    .client-detail {
        font-size: 10px;
        color: #4B5563;
        line-height: 1.7;
    }

    /* meta table (Date, N° reçu…) */
    .meta-table { width: 100%; border-collapse: collapse; }
    .meta-table td {
        font-size: 10px;
        padding: 4px 0;
        border-bottom: 1px solid #F3F4F6;
    }
    .meta-table td:first-child { color: #6B7280; width: 48%; }
    .meta-table td:last-child  { font-weight: bold; color: #1a1a1a; text-align: right; }

    /* ── ITEMS TABLE ── */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
    .items-table thead tr {
        background: #1a1a1a;
    }
    .items-table thead th {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #fff;
        padding: 9px 10px;
        text-align: left;
    }
    .items-table thead th.right { text-align: right; }
    .items-table tbody tr {
        border-bottom: 1px solid #F0F0F0;
    }
    .items-table tbody tr:nth-child(even) { background: #FAFAFA; }
    .items-table tbody td {
        font-size: 10px;
        color: #1a1a1a;
        padding: 10px 10px;
        vertical-align: top;
    }
    .items-table tbody td.right { text-align: right; font-weight: bold; }
    .items-table tbody td.muted { color: #6B7280; }
    .items-desc-main { font-weight: bold; font-size: 10px; color: #1a1a1a; }
    .items-desc-sub  { font-size: 9px; color: #9CA3AF; margin-top: 2px; }

    /* ── TOTALS ── */
    .totals-wrap {
        display: table;
        width: 100%;
        margin-top: 0;
    }
    .totals-spacer {
        display: table-cell;
        width: 55%;
    }
    .totals-cell {
        display: table-cell;
        width: 45%;
        vertical-align: top;
    }
    .totals-inner { border-top: 2px solid #E5E7EB; }
    .tot-row {
        display: table;
        width: 100%;
        padding: 8px 10px;
        border-bottom: 1px solid #F0F0F0;
    }
    .tot-label { display: table-cell; font-size: 10px; color: #6B7280; }
    .tot-value { display: table-cell; text-align: right; font-size: 10px; font-weight: bold; color: #1a1a1a; }
    .tot-row.grand {
        background: #C8001A;
    }
    .tot-row.grand .tot-label {
        color: rgba(255,255,255,0.85);
        font-weight: bold;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .tot-row.grand .tot-value {
        color: #fff;
        font-size: 14px;
    }
    .tot-row.discount .tot-value { color: #059669; }

    /* ── TRANSACTION BAND ── */
    .txn-band {
        background: #F9FAFB;
        border-top: 1px solid #E5E7EB;
        border-bottom: 1px solid #E5E7EB;
        padding: 12px 28px;
        margin-top: 24px;
    }
    .txn-inner { display: table; width: 100%; }
    .txn-col { display: table-cell; vertical-align: top; width: 33.33%; padding-right: 16px; }
    .txn-col:last-child { padding-right: 0; }
    .txn-title {
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #9CA3AF;
        margin-bottom: 4px;
    }
    .txn-value {
        font-size: 10px;
        font-weight: bold;
        color: #1a1a1a;
        line-height: 1.5;
    }

    /* ── FOOTER ── */
    .footer {
        padding: 14px 28px;
        display: table;
        width: 100%;
        border-top: 2px solid #1a1a1a;
        margin-top: 0;
    }
    .foot-col { display: table-cell; vertical-align: top; width: 33.33%; padding-right: 16px; }
    .foot-col:last-child { padding-right: 0; }
    .foot-title {
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #C8001A;
        margin-bottom: 4px;
    }
    .foot-line { font-size: 9px; color: #4B5563; line-height: 1.7; }
</style>
</head>
<body>

{{-- ══ HEADER ══ --}}
<div class="header">
    <div class="header-inner">
        <div class="header-left">
            <div class="doc-title">Reçu</div>
            <div class="doc-subtitle">Paiement confirmé</div>
        </div>
        <div class="header-right">
            <div class="company-name">WidriveU</div>
            <div class="company-info">
                Cotonou, Bénin<br>
                contact@widriveu.com<br>
                +229 94 08 08 08
            </div>
        </div>
    </div>
</div>

{{-- ══ BODY ══ --}}
<div class="body">

    {{-- CLIENT + META --}}
    <div class="info-block">

        <div class="client-cell">
            <div class="block-label">Client</div>
            <div class="client-name">{{ $reservation->user->name ?? 'N/A' }}</div>
            <div class="client-detail">
                {{ $reservation->email }}<br>
                {{ $reservation->phone }}
                @if($reservation->user->address)
                    <br>{{ $reservation->user->address }}
                @endif
            </div>
        </div>

        <div class="meta-cell">
            <div class="block-label">Détails du reçu</div>
            <table class="meta-table">
                <tr>
                    <td>Date</td>
                    <td>{{ $reservation->paid_at ? $reservation->paid_at->format('d/m/Y') : now()->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>N° Reçu</td>
                    <td>{{ $reservation->reservation_number }}</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>Payé</td>
                </tr>
                <tr>
                    <td>Méthode</td>
                    <td>Mobile Money</td>
                </tr>
            </table>
        </div>

    </div>

    {{-- ITEMS TABLE --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:40%;">Description</th>
                <th>Période</th>
                <th class="right">Durée</th>
                <th class="right">Prix / jour</th>
                <th class="right">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="items-desc-main">{{ $reservation->vehicle->name ?? 'Véhicule' }}</div>
                    <div class="items-desc-sub">
                        {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
                        @if($reservation->zone) &bull; {{ $reservation->zone->name }} @endif
                    </div>
                </td>
                <td class="muted">
                    {{ $reservation->start_date->format('d/m/Y') }}<br>
                    {{ $reservation->end_date->format('d/m/Y') }}
                </td>
                <td class="right">{{ $reservation->days }} j</td>
                <td class="right">
                    @if($reservation->type === 'avec_chauffeur')
                        {{ number_format($reservation->vehicle->price_with_driver ?? 0) }}
                    @else
                        {{ number_format($reservation->vehicle->price_without_driver ?? 0) }}
                    @endif
                    <span style="font-size:9px;color:#9CA3AF;font-weight:normal;"> FCFA</span>
                </td>
                <td class="right">{{ number_format($reservation->subtotal) }} FCFA</td>
            </tr>
        </tbody>
    </table>

    {{-- TOTALS --}}
    <div class="totals-wrap">
        <div class="totals-spacer"></div>
        <div class="totals-cell">
            <div class="totals-inner">
                <div class="tot-row">
                    <span class="tot-label">Sous-total</span>
                    <span class="tot-value">{{ number_format($reservation->subtotal) }} FCFA</span>
                </div>
                @if($reservation->discount_percentage > 0)
                <div class="tot-row discount">
                    <span class="tot-label">Remise ({{ $reservation->discount_percentage }}%)</span>
                    <span class="tot-value">− {{ number_format($reservation->discount_amount) }} FCFA</span>
                </div>
                @endif
                <div class="tot-row grand">
                    <span class="tot-label">Total payé</span>
                    <span class="tot-value">{{ number_format($reservation->total) }} FCFA</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ══ TRANSACTION ══ --}}
<div class="txn-band">
    <div class="txn-inner">
        <div class="txn-col">
            <div class="txn-title">Transaction ID</div>
            <div class="txn-value">{{ $reservation->transaction_id ?? 'N/A' }}</div>
        </div>
        <div class="txn-col">
            <div class="txn-title">Date &amp; heure</div>
            <div class="txn-value">{{ $reservation->paid_at ? $reservation->paid_at->format('d/m/Y à H:i') : 'N/A' }}</div>
        </div>
        <div class="txn-col">
            <div class="txn-title">Plateforme</div>
            <div class="txn-value">KKiaPay<br><span style="font-weight:normal;font-size:9px;color:#9CA3AF;">Mobile Money</span></div>
        </div>
    </div>
</div>

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <div class="foot-col">
        <div class="foot-title">Émetteur</div>
        <div class="foot-line">
            WidriveU<br>
            Cotonou, Bénin
        </div>
    </div>
    <div class="foot-col">
        <div class="foot-title">Contact</div>
        <div class="foot-line">
            Tél : +229 94 08 08 08<br>
            Email : contact@widriveu.com
        </div>
    </div>
    <div class="foot-col">
        <div class="foot-title">Note</div>
        <div class="foot-line">
            Document officiel.<br>
            Conservez ce reçu.
        </div>
    </div>
</div>

</body>
</html>
