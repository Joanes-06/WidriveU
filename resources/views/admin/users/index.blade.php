@extends('layouts.admin')
@section('title', 'Clients')
@section('page_title', 'Clients')

@section('content')

<div class="adm_page_hd">
    <div>
        <h2>Clients</h2>
        <p>{{ $users->total() }} client{{ $users->total() > 1 ? 's' : '' }} inscrit{{ $users->total() > 1 ? 's' : '' }}</p>
    </div>
</div>

<form method="GET" action="{{ route('admin.users.index') }}">
<div class="adm_filter_bar">
    <input type="text" name="search" class="adm_search" placeholder="Nom, email, téléphone…" value="{{ request('search') }}">
    <button type="submit" class="adm_btn dark sm"><i class="fas fa-search"></i> Rechercher</button>
    @if(request('search'))
    <a href="{{ route('admin.users.index') }}" class="adm_btn gray sm"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
</form>

<div class="db_panel">
    <table class="db_table">
        <thead>
            <tr>
                <th style="width:60px;">#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Réservations</th>
                <th>Inscrit le</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            <tr class="clickable" onclick="window.location='{{ route('admin.users.show', $u) }}'">
                <td class="mono text_muted">{{ $u->id }}</td>
                <td class="fw7">{{ $u->name }}</td>
                <td class="text_muted">{{ $u->email }}</td>
                <td class="text_muted">{{ $u->phone ?? '—' }}</td>
                <td>
                    @if($u->reservations_count > 0)
                    <span class="db_badge dark">{{ $u->reservations_count }}</span>
                    @else
                    <span class="text_muted">0</span>
                    @endif
                </td>
                <td class="text_muted" style="font-size:12px;">{{ $u->created_at->format('d/m/Y') }}</td>
                <td onclick="event.stopPropagation();">
                    <div class="gap_row">
                        <a href="{{ route('admin.users.show', $u) }}" class="tc_icon_btn dark" title="Voir le profil">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.reservations.create') }}?user_id={{ $u->id }}" class="tc_icon_btn" title="Créer une réservation">
                            <i class="fas fa-plus" style="color:#860000;"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="adm_empty"><i class="fas fa-users"></i><p>Aucun client trouvé</p></div></td></tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="adm_pager">
        <span>Page {{ $users->currentPage() }} / {{ $users->lastPage() }}</span>
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
