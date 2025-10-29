@extends('layouts.app')

@section('content')
<h1 class="h3 mb-3">Modifier le ticket #{{ $ticket->id }} (Admin)</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

@include('admin.tickets._form', [
    'ticket' => $ticket,
    'vols'   => $vols,
    'users'  => $users,
    'route'  => route('admin.tickets.update', $ticket),
    'method' => 'PUT',
])
@endsection
