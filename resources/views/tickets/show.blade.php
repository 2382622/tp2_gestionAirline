@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Ticket #{{ $ticket->id }}</h1>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('warning')) <div class="alert alert-warning">{{ session('warning') }}</div> @endif

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Détails</h5>

            <dl class="row mb-0">
                <dt class="col-sm-3">Vol</dt>
                <dd class="col-sm-9">
                    @if($ticket->vol)
                        <div class="fw-semibold">
                            {{ $ticket->vol->id }} — {{ $ticket->vol->origine }} → {{ $ticket->vol->destination }}
                        </div>
                        <small class="text-muted">
                            Départ: {{ \Carbon\Carbon::parse($ticket->vol->date_depart)->format('Y-m-d H:i') }}<br>
                            Arrivée: {{ \Carbon\Carbon::parse($ticket->vol->date_arrive)->format('Y-m-d H:i') }}
                        </small>
                        @if($ticket->vol->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/images/upload/'.$ticket->vol->photo) }}"
                                     alt="Photo vol {{ $ticket->vol->id }}" style="max-height:140px">
                            </div>
                        @endif
                    @else
                        <em class="text-muted">Vol supprimé</em>
                    @endif
                </dd>

                <dt class="col-sm-3">Utilisateur</dt>
                <dd class="col-sm-9">{{ optional($ticket->user)->name ?? '—' }}</dd>

                <dt class="col-sm-3">Quantité</dt>
                <dd class="col-sm-9">{{ $ticket->quantite }}</dd>

                <dt class="col-sm-3">Créé</dt>
                <dd class="col-sm-9">{{ optional($ticket->created_at)->format('Y-m-d H:i') }}</dd>

                <dt class="col-sm-3">Mis à jour</dt>
                <dd class="col-sm-9">{{ optional($ticket->updated_at)->format('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Éditer</a>
        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
              onsubmit="return confirm('Supprimer ce ticket ?');">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Supprimer</button>
        </form>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection
