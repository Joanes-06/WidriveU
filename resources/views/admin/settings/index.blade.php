@extends('layouts.admin')
@section('title', 'Paramètres')
@section('page_title', 'Paramètres système')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Paramètres système</h2>
        <p>Réductions, tarification et zones de service</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf

<div class="adm_grid wide">

    {{-- LEFT --}}
    <div>

        {{-- Zones link --}}
        <div class="db_panel">
            <div class="db_panel_body">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:44px;height:44px;border-radius:10px;background:#F5F6FA;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-map-marker-alt" style="color:#374151;font-size:17px;"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="font-weight:700;color:#111827;font-size:14px;margin-bottom:2px;">Zones de desserte</div>
                        <div style="font-size:12.5px;color:#9CA3AF;">Ajoutez, modifiez ou supprimez les zones depuis la page dédiée.</div>
                    </div>
                    <a href="{{ route('admin.zones.index') }}" class="adm_btn dark sm" style="flex-shrink:0;">
                        <i class="fas fa-arrow-right"></i> Gérer
                    </a>
                </div>
            </div>
        </div>

        {{-- Réductions --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-percent"></i> Politique de réduction par durée</h3>
            </div>
            <div class="db_panel_body">
                <p style="font-size:13px;color:#9CA3AF;margin-bottom:20px;line-height:1.6;">
                    Ces paliers s'appliquent automatiquement lors de la réservation selon la durée choisie.
                </p>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">

                    {{-- Palier 1 --}}
                    <div style="border:1.5px solid #E5E7EB;border-radius:10px;padding:20px;text-align:center;background:#F9FAFB;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#9CA3AF;margin-bottom:12px;">Seuil 1 — 7 à 13 j.</div>
                        <div style="display:flex;align-items:center;justify-content:center;gap:2px;">
                            <input type="number" name="discount_7_days" min="0" max="50"
                                   value="{{ $settings->get('discount_7_days', '15') }}"
                                   style="width:60px;text-align:center;font-size:2rem;font-weight:800;color:#111827;border:none;background:transparent;outline:none;">
                            <span style="font-size:1.4rem;font-weight:800;color:#111827;">%</span>
                        </div>
                        <div style="font-size:11px;color:#9CA3AF;margin-top:6px;">min. 7 jours</div>
                    </div>

                    {{-- Palier 2 --}}
                    <div style="border:1.5px solid #860000;border-radius:10px;padding:20px;text-align:center;background:#FFF1F2;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#860000;margin-bottom:12px;">Seuil 2 — 14 à 20 j.</div>
                        <div style="display:flex;align-items:center;justify-content:center;gap:2px;">
                            <input type="number" name="discount_14_days" min="0" max="50"
                                   value="{{ $settings->get('discount_14_days', '18') }}"
                                   style="width:60px;text-align:center;font-size:2rem;font-weight:800;color:#860000;border:none;background:transparent;outline:none;">
                            <span style="font-size:1.4rem;font-weight:800;color:#860000;">%</span>
                        </div>
                        <div style="font-size:11px;color:#860000;opacity:.6;margin-top:6px;">min. 14 jours</div>
                    </div>

                    {{-- Palier 3 --}}
                    <div style="border:1.5px solid #111827;border-radius:10px;padding:20px;text-align:center;background:#111827;">
                        <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:12px;">Seuil 3 — 21+ jours</div>
                        <div style="display:flex;align-items:center;justify-content:center;gap:2px;">
                            <input type="number" name="discount_21_days" min="0" max="50"
                                   value="{{ $settings->get('discount_21_days', '20') }}"
                                   style="width:60px;text-align:center;font-size:2rem;font-weight:800;color:#fff;border:none;background:transparent;outline:none;">
                            <span style="font-size:1.4rem;font-weight:800;color:#fff;">%</span>
                        </div>
                        <div style="font-size:11px;color:rgba(255,255,255,.35);margin-top:6px;">min. 21 jours</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Multiplicateur chauffeur --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-user-tie"></i> Prix avec chauffeur</h3>
            </div>
            <div class="db_panel_body">
                <p style="font-size:13px;color:#9CA3AF;margin-bottom:20px;line-height:1.6;">
                    Le prix avec chauffeur est calculé en multipliant le prix sans chauffeur par ce coefficient.
                </p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;align-items:end;">
                    <div class="adm_form_group" style="margin-bottom:0;">
                        <label class="adm_form_label">Coefficient multiplicateur</label>
                        <input type="number" step="0.1" min="1" max="5" name="price_with_driver_multiplier"
                               id="multiplierInput" class="adm_input"
                               value="{{ $settings->get('price_with_driver_multiplier', '1.5') }}">
                        <span class="adm_form_hint">Valeur recommandée : 1.5</span>
                    </div>
                    <div style="background:#F5F6FA;border-radius:8px;padding:14px 18px;font-size:13px;color:#374151;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                            <span style="color:#9CA3AF;">Sans chauffeur</span>
                            <strong>100 000 FCFA</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="color:#860000;font-weight:600;">Avec chauffeur</span>
                            <strong id="multiplierResult" style="color:#860000;">150 000 FCFA</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div>
        <div style="position:sticky;top:80px;">

            {{-- Résumé --}}
            <div class="db_panel">
                <div class="db_panel_head">
                    <h3 class="db_panel_title"><i class="fas fa-eye"></i> Résumé actuel</h3>
                </div>
                <div class="db_panel_body">
                    <div style="display:flex;flex-direction:column;gap:8px;">

                        <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;background:#F9FAFB;border-radius:8px;border:1px solid #E5E7EB;">
                            <div>
                                <div style="font-size:10px;color:#9CA3AF;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">7 – 13 jours</div>
                                <div style="font-size:11.5px;color:#6B7280;">Seuil 1</div>
                            </div>
                            <div style="font-size:1.4rem;font-weight:800;color:#111827;">{{ $settings->get('discount_7_days', '15') }}%</div>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;background:#FFF1F2;border-radius:8px;border:1px solid #FECDD3;">
                            <div>
                                <div style="font-size:10px;color:#860000;opacity:.7;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">14 – 20 jours</div>
                                <div style="font-size:11.5px;color:#860000;opacity:.6;">Seuil 2</div>
                            </div>
                            <div style="font-size:1.4rem;font-weight:800;color:#860000;">{{ $settings->get('discount_14_days', '18') }}%</div>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;background:#111827;border-radius:8px;">
                            <div>
                                <div style="font-size:10px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">21+ jours</div>
                                <div style="font-size:11.5px;color:rgba(255,255,255,.4);">Seuil 3</div>
                            </div>
                            <div style="font-size:1.4rem;font-weight:800;color:#fff;">{{ $settings->get('discount_21_days', '20') }}%</div>
                        </div>

                        <div style="display:flex;align-items:center;justify-content:space-between;padding:11px 14px;background:#F9FAFB;border-radius:8px;border:1px solid #E5E7EB;">
                            <div>
                                <div style="font-size:10px;color:#9CA3AF;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;">Multiplicateur</div>
                                <div style="font-size:11.5px;color:#6B7280;">Avec chauffeur</div>
                            </div>
                            <div style="font-size:1.4rem;font-weight:800;color:#111827;">× {{ $settings->get('price_with_driver_multiplier', '1.5') }}</div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="adm_btn red" style="width:100%;justify-content:center;padding:14px;font-size:14px;margin-bottom:10px;">
                <i class="fas fa-save"></i> Enregistrer les paramètres
            </button>
            <p style="font-size:11px;color:#9CA3AF;text-align:center;">S'applique aux nouvelles réservations uniquement.</p>

        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
function updateMultiplier() {
    var m = parseFloat(document.getElementById('multiplierInput').value) || 1.5;
    var result = Math.round(100000 * m);
    document.getElementById('multiplierResult').textContent = result.toLocaleString('fr-FR') + ' FCFA';
}
document.getElementById('multiplierInput').addEventListener('input', updateMultiplier);
updateMultiplier();
</script>
@endpush
