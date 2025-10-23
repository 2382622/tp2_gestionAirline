@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">@lang('general.liste_vols')</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Bouton pour créer un nouveau vol --}}
    <div class="mb-3">
        <a href="{{ route('vols.create') }}" class="btn btn-primary">
            @lang('general.creer_vol')
        </a>
    </div>

    {{-- Tableau des vols --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>@lang('general.id')</th>
                <th>@lang('general.date_depart')</th>
                <th>@lang('general.date_arrivee')</th>
                <th>@lang('general.origine')</th>
                <th>@lang('general.destination')</th>
                <th>@lang('general.prix')</th>
                <th>@lang('general.avion')</th>
                <th>@lang('general.actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vols as $vol)
                <tr>
                    <td>{{ $vol->id }}</td>
                    <td>{{ $vol->date_depart }}</td>
                    <td>{{ $vol->date_arrive }}</td>
                    <td>{{ $vol->origine }}</td>
                    <td>{{ $vol->destination }}</td>
                    <td>{{ $vol->prix }} $</td>
                    <td>{{ $vol->avion->modele ?? __('general.non_assigne') }}</td>
                    <td>
                        <a href="{{ route('vols.show', $vol->id) }}" class="btn btn-info btn-sm">
                            @lang('general.voir')
                        </a>
                        <a href="{{ route('vols.edit', $vol->id) }}" class="btn btn-warning btn-sm">
                            @lang('general.modifier')
                        </a>
                        <form action="{{ route('vols.destroy', $vol->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('@lang('general.confirmer_suppression')')">
                                @lang('general.supprimer')
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">@lang('general.aucun_vol_trouve')</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $vols->links() }}
    </div>
</div>
@endsection
