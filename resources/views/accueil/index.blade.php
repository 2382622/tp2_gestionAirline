@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">@lang('general.titre_accueil')</h2>

    <div class="row">
        @forelse ($vols as $vol)
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $vol->origine }} → {{ $vol->destination }}
                        </h5>
                        <p><strong>@lang('general.date_depart') :</strong> {{ $vol->date_depart }}</p>
                        <p><strong>@lang('general.date_arrivee') :</strong> {{ $vol->date_arrive }}</p>
                        <p><strong>@lang('general.prix') :</strong> {{ $vol->prix }} $</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">@lang('general.aucun_vol')</p>
        @endforelse
    </div>
</div>
@endsection
