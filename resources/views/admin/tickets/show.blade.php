@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 fw-bold">
            {{ __('ticketAdmin.title_show', ['id' => $ticket->id]) }}
        </h1>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
            @lang('ticketAdmin.back')
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">@lang('ticketAdmin.columns.id')</dt>
                <dd class="col-sm-9">{{ $ticket->id }}</dd>

                <dt class="col-sm-3">@lang('ticketAdmin.columns.user')</dt>
                <dd class="col-sm-9">
                    {{ $ticket->user?->name ?? '—' }}
                    @if($ticket->user)
                        <small class="text-muted">({{ $ticket->user->email }})</small>
                    @endif
                </dd>

                <dt class="col-sm-3">@lang('ticketAdmin.columns.flight')</dt>
                <dd class="col-sm-9">
                    @if($ticket->vol)
                        <div class="small text-muted">ID: {{ $ticket->vol->id }}</div>
                        {{ trim($ticket->vol->origine) }} → {{ trim($ticket->vol->destination) }}
                        <div class="small text-muted">
                            {{ \Illuminate\Support\Carbon::parse($ticket->vol->date_depart)->translatedFormat('Y-m-d H:i') }}
                        </div>
                    @else
                        <em class="text-muted">@lang('ticketAdmin.flight_deleted')</em>
                    @endif
                </dd>

                <dt class="col-sm-3">@lang('ticketAdmin.columns.quantity')</dt>
                <dd class="col-sm-9">{{ $ticket->quantite }}</dd>

                <dt class="col-sm-3">@lang('ticketAdmin.columns.created')</dt>
                <dd class="col-sm-9">{{ optional($ticket->created_at)->translatedFormat('Y-m-d H:i') }}</dd>

                <dt class="col-sm-3">@lang('ticketAdmin.columns.updated')</dt>
                <dd class="col-sm-9">{{ optional($ticket->updated_at)->translatedFormat('Y-m-d H:i') }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-primary">
            @lang('ticketAdmin.actions.edit')
        </a>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
            @lang('ticketAdmin.back')
        </a>
    </div>
</div>
@endsection
