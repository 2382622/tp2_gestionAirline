@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Tickets</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Nouveau ticket</a>
        <div class="text-muted">Total: {{ $tickets->total() }}</div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vol</th>
                    <th>Utilisateur</th>
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
                            <div class="fw-semibold">
                                {{ $t->vol->id }} — {{ $t->vol->origine }} → {{ $t->vol->destination }}
                            </div>
                            <small class="text-muted">
                                Départ: {{ \Carbon\Carbon::parse($t->vol->date_depart)->format('Y-m-d H:i') }}
                            </small>
                        @else
                            <em class="text-muted">Vol supprimé</em>
                        @endif
                    </td>
                    <td>{{ optional($t->user)->name ?? '—' }}</td>
                    <td>{{ $t->quantite }}</td>

                    {{-- Correction ici --}}
                    <td>{{ optional($t->created_at)->format('Y-m-d H:i') }}</td>

                    <td class="text-end">
                        <a href="{{ route('tickets.show', $t->id) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                        <a href="{{ route('tickets.edit', $t->id) }}" class="btn btn-sm btn-outline-warning">Éditer</a>
                        <form action="{{ route('tickets.destroy', $t->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer ce ticket ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucun ticket</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $tickets->links() }}
</div>
@endsection
