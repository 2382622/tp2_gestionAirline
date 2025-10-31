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
  .badge-soft{border-radius:.7rem; padding:.25rem .55rem; font-weight:600;}
  .badge-vol{ background:#eef2ff; color:#3730a3; }
  .badge-user{ background:#ecfeff; color:#155e75; }
  .badge-qty{ background:#fef9c3; color:#854d0e; }
  .btn-primary{ background:#6366f1; border:none; border-radius:.7rem }
  .btn-primary:hover{ background:#4f46e5 }
  .btn-outline-warning,.btn-outline-danger,.btn-outline-secondary{ border-radius:.6rem }
  .alert{ border-radius:.7rem }
  .toolbar{ gap:.75rem }
  .search-input{ border-radius:.7rem }
  .pagination{ justify-content: center; }
  .empty{ text-align:center; padding:3rem 1rem; color:#64748b; }
</style>

<div class="tickets-wrap">
  <div class="card-ga p-3 p-md-4">

    {{-- Messages flash --}}
    @if(session('success'))
      <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
      <div class="alert alert-warning mb-3">{{ session('warning') }}</div>
    @endif

    {{-- En-tête + outils --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 toolbar">
      <h1 class="h4 m-0 fw-bold">@lang('tickets.title_list')</h1>

      <div class="d-flex align-items-center toolbar">
        <input id="q" type="search" class="form-control search-input"
               placeholder="@lang('tickets.search_placeholder')"
               oninput="filterTable(this.value)">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary ms-md-2">
          @lang('tickets.new_ticket')
        </a>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center text-muted mb-2">
      <div>@lang('tickets.total') : <strong>{{ $tickets->total() }}</strong></div>
      {{-- place pour futurs filtres --}}
    </div>

    {{-- Tableau --}}
    <div class="table-responsive">
      <table class="table align-middle" id="ticketsTable">
        <thead>
          <tr>
            <th>@lang('tickets.columns.id')</th>
            <th>@lang('tickets.columns.flight')</th>
            <th>@lang('tickets.columns.user')</th>
            <th>@lang('tickets.columns.quantity')</th>
            <th>@lang('tickets.columns.created')</th>
            <th class="text-end">@lang('tickets.columns.actions')</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tickets as $t)
            <tr>
              <td class="text-nowrap">
                <span class="badge-soft badge-vol">#{{ $t->id }}</span>
              </td>

              <td>
                @if($t->vol)
                  <div class="fw-semibold">
                    {{ trim($t->vol->origine) }} → {{ trim($t->vol->destination) }}
                  </div>
                  <div class="small text-muted">
                    @lang('tickets.departure') :
                    {{ \Carbon\Carbon::parse($t->vol->date_depart)->translatedFormat('d/m/Y H:i') }}
                    <span class="ms-2 badge-soft badge-vol">
                      {{ $t->vol->numero_vol ?? ('V-' . str_pad($t->vol->id,3,'0',STR_PAD_LEFT)) }}
                    </span>
                  </div>
                @else
                  <em class="text-muted">@lang('tickets.flight_deleted')</em>
                @endif
              </td>

              <td class="text-nowrap">
                @if($t->user)
                  <span class="badge-soft badge-user">{{ $t->user->name }}</span>
                @else
                  —
                @endif
              </td>

              <td>
                <span class="badge-soft badge-qty">{{ $t->quantite }}</span>
              </td>

              <td class="text-nowrap">
                {{ optional($t->created_at)->translatedFormat('d/m/Y H:i') }}
              </td>

              <td class="text-end">
                <a href="{{ route('tickets.show', $t->id) }}" class="btn btn-sm btn-outline-secondary">
                  @lang('tickets.actions.view')
                </a>
                <a href="{{ route('tickets.edit', $t->id) }}" class="btn btn-sm btn-outline-warning">
                  @lang('tickets.actions.edit')
                </a>
                <form action="{{ route('tickets.destroy', $t->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('@lang('tickets.delete_confirm')');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">
                    @lang('tickets.actions.delete')
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="empty">
                @lang('tickets.empty')
                <div class="mt-2">
                  <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">
                    @lang('tickets.empty_cta')
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
      {{ $tickets->links() }}
    </div>
  </div>
</div>

<script>
  // Filtrage simple côté client (vol, user, id)
  function filterTable(query){
    const q = (query || '').toLowerCase();
    const rows = document.querySelectorAll('#ticketsTable tbody tr');
    rows.forEach(tr => {
      const txt = tr.innerText.toLowerCase();
      tr.style.display = txt.includes(q) ? '' : 'none';
    });
  }
</script>
@endsection
