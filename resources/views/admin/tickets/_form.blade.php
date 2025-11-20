@php
    // Variables attendues :
    // $ticket (optionnel), $vols (Collection), $users (Collection),
    // $route (string), $method ('POST'|'PUT')
@endphp

<form action="{{ $route }}" method="POST" class="card card-body">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    {{-- Vol --}}
    <div class="mb-3">
        <label for="vol_id" class="form-label">@lang('ticketAdmin.flight')</label>
        <select name="vol_id" id="vol_id"
                class="form-select @error('vol_id') is-invalid @enderror" required>
            <option value=""
                {{ old('vol_id', $ticket->vol_id ?? '') ? '' : 'selected' }} disabled>
                @lang('ticketAdmin.choose_flight_placeholder')
            </option>

            @foreach($vols as $v)
                <option value="{{ $v->id }}"
                    @selected(old('vol_id', $ticket->vol_id ?? '') == $v->id)>
                    [{{ $v->id }}] {{ trim($v->origine) }} → {{ trim($v->destination) }}
                    — {{ \Illuminate\Support\Carbon::parse($v->date_depart)->translatedFormat('Y-m-d H:i') }}
                </option>
            @endforeach
        </select>
        @error('vol_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">@lang('ticketAdmin.flight_help')</div>
    </div>

    {{-- Utilisateur --}}
    <div class="mb-3">
        <label for="user_id" class="form-label">@lang('ticketAdmin.user')</label>
        <select name="user_id" id="user_id"
                class="form-select @error('user_id') is-invalid @enderror" required>
            <option value=""
                {{ old('user_id', $ticket->user_id ?? '') ? '' : 'selected' }} disabled>
                @lang('ticketAdmin.choose_user_placeholder')
            </option>

            @foreach($users as $u)
                <option value="{{ $u->id }}"
                    @selected(old('user_id', $ticket->user_id ?? '') == $u->id)>
                    {{ $u->name }} ({{ $u->email }})
                </option>
            @endforeach
        </select>
        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">@lang('ticketAdmin.user_help')</div>
    </div>

    {{-- Quantité --}}
    <div class="mb-3">
        <label for="quantite" class="form-label">@lang('ticketAdmin.quantity')</label>
        <input type="number" min="1" name="quantite" id="quantite"
               class="form-control @error('quantite') is-invalid @enderror"
               value="{{ old('quantite', $ticket->quantite ?? 1) }}" required>
        @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">@lang('ticketAdmin.quantity_help')</div>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">
            {{ $method === 'PUT' ? __('ticketAdmin.update') : __('ticketAdmin.create') }}
        </button>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
            @lang('ticketAdmin.cancel')
        </a>
    </div>
</form>
