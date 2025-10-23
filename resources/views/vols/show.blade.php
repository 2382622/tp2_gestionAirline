@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">@lang('general.details_vol') #{{ $vol->id }}</h1>

    <div class="row">
        <div class="col-md-5">
            {{-- Image du vol --}}
            @if($vol->photo)
                <img src="{{ asset('storage/images/upload/'.$vol->photo) }}"
                     alt="@lang('general.photo_vol') {{ $vol->id }}"
                     class="img-fluid rounded border">
            @else
                <div class="border rounded d-flex align-items-center justify-content-center"
                     style="height:240px;background:#f7f7f7;">
                    <span class="text-muted">@lang('general.aucune_photo')</span>
                </div>
            @endif
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <p><strong>@lang('general.origine') :</strong> {{ $vol->origine }}</p>
                    <p><strong>@lang('general.destination') :</strong> {{ $vol->destination }}</p>
                    <p><strong>@lang('general.date_depart') :</strong> {{ $vol->date_depart }}</p>
                    <p><strong>@lang('general.date_arrivee') :</strong> {{ $vol->date_arrive }}</p>
                    <p><strong>@lang('general.prix') :</strong> {{ $vol->prix }} $</p>
                    <p><strong>@lang('general.avion') :</strong> {{ $vol->avion->modele ?? __('general.non_assigne') }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('vols.edit', $vol->id) }}" class="btn btn-warning">@lang('general.modifier')</a>

                <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('@lang('general.confirmer_suppression')')">
                        @lang('general.supprimer')
                    </button>
                </form>

                <a href="{{ route('vols.index') }}" class="btn btn-secondary">@lang('general.retour_liste')</a>
            </div>
        </div>
    </div>
</div>
@endsection
