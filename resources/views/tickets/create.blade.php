@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Nouveau ticket</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST" class="card card-body">
        @csrf

        <div class="mb-3">
            <label class="form-label">Vol</label>
            <select name="vol_id" class="form-select" required>
                <option value="">-- Choisir --</option>
                @foreach($vols as $v)
                    <option value="{{ $v->id }}" @selected(old('vol_id') == $v->id)>
                        {{ $v->id }} — {{ $v->origine }} → {{ $v->destination }}
                        ({{ \Illuminate\Support\Carbon::parse($v->date_depart)->format('Y-m-d H:i') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantité</label>
            <input type="number" name="quantite" class="form-control" min="1" value="{{ old('quantite', 1) }}" required>
        </div>

        {{-- Pas de user_id ici : il sera fixé côté contrôleur à Auth::id() --}}

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Créer</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
