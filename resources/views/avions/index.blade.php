@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des avions</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Modèle</th>
                <th>Capacité</th>
            </tr>
        </thead>
        <tbody>
            @foreach($avions as $avion)
                <tr>
                    <td>{{ $avion->id }}</td>
                    <td>{{ $avion->modele }}</td>
                    <td>{{ $avion->capacite }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
