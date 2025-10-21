@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier le vol #{{ $vol->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vols.update', $vol->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Origine</label>
            <input type="text" name="origine" class="form-control" value="{{ $vol->origine }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" value="{{ $vol->destination }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de départ</label>
            <input type="date" name="date_depart" class="form-control"
                   value="{{ \Carbon\Carbon::parse($vol->date_depart)->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date d’arrivée</label>
            <input type="date" name="date_arrive" class="form-control"
                   value="{{ \Carbon\Carbon::parse($vol->date_arrive)->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prix ($)</label>
            <input type="number" step="0.01" name="prix" class="form-control" value="{{ $vol->prix }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Avion</label>
            <select name="avion_id" class="form-select" required>
                @foreach($avions as $avion)
                    <option value="{{ $avion->id }}" {{ $avion->id == $vol->avion_id ? 'selected' : '' }}>
                        {{ $avion->modele }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Photo actuelle</label>
            @if($vol->photo)
                <img src="{{ asset('storage/images/upload/'.$vol->photo) }}" alt="Photo du vol" class="img-thumbnail" width="250">
            @else
                <span class="text-muted">Aucune photo enregistrée</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Changer la photo</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif,.svg">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('vols.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
