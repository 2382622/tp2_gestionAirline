@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">@lang('general.modifier_vol') #{{ $vol->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vols.update', $vol->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">@lang('general.origine')</label>
            <input type="text" name="origine" class="form-control" value="{{ $vol->origine }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.destination')</label>
            <input type="text" name="destination" class="form-control" value="{{ $vol->destination }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.date_depart')</label>
            <input type="date" name="date_depart" class="form-control"
                   value="{{ \Carbon\Carbon::parse($vol->date_depart)->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.date_arrivee')</label>
            <input type="date" name="date_arrive" class="form-control"
                   value="{{ \Carbon\Carbon::parse($vol->date_arrive)->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.prix')</label>
            <input type="number" step="0.01" name="prix" class="form-control" value="{{ $vol->prix }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.avion')</label>
            <select name="avion_id" class="form-select" required>
                @foreach($avions as $avion)
                    <option value="{{ $avion->id }}" {{ $avion->id == $vol->avion_id ? 'selected' : '' }}>
                        {{ $avion->modele }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">@lang('general.photo_actuelle')</label>
            @if($vol->photo)
                <img src="{{ asset('storage/images/upload/'.$vol->photo) }}" 
                     alt="@lang('general.photo_actuelle')" 
                     class="img-thumbnail" width="250">
            @else
                <span class="text-muted">@lang('general.aucune_photo')</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">@lang('general.changer_photo')</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif,.svg">
        </div>

        <button type="submit" class="btn btn-success">@lang('general.enregistrer')</button>
        <a href="{{ route('vols.index') }}" class="btn btn-secondary">@lang('general.annuler')</a>
    </form>
</div>
@endsection
