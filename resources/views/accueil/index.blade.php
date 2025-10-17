@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Vols en lien avec Montréal </h2>

    <div class="row">
        @forelse ($vols as $vol)
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $vol->origine }} → {{ $vol->destination }}
                        </h5>
                        <p><strong>Date départ :</strong> {{ $vol->date_depart }}</p>
                        <p><strong>Date arrivée :</strong> {{ $vol->date_arrive }}</p>
                        <p><strong>Prix :</strong> {{ $vol->prix }} $</p>
                        
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">Aucun vol trouvé pour Montréal.</p>
        @endforelse
    </div>
</div>
@endsection
