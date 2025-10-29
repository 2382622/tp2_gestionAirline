@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Tickets — Administration</h1>
    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">Nouveau ticket</a>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('warning')) <div class="alert alert-warning">{{ session('warning') }}</div> @endif
@if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Vol</th>
                <th>Client</th>
                <th>Quantité</th>
                <th>Créé</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tickets as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>
                    @if($t->vol)
                        <div class="small text-muted">ID: {{ $t->vol->id }}</div>
                        {{ $t->vol->origine }} → {{ $t->vol->destination }}
                        <div class="small text-muted">{{ \Illuminate\Support\Carbon::parse($t->vol->date_depart)->format('Y-m-d H:i') }}</div>
                    @else
                        <em class="text-muted">Vol supprimé</em>
                    @endif
                </td>
                <td>{{ $t->user?->name ?? '—' }}</td>
                <td>{{ $t->quantite }}</td>
                <td>{{ $t->created_at?->format('Y-m-d H:i') }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.tickets.show', $t) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                    <a href="{{ route('admin.tickets.edit', $t) }}" class="btn btn-sm btn-outline-primary">Éditer</a>
                    <form action="{{ route('admin.tickets.destroy', $t) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Supprimer ce ticket ?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">Aucun ticket</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $tickets->links() }}
</div>
@endsection
