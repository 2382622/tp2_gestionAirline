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
  .tickets-wrap{padding:3rem 1rem; display:flex; justify-content:center;}
  .card-ga{
    width:100%; max-width:1100px;
    background:rgba(255,255,255,.92); backdrop-filter:blur(10px);
    border:1px solid rgba(15,23,42,.06); border-radius:1.25rem;
    box-shadow:0 10px 30px rgba(2,6,23,.08);
  }
  .table thead th{ color:#475569; font-weight:700; border-bottom:1px solid #e5e7eb; }
  .table td{ vertical-align: middle; }
  .btn-primary{ background:#6366f1; border:none; border-radius:.7rem }
  .btn-primary:hover{ background:#4f46e5 }
  .btn-outline-warning,.btn-outline-danger,.btn-outline-secondary,.btn-outline-primary{ border-radius:.6rem }
  .alert{ border-radius:.7rem }
  .toolbar{ gap:.75rem }
  .search-input{ border-radius:.7rem }
  .pagination{ justify-content: center; }
  .empty{ text-align:center; padding:3rem 1rem; color:#64748b; }
</style>

<div class="tickets-wrap">
  <div class="card-ga p-3 p-md-4">

    {{-- En-tête --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 toolbar">
      <h1 class="h3 mb-0 fw-bold">Tickets — Administration</h1>
      <div class="d-flex align-items-center toolbar">
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">Nouveau ticket</a>
      </div>
    </div>

    {{-- Messages flash --}}
    @if(session('success')) <div class="alert alert-success mb-3">{{ session('success') }}</div> @endif
    @if(session('warning')) <div class="alert alert-warning mb-3">{{ session('warning') }}</div> @endif

    {{-- Erreurs --}}
    @if($errors->any())
      <div class="alert alert-danger mb-3">
        <ul class="mb-0">
          @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
      </div>
    @endif

    {{-- Tableau --}}
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Vol</th>
            <th>Client</th>
            <th>Quantité</th>
            <th>Créé</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tickets as $t)
            <tr>
              <td>{{ $t->id }}</td>

              <td>
                @if($t->vol)
                  <div class="small text-muted">ID: {{ $t->vol->id }}</div>
                  {{ $t->vol->origine }} → {{ $t->vol->destination }}
                  <div class="small text-muted">
                    {{ \Illuminate\Support\Carbon::parse($t->vol->date_depart)->format('Y-m-d H:i') }}
                  </div>
                @else
                  <em class="text-muted">Vol supprimé</em>
                @endif
              </td>

              <td>{{ optional($t->user)->name ?? '—' }}</td>
              <td>{{ $t->quantite }}</td>
              <td>{{ optional($t->created_at)->format('Y-m-d H:i') }}</td>

              <td class="text-end">
                <a href="{{ route('admin.tickets.show',  $t->id) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                <a href="{{ route('admin.tickets.edit',  $t->id) }}" class="btn btn-sm btn-outline-primary">Éditer</a>
                <form action="{{ route('admin.tickets.destroy', $t->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Supprimer ce ticket ?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="empty">
                Aucun ticket.
                <div class="mt-2">
                  <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary btn-sm">Créer un ticket</a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
      {{ $tickets->links() }}
    </div>
  </div>
</div>
@endsection
