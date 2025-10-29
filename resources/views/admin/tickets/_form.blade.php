@php
    // $ticket (optionnel), $vols (collection), $users (collection), $route (string), $method (string: 'POST' ou 'PUT')
@endphp

<form action="{{ $route }}" method="POST" class="card card-body">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="mb-3">
        <label for="vol_id" class="form-label">Vol</label>
        <select name="vol_id" id="vol_id" class="form-select" required>
            <option value="" disabled {{ old('vol_id', $ticket->vol_id ?? '') ? '' : 'selected' }}>— Choisir un vol —</option>
            @foreach($vols as $v)
                <option value="{{ $v->id }}" @selected(old('vol_id', $ticket->vol_id ?? '') == $v->id)>
                    [{{ $v->id }}] {{ $v->origine }} → {{ $v->destination }} — {{ \Illuminate\Support\Carbon::parse($v->date_depart)->format('Y-m-d H:i') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="user_id" class="form-label">Utilisateur</label>
        <select name="user_id" id="user_id" class="form-select" required>
            <option value="" disabled {{ old('user_id', $ticket->user_id ?? '') ? '' : 'selected' }}>— Choisir un utilisateur —</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" @selected(old('user_id', $ticket->user_id ?? '') == $u->id)>
                    {{ $u->name }} ({{ $u->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quantite" class="form-label">Quantité</label>
        <input type="number" min="1" name="quantite" id="quantite" class="form-control"
               value="{{ old('quantite', $ticket->quantite ?? 1) }}" required>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">
            {{ $method === 'PUT' ? 'Mettre à jour' : 'Créer' }}
        </button>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>
</form>
