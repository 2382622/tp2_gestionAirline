@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des vols</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tableau des vols --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date départ</th>
                <th>Date arrivée</th>
                <th>Origine</th>
                <th>Destination</th>
                <th>Prix</th>
                <th>Avion</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vols as $vol)
                <tr>
                    <td>{{ $vol->id }}</td>
                    <td>{{ $vol->date_depart }}</td>
                    <td>{{ $vol->date_arrive }}</td>
                    <td>{{ $vol->origine }}</td>
                    <td>{{ $vol->destination }}</td>
                    <td>{{ $vol->prix }} $</td>
                    <td>{{ $vol->avion->modele ?? 'Non assigné' }}</td>
                    <td>
                        <a href="{{ route('vols.show', $vol->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('vols.edit', $vol->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Aucun vol trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="d-flex justify-content-center">
        {{ $vols->links() }}
    </div>
</div>
@endsection
