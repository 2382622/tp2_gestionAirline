@extends('layouts.app')

@section('content')
<style>
  body{
    background:
      radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
      radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
      linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    background-attachment: fixed;
    min-height: 100vh;
  }
  .page-wrap{padding:3rem 1rem; display:flex; justify-content:center;}
  .card-ga{
    width:100%; max-width:1000px;
    background:rgba(255,255,255,.92); backdrop-filter:blur(10px);
    border:1px solid rgba(15,23,42,.06); border-radius:1.25rem;
    box-shadow:0 10px 30px rgba(2,6,23,.08);
  }
  .badge-soft{border-radius:.7rem; padding:.32rem .6rem; font-weight:700;}
  .badge-id{ background:#eef2ff; color:#3730a3 }
  .badge-qty{ background:#fef9c3; color:#854d0e }
  .meta{ color:#64748b }
  .dl dt{ color:#334155; font-weight:600 }
  .dl dd{ margin-bottom: .75rem }
  .img-vol{
    max-height: 220px; border-radius:.75rem; object-fit:cover;
    border:1px solid rgba(15,23,42,.06); box-shadow:0 6px 18px rgba(2,6,23,.06);
  }
  .btn-warning,.btn-danger,.btn-secondary{ border-radius:.7rem }
  .btn-primary{ background:#6366f1; border:none; border-radius:.7rem }
  .btn-primary:hover{ background:#4f46e5 }
</style>

<div class="page-wrap">
  <div class="card-ga p-3 p-md-4">

    {{-- Flash messages --}}
    @if(session('success')) <div class="alert alert-success mb-3">{{ session('success') }}</div> @endif
    @if(session('warning')) <div class="alert alert-warning mb-3">{{ session('warning') }}</div> @endif

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
      <h1 class="h4 m-0 fw-bold">Ticket</h1>
      <span class="badge-soft badge-id">#{{ $ticket->id }}</span>
    </div>

    {{-- Content --}}
    <div class="row g-4">
      {{-- Col gauche : détails texte --}}
      <div class="col-12 col-lg-7">
        <div class="dl">
          {{-- Vol --}}
          <div class="mb-3">
            <dt>Vol</dt>
            <dd class="mb-2">
              @if($ticket->vol)
                <div class="fw-semibold">
                  {{ trim($ticket->vol->origine) }} → {{ trim($ticket->vol->destination) }}
                  <span class="badge-soft badge-id ms-2">
                    {{ $ticket->vol->numero_vol ?? ('V-' . str_pad($ticket->vol->id,3,'0',STR_PAD_LEFT)) }}
                  </span>
                </div>
                <div class="meta small">
                  Départ : {{ \Carbon\Carbon::parse($ticket->vol->date_depart)->format('d/m/Y H:i') }}<br>
                  Arrivée : {{ \Carbon\Carbon::parse($ticket->vol->date_arrive)->format('d/m/Y H:i') }}
                </div>
              @else
                <em class="text-muted">Vol supprimé</em>
              @endif
            </dd>
          </div>

          {{-- Utilisateur --}}
          <div class="mb-3">
            <dt>Utilisateur</dt>
            <dd>{{ optional($ticket->user)->name ?? '—' }}</dd>
          </div>

          {{-- Quantité --}}
          <div class="mb-3">
            <dt>Quantité</dt>
            <dd><span class="badge-soft badge-qty">{{ $ticket->quantite }}</span></dd>
          </div>

          {{-- Dates système --}}
          <div class="mb-3">
            <dt>Créé</dt>
            <dd>{{ optional($ticket->created_at)->format('d/m/Y H:i') }}</dd>
            <dt>Mis à jour</dt>
            <dd>{{ optional($ticket->updated_at)->format('d/m/Y H:i') }}</dd>
          </div>
        </div>
      </div>

      {{-- Col droite : visuel du vol (si dispo) --}}
      <div class="col-12 col-lg-5">
        @if($ticket->vol && $ticket->vol->photo)
          <img
            src="{{ asset('storage/images/upload/'.$ticket->vol->photo) }}"
            alt="Photo vol {{ $ticket->vol->id }}"
            class="img-fluid img-vol w-100">
        @else
          <div class="border rounded-3 p-4 h-100 d-flex align-items-center justify-content-center text-muted">
            Aucune photo disponible
          </div>
        @endif
      </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex flex-wrap gap-2 mt-4">
      <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Éditer</a>
      <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
            onsubmit="return confirm('Supprimer ce ticket ?');">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Supprimer</button>
      </form>
      <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Retour</a>
    </div>
  </div>
</div>
@endsection
