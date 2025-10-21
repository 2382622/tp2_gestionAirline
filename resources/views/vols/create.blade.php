@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Créer un vol</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vols.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="id" class="form-label">ID du vol</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>

            <div class="mb-3">
                <label for="origine" class="form-label">Origine</label>
                <input type="text" class="form-control" id="origine" name="origine" required>
            </div>

            <div class="mb-3">
                <label for="destination" class="form-label">Destination</label>
                <input type="text" class="form-control" id="destination" name="destination" required>
            </div>

            <div class="mb-3">
                <label for="date_depart" class="form-label">Date de départ</label>
                <input type="date" class="form-control" id="date_depart" name="date_depart" required>
            </div>

            <div class="mb-3">
                <label for="date_arrive" class="form-label">Date d’arrivée</label>
                <input type="date" class="form-control" id="date_arrive" name="date_arrive" required>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix ($)</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
            </div>

            <div class="mb-3">
                <label for="avion_id" class="form-label">Avion</label>
                <select name="avion_id" id="avion_id" class="form-select" required>
                    <option value="">-- Choisir un avion --</option>
                    @foreach($avions as $avion)
                        <option value="{{ $avion->id }}">{{ $avion->modele }}</option>
                    @endforeach
                </select>
            </div>

             <div class="mb-3">
            <label class="form-label">Photo du vol</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif,.svg" required>
            <small class="text-muted">Formats autorisés : JPG, PNG, GIF, SVG</small>
        </div>

            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="{{ route('vols.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection