@extends('layouts.admin')
@section('title', 'Réservation — ' . $reservation->reservation_number)
@section('page_title', 'Détail réservation')

@section('content')

<a href="{{ route('admin.reservations.index') }}" class="adm_back">
    <i class="fas fa-chevron-left"></i> Retour aux réservations
</a>

{{-- Identifiants client présentiel --}}
@if(session('credentials'))
@php $creds = session('credentials'); @endphp
<div style="background:#FEF3C7;border:1.5px solid #FCD34D;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:flex-start;gap:14px;">
    <div style="width:36px;height:36px;background:#F59E0B;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fas fa-key" style="color:#fff;font-size:15px;"></i>
    </div>
    <div style="flex:1;">
        <div style="font-weight:700;color:#92400E;font-size:13px;margin-bottom:6px;">Identifiants de connexion du client — à communiquer maintenant</div>
        <div style="display:flex;gap:20px;flex-wrap:wrap;">
            <div style="font-size:13px;color:#78350F;">
                <span style="color:#92400E;font-weight:600;">Email :</span>
                <code style="background:#FDE68A;padding:2px 8px;border-radius:4px;font-size:13px;">{{ $creds['email'] }}</code>
            </div>
            <div style="font-size:13px;color:#78350F;">
                <span style="color:#92400E;font-weight:600;">Mot de passe :</span>
                <code style="background:#FDE68A;padding:2px 8px;border-radius:4px;font-size:13px;">{{ $creds['password'] }}</code>
            </div>
        </div>
        <div style="font-size:11px;color:#92400E;margin-top:8px;opacity:.7;"><i class="fas fa-exclamation-triangle"></i> Ces informations ne s'afficheront qu'une seule fois. Notez-les avant de quitter cette page.</div>
    </div>
</div>
@endif

{{-- Page header --}}
<div class="adm_page_hd">
    <div>
        <h2 style="display:flex;align-items:center;gap:10px;">
            {{ $reservation->reservation_number }}
            @php
                $sc = ['active'=>'active','pending'=>'pending','completed'=>'completed','cancelled'=>'cancelled'][$reservation->status] ?? 'completed';
                $sl = ['active'=>'En cours','pending'=>'En attente','completed'=>'Terminée','cancelled'=>'Annulée'][$reservation->status] ?? $reservation->status;
            @endphp
            <span class="db_badge {{ $sc }}">{{ $sl }}</span>
            <span class="db_badge dark" style="font-size:9px;">
                {{ $reservation->type === 'avec_chauffeur' ? 'Avec chauffeur' : 'Sans chauffeur' }}
            </span>
        </h2>
        <p>Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
    </div>
</div>

