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

  .ticket-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 4rem 1rem;
  }

  .ticket-card {
    max-width: 520px;
    width: 100%;
    background: rgba(255,255,255,0.9);
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(2,6,23,.08);
    backdrop-filter: blur(10px);
    padding: 2rem 2.5rem;
    border: 1px solid rgba(15,23,42,0.06);
  }

  .ticket-card h1 {
    font-weight: 700;
    font-size: 1.75rem;
    text-align: center;
    margin-bottom: 1.25rem;
  }

  .ticket-card .form-label {
    font-weight: 600;
    color: #334155;
  }

  .ticket-card .form-select,
  .ticket-card .form-control {
    border-radius: 0.75rem;
    transition: all 0.2s ease;
  }

  .ticket-card .form-select:focus,
  .ticket-card .form-control:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 .25rem rgba(99,102,241,.25) !important;
  }

  .btn-primary {
    background-color: #6366f1;
    border: none;
    border-radius: 0.75rem;
    transition: all 0.2s ease-in-out;
  }

  .btn-primary:hover {
    background-color: #4f46e5;
    transform: translateY(-1px);
  }

  .btn-secondary {
    border-radius: 0.75rem;
  }

  .alert-danger {
    border-radius: 0.75rem;
  }
</style>

<div class="ticket-container">
  <div class="ticket-card">
    <h1>@lang('tickets.title_new')</h1>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST" novalidate>
      @csrf

      {{-- Sélection du vol --}}
      <div class="mb-4">
        <label class="form-label" for="vol_id">@lang('tickets.select_flight')</label>
        <select id="vol_id" name="vol_id" class="form-select @error('vol_id') is-invalid @enderror" required>
          <option value="">{{ __('tickets.select_placeholder') }}</option>
          @foreach($vols as $v)
            <option value="{{ $v->id }}" @selected(old('vol_id') == $v->id)>
              {{ $v->origine }} → {{ $v->destination }}
              — @lang('tickets.departure') : {{ \Carbon\Carbon::parse($v->date_depart)->translatedFormat('d/m/Y H:i') }}
              — @lang('tickets.flight_number') : {{ $v->numero_vol ?? 'V-' . str_pad($v->id, 3, '0', STR_PAD_LEFT) }}
            </option>
          @endforeach
        </select>
        @error('vol_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Quantité --}}
      <div class="mb-4">
        <label class="form-label" for="quantite">@lang('tickets.quantity')</label>
        <input id="quantite" type="number" name="quantite"
               class="form-control @error('quantite') is-invalid @enderror"
               min="1" value="{{ old('quantite', 1) }}" required>
        @error('quantite')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Actions --}}
      <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary flex-fill py-2 fw-semibold">
          @lang('tickets.create')
        </button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary flex-fill py-2">
          @lang('tickets.cancel')
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
