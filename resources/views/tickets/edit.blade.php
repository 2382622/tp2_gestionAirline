@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Éditer le ticket #{{ $ticket->id }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="card card-body">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Vol</label>
            <select name="vol_id" class="form-select" required>
                @foreach($vols as $v)
                    <option value="{{ $v->id }}" @selected(old('vol_id',$ticket->vol_id)==$v->id)>
                        {{ $v->id }} — {{ $v->origine }} → {{ $v->destination }}
                        ({{ \Carbon\Carbon::parse($v->date_depart)->format('Y-m-d H:i') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control" min="1"
                   value="{{ old('quantite',$ticket->quantite) }}" required>
        </div>

        @isset($users)
        <div class="mb-3">
            <label class="form-label">Utilisateur (optionnel)</label>
            <select name="user_id" class="form-select">
                <option value="">—</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" @selected(old('user_id',$ticket->user_id)==$u->id)>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endisset

        <div class="d-flex gap-2">
            <button class="btn btn-warning">Mettre à jour</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
