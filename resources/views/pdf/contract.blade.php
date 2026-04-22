<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #111827;
        background: #fff;
        padding: 0;
    }

    /* ── HEADER ─────────────────────────────────────── */
    .header {
        background: #000C21;
        padding: 22px 32px;
        margin-bottom: 0;
    }
    .header-inner {
        display: table;
        width: 100%;
    }
    .header-logo {
        display: table-cell;
        vertical-align: middle;
    }
    .logo-mark {
        background: #860000;
        display: inline-block;
        padding: 6px 10px;
        border-radius: 6px;
        margin-right: 8px;
    }
    .logo-mark span { color: #fff; font-size: 16px; font-weight: bold; }
    .logo-text {
        display: inline-block;
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        vertical-align: middle;
    }
    .logo-text em { color: #860000; font-style: normal; }
    .header-right {
        display: table-cell;
        text-align: right;
        vertical-align: middle;
    }
    .header-right .doc-label {
        font-size: 11px;
        color: rgba(255,255,255,0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .header-right .doc-title {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        margin-top: 2px;
    }

    /* ── RED BAND ───────────────────────────────────── */
    .red-band {
        background: #860000;
        height: 4px;
    }

    /* ── CONTRACT NUMBER BAR ─────────────────────────── */
    .contract-bar {
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        padding: 12px 32px;
        display: table;
        width: 100%;
    }
    .contract-bar-left { display: table-cell; vertical-align: middle; }
    .contract-bar-right { display: table-cell; text-align: right; vertical-align: middle; }
    .contract-num {
        font-size: 15px;
        font-weight: bold;
        color: #111827;
        letter-spacing: 1px;
    }
    .contract-date { font-size: 10px; color: #9CA3AF; margin-top: 2px; }
    .status-badge {
        background: #D1FAE5;
        color: #065F46;
        font-size: 10px;
        font-weight: bold;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ── BODY ────────────────────────────────────────── */
    .body { padding: 28px 32px; }

    /* Section title */
    .section-title {
        font-size: 11px;
        font-weight: bold;
        color: #860000;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1.5px solid #860000;
        padding-bottom: 6px;
        margin-bottom: 14px;
        margin-top: 22px;
    }
    .section-title:first-child { margin-top: 0; }

    /* Two-column grid using table */
    .two-col { display: table; width: 100%; margin-bottom: 0; }
    .col-left  { display: table-cell; width: 48%; vertical-align: top; padding-right: 16px; }
    .col-right { display: table-cell; width: 48%; vertical-align: top; padding-left: 16px; }

    /* Info card */
    .info-card {
        background: #F9FAFB;
        border: 1px solid #F0F1F3;
        border-radius: 6px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }
    .info-card-title {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9CA3AF;
        margin-bottom: 8px;
    }
    .info-row { display: table; width: 100%; margin-bottom: 5px; }
    .info-label { display: table-cell; color: #9CA3AF; font-size: 10px; width: 42%; }
    .info-value { display: table-cell; color: #111827; font-weight: bold; font-size: 10px; }

    /* Detail table */
    .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
    .detail-table thead th {
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        padding: 8px 10px;
        text-align: left;
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9CA3AF;
    }
    .detail-table tbody td {
        padding: 9px 10px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 10px;
        color: #374151;
        vertical-align: middle;
    }
    .detail-table tbody tr:last-child td { border-bottom: none; }
    .detail-table .td-label { color: #9CA3AF; }
    .detail-table .td-value { font-weight: bold; color: #111827; text-align: right; }

    /* Financial table */
    .fin-table { width: 100%; border-collapse: collapse; }
    .fin-table tr td { padding: 8px 10px; font-size: 11px; border-bottom: 1px solid #F3F4F6; }
    .fin-table tr:last-child td { border-bottom: none; }
    .fin-table .fl { color: #6B7280; }
    .fin-table .fr { text-align: right; font-weight: bold; color: #111827; }
    .fin-table .discount .fr { color: #065F46; }
    .fin-total { background: #FEF2F2; }
    .fin-total .fl { font-weight: bold; color: #111827; font-size: 12px; }
    .fin-total .fr { color: #860000; font-size: 14px; font-weight: bold; }

    /* Clauses */
    .clause {
        margin-bottom: 8px;
        padding-left: 12px;
        border-left: 2px solid #E5E7EB;
        font-size: 9.5px;
        color: #6B7280;
        line-height: 1.6;
    }
    .clause strong { color: #374151; }

    /* Signatures */
    .sig-row { display: table; width: 100%; margin-top: 30px; }
    .sig-cell { display: table-cell; width: 45%; vertical-align: top; }
    .sig-cell-mid { display: table-cell; width: 10%; }
    .sig-label { font-size: 10px; font-weight: bold; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 50px; }
    .sig-line { border-top: 1.5px solid #E5E7EB; padding-top: 8px; font-size: 9px; color: #9CA3AF; }

    /* Footer */
    .footer {
        background: #F9FAFB;
        border-top: 1px solid #E5E7EB;
        padding: 12px 32px;
        margin-top: 28px;
        display: table;
        width: 100%;
    }
    .footer-left { display: table-cell; font-size: 9px; color: #9CA3AF; vertical-align: middle; }
    .footer-right { display: table-cell; text-align: right; font-size: 9px; color: #9CA3AF; vertical-align: middle; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="header-inner">
        <div class="header-logo">
            <img src="{{ public_path('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:58px;object-fit:contain;">
        </div>
        <div class="header-right">
            <div class="doc-label">Document officiel</div>
            <div class="doc-title">Contrat de location</div>
        </div>
    </div>
</div>
<div class="red-band"></div>

{{-- CONTRACT BAR --}}
<div class="contract-bar">
    <div class="contract-bar-left">
        <div class="contract-num">{{ $reservation->reservation_number }}</div>
        <div class="contract-date">Émis le {{ $reservation->paid_at ? $reservation->paid_at->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</div>
    </div>
    <div class="contract-bar-right">
        <span class="status-badge">Payé &amp; Confirmé</span>
    </div>
</div>

<div class="body">

    {{-- PARTIES --}}
    <div class="section-title">Parties au contrat</div>
    <div class="two-col">
        <div class="col-left">
            <div class="info-card">
                <div class="info-card-title">Le bailleur</div>
                <div class="info-row">
                    <span class="info-label">Société</span>
                    <span class="info-value">WidriveU</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse</span>
                    <span class="info-value">Cotonou, Bénin</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact</span>
                    <span class="info-value">contact@widriveu.com</span>
                </div>
            </div>
        </div>
        <div class="col-right">
            <div class="info-card">
                <div class="info-card-title">Le locataire</div>
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $reservation->user->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $reservation->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">{{ $reservation->phone }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- VEHICLE --}}
    <div class="section-title">Véhicule loué</div>
    <div class="info-card">
        <div class="two-col">
            <div class="col-left">
                <div class="info-row">
                    <span class="info-label">Véhicule</span>
                    <span class="info-value">{{ $reservation->vehicle->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Marque</span>
                    <span class="info-value">{{ $reservation->vehicle->brand ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Année</span>
                    <span class="info-value">{{ $reservation->vehicle->year ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-right">
                <div class="info-row">
                    <span class="info-label">Carburant</span>
                    <span class="info-value">{{ ucfirst($reservation->vehicle->fuel_type ?? 'N/A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Places</span>
                    <span class="info-value">{{ $reservation->vehicle->seats ?? 'N/A' }} places</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type location</span>
                    <span class="info-value">{{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- PERIOD --}}
    <div class="section-title">Période de location</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th>Début</th>
                <th>Fin</th>
                <th>Durée</th>
                <th>Départ</th>
                <th>Retour</th>
                @if($reservation->zone)<th>Zone</th>@endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reservation->start_date->format('d/m/Y') }}</td>
                <td>{{ $reservation->end_date->format('d/m/Y') }}</td>
                <td><strong>{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</strong></td>
                <td>{{ $reservation->departure_time ?? '—' }}</td>
                <td>{{ $reservation->return_time ?? '—' }}</td>
                @if($reservation->zone)<td>{{ $reservation->zone->name }}</td>@endif
            </tr>
        </tbody>
    </table>

    {{-- FINANCIAL --}}
    <div class="section-title">Récapitulatif financier</div>
    <table class="fin-table">
        <tr>
            <td class="fl">Tarif journalier</td>
            <td class="fr">
                @if($reservation->type === 'avec_chauffeur')
                    {{ number_format($reservation->vehicle->price_with_driver ?? 0) }} FCFA/j
                @else
                    {{ number_format($reservation->vehicle->price_without_driver ?? 0) }} FCFA/j
                @endif
            </td>
        </tr>
        <tr>
            <td class="fl">Durée ({{ $reservation->days }} jours)</td>
            <td class="fr">{{ number_format($reservation->subtotal) }} FCFA</td>
        </tr>
        @if($reservation->discount_percentage > 0)
        <tr class="discount">
            <td class="fl">Remise ({{ $reservation->discount_percentage }}%)</td>
            <td class="fr">− {{ number_format($reservation->discount_amount) }} FCFA</td>
        </tr>
        @endif
        <tr class="fin-total">
            <td class="fl">Total payé</td>
            <td class="fr">{{ number_format($reservation->total) }} FCFA</td>
        </tr>
    </table>

    {{-- CLAUSES --}}
    <div class="section-title">Conditions générales</div>
    <div class="clause">
        <strong>Article 1 — Objet :</strong> Le présent contrat a pour objet la location du véhicule désigné ci-dessus, par le bailleur au locataire, pour la durée et aux conditions stipulées.
    </div>
    <div class="clause">
        <strong>Article 2 — Utilisation :</strong> Le locataire s'engage à utiliser le véhicule conformément à sa destination, à ne pas le sous-louer et à le restituer en bon état.
    </div>
    <div class="clause">
        <strong>Article 3 — Responsabilité :</strong> Le locataire est responsable de tout dommage causé au véhicule pendant la durée de location. Tout accident doit être signalé immédiatement.
    </div>
    <div class="clause">
        <strong>Article 4 — Carburant :</strong> Le véhicule est remis plein de carburant et doit être restitué dans le même état.
    </div>
    <div class="clause">
        <strong>Article 5 — Retard :</strong> Tout retard dans la restitution du véhicule sera facturé au tarif journalier en vigueur.
    </div>
    <div class="clause">
        <strong>Article 6 — Paiement :</strong> Le paiement a été effectué intégralement par voie électronique (KKiaPay) avant la mise à disposition du véhicule. Transaction : {{ $reservation->transaction_id ?? 'N/A' }}.
    </div>

    {{-- SIGNATURES --}}
    <div class="sig-row">
        <div class="sig-cell">
            <div class="sig-label">Le bailleur — WidriveU</div>
            <div class="sig-line">Signature &amp; cachet</div>
        </div>
        <div class="sig-cell-mid"></div>
        <div class="sig-cell" style="text-align:right;">
            <div class="sig-label">Le locataire</div>
            <div class="sig-line">{{ $reservation->user->name ?? '' }} — Signature</div>
        </div>
    </div>

</div>

{{-- FOOTER --}}
<div class="footer">
    <div class="footer-left">
        WidriveU &bull; Cotonou, Bénin &bull; contact@widriveu.com
    </div>
    <div class="footer-right">
        Contrat N° {{ $reservation->reservation_number }} &bull; Émis le {{ now()->format('d/m/Y') }}
    </div>
</div>

</body>
</html>