<div class="adm_grid wide">

    {{-- LEFT --}}
    <div>

        {{-- Details --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-calendar-alt"></i> Détails</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-car"></i></div>
                    <div><div class="adm_info_lbl">Véhicule</div><div class="adm_info_val">{{ $reservation->vehicle->name ?? '—' }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-calendar"></i></div>
                    <div>
                        <div class="adm_info_lbl">Période</div>
                        <div class="adm_info_val">{{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="adm_info_lbl">Horaires</div>
                        <div class="adm_info_val">Départ {{ $reservation->departure_time }} — Retour {{ $reservation->return_time }}</div>
                    </div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-hourglass"></i></div>
                    <div><div class="adm_info_lbl">Durée</div><div class="adm_info_val">{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</div></div>
                </div>
                @if($reservation->zone)
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div><div class="adm_info_lbl">Zone</div><div class="adm_info_val">{{ $reservation->zone->name }}</div></div>
                </div>
                @endif
                @if($reservation->current_position)
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-map-pin"></i></div>
                    <div><div class="adm_info_lbl">Position de départ</div><div class="adm_info_val">{{ $reservation->current_position }}</div></div>
                </div>
                @endif
            </div>
        </div>

        {{-- Financial --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-receipt"></i> Résumé financier</h3>
            </div>
            <table class="db_table">
                <tbody>
                    <tr>
                        <td style="color:#6B7280;">Tarif journalier</td>
                        <td class="fw7" style="text-align:right;">
                            {{ number_format($reservation->type === 'avec_chauffeur' ? $reservation->vehicle->price_with_driver : $reservation->vehicle->price_without_driver) }} FCFA/j
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#6B7280;">Durée</td>
                        <td class="fw7" style="text-align:right;">{{ $reservation->days }} jour{{ $reservation->days > 1 ? 's' : '' }}</td>
                    </tr>
                    <tr>
                        <td style="color:#6B7280;">Sous-total</td>
                        <td class="fw7" style="text-align:right;">{{ number_format($reservation->subtotal) }} FCFA</td>
                    </tr>
                    @if($reservation->discount_percentage > 0)
                    <tr>
                        <td style="color:#059669;">Remise ({{ $reservation->discount_percentage }}%)</td>
                        <td style="text-align:right;color:#059669;font-weight:700;">− {{ number_format($reservation->discount_amount) }} FCFA</td>
                    </tr>
                    @endif
                    <tr style="background:#F5F6FA;">
                        <td class="fw7">Total payé</td>
                        <td class="fw7 text_red" style="text-align:right;font-size:16px;">{{ number_format($reservation->total) }} FCFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Extensions --}}
        @if($reservation->extensions->count() > 0)
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-calendar-plus"></i> Prolongations</h3>
            </div>
            <table class="db_table">
                <thead>
                    <tr>
                        <th>Nouvelle fin</th>
                        <th>Jours ajoutés</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Payé le</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservation->extensions as $ext)
                    <tr>
                        <td class="fw7">{{ \Carbon\Carbon::parse($ext->new_end_date)->format('d/m/Y') }}</td>
                        <td>+{{ $ext->days }}j</td>
                        <td class="fw7 no_wrap">{{ number_format($ext->amount) }} FCFA</td>
                        <td><span class="db_badge {{ $ext->status === 'paid' ? 'active' : 'pending' }}">{{ $ext->status === 'paid' ? 'Payée' : 'En attente' }}</span></td>
                        <td class="text_muted" style="font-size:12px;">{{ $ext->paid_at ? \Carbon\Carbon::parse($ext->paid_at)->format('d/m/Y') : '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>

    {{-- RIGHT --}}
    <div>

        {{-- Status card --}}
        <div class="db_panel" style="{{ $reservation->status === 'active' ? 'background:#FFFFF;border-color:#00000;' : '' }} margin-bottom:16px;">
            <div class="db_panel_body">
                <div style="text-align:center;padding:10px 0;">
                    <span class="db_badge {{ $sc }}" style="font-size:12px;padding:6px 18px;margin-bottom:14px;display:inline-block;">{{ $sl }}</span>
                    <div style="{{ $reservation->status === 'active' ? 'color:00000;' : 'color:#00000;' }} font-size:11px;margin-bottom:6px;">
                        {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}
                    </div>
                    @if($reservation->paid_at)
                    <div style="{{ $reservation->status === 'active' ? 'color:#00000' : 'color:#00000;' }} font-size:11px;">
                        Payé le {{ $reservation->paid_at->format('d/m/Y à H:i') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Client --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-user"></i> Client</h3>
                @if($reservation->user)
                <a href="{{ route('admin.users.show', $reservation->user) }}" class="db_panel_act">Voir profil →</a>
                @endif
            </div>
            <div class="db_panel_body">
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-user"></i></div>
                    <div><div class="adm_info_lbl">Nom</div><div class="adm_info_val">{{ $reservation->user->name ?? '—' }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-envelope"></i></div>
                    <div><div class="adm_info_lbl">Email</div><div class="adm_info_val">{{ $reservation->email }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-phone"></i></div>
                    <div><div class="adm_info_lbl">Téléphone</div><div class="adm_info_val">{{ $reservation->phone }}</div></div>
                </div>
            </div>
        </div>

        {{-- Payment --}}
        @if($reservation->transaction_id)
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-credit-card"></i> Paiement</h3>
            </div>
            <div class="db_panel_body">
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-hashtag"></i></div>
                    <div><div class="adm_info_lbl">Transaction ID</div><div class="adm_info_val mono">{{ $reservation->transaction_id }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-calendar-check"></i></div>
                    <div><div class="adm_info_lbl">Payé le</div><div class="adm_info_val">{{ $reservation->paid_at?->format('d/m/Y à H:i') ?? '—' }}</div></div>
                </div>
                <div class="adm_info_row">
                    <div class="adm_info_icon"><i class="fas fa-mobile-alt"></i></div>
                    <div><div class="adm_info_lbl">Méthode</div><div class="adm_info_val">KKiaPay · Mobile Money</div></div>
                </div>
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="db_panel">
            <div class="db_panel_head">
                <h3 class="db_panel_title"><i class="fas fa-bolt"></i> Actions</h3>
            </div>
            <div class="db_panel_body" style="display:flex;flex-direction:column;gap:8px;">
                @if($reservation->status === 'active')
                    <button type="button" class="adm_btn dark" style="justify-content:center;"
                        onclick="document.getElementById('completeModal').classList.add('open')">
                        <i class="fas fa-check-circle"></i> Marquer comme terminée
                    </button>
                    <button type="button" class="adm_btn gray" style="justify-content:center;"
                        onclick="document.getElementById('availableModal').classList.add('open')">
                        <i class="fas fa-car"></i> Rendre le véhicule disponible
                    </button>
                    <button type="button" class="adm_btn outline" style="justify-content:center;"
                        onclick="document.getElementById('cancelModal').classList.add('open')">
                        <i class="fas fa-times"></i> Annuler la réservation
                    </button>
                @elseif($reservation->status === 'pending')
                    <button type="button" class="adm_btn outline" style="justify-content:center;"
                        onclick="document.getElementById('cancelModal').classList.add('open')">
                        <i class="fas fa-times"></i> Annuler la réservation
                    </button>
                @else
                    <p class="text_muted" style="text-align:center;font-size:12px;margin:8px 0;">Aucune action disponible</p>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Cancel Modal --}}
<div class="adm_modal_overlay" id="cancelModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Annuler la réservation</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;margin-bottom:16px;">Confirmer l'annulation de <strong>{{ $reservation->reservation_number }}</strong> ?</p>
                <div class="adm_form_group">
                    <label class="adm_form_label">Motif</label>
                    <textarea name="cancellation_reason" class="adm_input adm_textarea" placeholder="Raison de l'annulation…"></textarea>
                </div>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Fermer</button>
                <button type="submit" class="adm_btn red"><i class="fas fa-times"></i> Confirmer</button>
            </div>
        </form>
    </div>
</div>

{{-- Complete Modal --}}
<div class="adm_modal_overlay" id="completeModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Terminer la réservation</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.reservations.complete', $reservation) }}">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;">Marquer <strong>{{ $reservation->reservation_number }}</strong> comme terminée ? Le véhicule redeviendra disponible.</p>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Fermer</button>
                <button type="submit" class="adm_btn dark"><i class="fas fa-check"></i> Confirmer</button>
            </div>
        </form>
    </div>
</div>

{{-- Available Modal --}}
<div class="adm_modal_overlay" id="availableModal">
    <div class="adm_modal">
        <div class="adm_modal_head">
            <h4 class="adm_modal_title">Rendre le véhicule disponible</h4>
            <button type="button" class="adm_modal_close" onclick="this.closest('.adm_modal_overlay').classList.remove('open')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.reservations.available', $reservation) }}">
            @csrf @method('PUT')
            <div class="adm_modal_body">
                <p style="font-size:13px;color:#374151;">Remettre <strong>{{ $reservation->vehicle->name ?? 'le véhicule' }}</strong> en statut disponible ?</p>
            </div>
            <div class="adm_modal_foot">
                <button type="button" class="adm_btn gray" onclick="this.closest('.adm_modal_overlay').classList.remove('open')">Fermer</button>
                <button type="submit" class="adm_btn dark"><i class="fas fa-car"></i> Confirmer</button>
            </div>
        </form>
    </div>
</div>

@endsection
