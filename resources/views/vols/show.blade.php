@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Détails du vol #{{ $vol->id }}</h1>

    <div class="row">
        <div class="col-md-5">
            {{-- Image du vol --}}
            @if($vol->photo)
                <img src="{{ asset('storage/images/upload/'.$vol->photo) }}"
                     alt="Photo du vol {{ $vol->id }}" class="img-fluid rounded border">
            @else
                <div class="border rounded d-flex align-items-center justify-content-center"
                     style="height:240px;background:#f7f7f7;">
                    <span class="text-muted">Aucune photo</span>
                </div>
            @endif
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <p><strong>Origine :</strong> {{ $vol->origine }}</p>
                    <p><strong>Destination :</strong> {{ $vol->destination }}</p>
                    <p><strong>Date de départ :</strong> {{ $vol->date_depart }}</p>
                    <p><strong>Date d’arrivée :</strong> {{ $vol->date_arrive }}</p>
                    <p><strong>Prix :</strong> {{ $vol->prix }} $</p>
                    <p><strong>Avion :</strong> {{ $vol->avion->modele ?? 'Non assigné' }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('vols.edit', $vol->id) }}" class="btn btn-warning">Modifier</a>

                <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Supprimer ce vol ?')">Supprimer</button>
                </form>

                <a href="{{ route('vols.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
