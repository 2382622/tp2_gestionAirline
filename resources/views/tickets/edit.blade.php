@extends('layouts.app')

@section('content')
<style>
  body {
    background: radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    background-attachment: fixed;
    min-height: 100vh;
  }
  .page-wrap{display:flex;justify-content:center;align-items:flex-start;padding:4rem 1rem;}
  .card-ga{
    width:100%;max-width:600px;
    background:rgba(255,255,255,.92);backdrop-filter:blur(10px);
    border:1px solid rgba(15,23,42,.06);border-radius:1.25rem;
    box-shadow:0 10px 30px rgba(2,6,23,.08);
    padding:2rem 2.5rem;
  }
  .h-title{font-weight:800;text-align:center;margin-bottom:1rem;}
  .badge-soft{background:#eef2ff;color:#3730a3;border-radius:.75rem;padding:.35rem .7rem;font-weight:700;}
  .form-label{font-weight:600;color:#334155}
  .form-select,.form-control{border-radius:.75rem;transition:.2s}
  .form-select:focus,.form-control:focus{
    border-color:#6366f1!important;box-shadow:0 0 0 .25rem rgba(99,102,241,.25)!important}
  .btn-primary{background:#6366f1;border:none;border-radius:.75rem}
  .btn-primary:hover{background:#4f46e5}
  .btn-warning{border-radius:.75rem}
  .btn-secondary{border-radius:.75rem}
  .alert{border-radius:.75rem}
  .help{color:#64748b;font-size:.9rem}
</style>

<div class="page-wrap">
  <div class="card-ga">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h5 h-title mb-0">@lang('tickets.title_edit')</h1>
      <span class="badge-soft">#{{ $ticket->id }}</span>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
      @csrf @method('PUT')

      {{-- Vol --}}
      <div class="mb-4">
        <label class="form-label">@lang('tickets.flight')</label>
        <select name="vol_id" class="form-select" required>
          @foreach ($vols as $v)
            <option value="{{ $v->id }}" @selected(old('vol_id', $ticket->vol_id) == $v->id)>
              {{ trim($v->origine) }} → {{ trim($v->destination) }}
              — @lang('tickets.departure') : {{ \Carbon\Carbon::parse($v->date_depart)->translatedFormat('d/m/Y H:i') }}
              — @lang('tickets.flight_number') : {{ $v->numero_vol ?? 'V-' . str_pad($v->id, 3, '0', STR_PAD_LEFT) }}
            </option>
          @endforeach
        </select>
        <div class="help mt-1">@lang('tickets.flight_help')</div>
      </div>

      {{-- Quantité --}}
      <div class="mb-4">
        <label class="form-label">@lang('tickets.quantity')</label>
        <input type="number" name="quantite" min="1" class="form-control"
               value="{{ old('quantite', $ticket->quantite) }}" required>
        <div class="help mt-1">@lang('tickets.quantity_help')</div>
      </div>

      {{-- Utilisateur --}}
      @isset($users)
        <div class="mb-4">
          <label class="form-label">👤 @lang('tickets.user_optional')</label>
          <select name="user_id" class="form-select">
            <option value="">— @lang('tickets.none') —</option>
            @foreach ($users as $u)
              <option value="{{ $u->id }}" @selected(old('user_id', $ticket->user_id) == $u->id)>
                {{ $u->name }}
              </option>
            @endforeach
          </select>
          <div class="help mt-1">@lang('tickets.user_help')</div>
        </div>
      @endisset

      <div class="d-flex gap-2">
        <button class="btn btn-warning px-4">@lang('tickets.update')</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary px-4">@lang('tickets.cancel')</a>
      </div>
    </form>
  </div>
</div>
@endsection
