@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 fw-bold">@lang('ticketAdmin.title_create')</h1>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
            @lang('ticketAdmin.back')
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('admin.tickets._form', [
        'ticket' => null,
        'vols'   => $vols,
        'users'  => $users,
        'route'  => route('admin.tickets.store'),
        'method' => 'POST',
    ])
</div>
@endsection
