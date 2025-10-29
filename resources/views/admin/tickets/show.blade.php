@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Ticket #{{ $ticket->id }} — Administration</h1>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $ticket->id }}</dd>

            <dt class="col-sm-3">Utilisateur</dt>
            <dd class="col-sm-9">{{ $ticket->user?->name }} ({{ $ticket->user?->email }})</dd>

            <dt class="col-sm-3">Vol</dt>
            <dd class="col-sm-9">
                @if($ticket->vol)
                    <div class="small text-muted">ID: {{ $ticket->vol->id }}</div>
                    {{ $ticket->vol->origine }} → {{ $ticket->vol->destination }}
                    <div class="small text-muted">{{ \Illuminate\Support\Carbon::parse($ticket->vol->date_depart)->format('Y-m-d H:i') }}</div>
                @else
                    <em class="text-muted">Vol supprimé</em>
                @endif
            </dd>

            <dt class="col-sm-3">Quantité</dt>
            <dd class="col-sm-9">{{ $ticket->quantite }}</dd>

            <dt class="col-sm-3">Créé</dt>
            <dd class="col-sm-9">{{ $ticket->created_at?->format('Y-m-d H:i') }}</dd>

            <dt class="col-sm-3">Mis à jour</dt>
            <dd class="col-sm-9">{{ $ticket->updated_at?->format('Y-m-d H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-primary">Éditer</a>
    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
@endsection
