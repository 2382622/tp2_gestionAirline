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
      <h1 class="h4 m-0 fw-bold">@lang('tickets.title_show')</h1>
      <span class="badge-soft badge-id">#{{ $ticket->id }}</span>
    </div>

    {{-- Content --}}
    <div class="row g-4">
      {{-- Col gauche : détails texte --}}
      <div class="col-12 col-lg-7">
        <div class="dl">
          {{-- Vol --}}
          <div class="mb-3">
            <dt>@lang('tickets.flight')</dt>
            <dd class="mb-2">
              @if($ticket->vol)
                <div class="fw-semibold">
                  {{ trim($ticket->vol->origine) }} → {{ trim($ticket->vol->destination) }}
                  <span class="badge-soft badge-id ms-2">
                    {{ $ticket->vol->numero_vol ?? ('V-' . str_pad($ticket->vol->id,3,'0',STR_PAD_LEFT)) }}
                  </span>
                </div>
                <div class="meta small">
                  @lang('tickets.departure') : {{ \Carbon\Carbon::parse($ticket->vol->date_depart)->translatedFormat('d/m/Y H:i') }}<br>
                  @lang('tickets.arrival') : {{ \Carbon\Carbon::parse($ticket->vol->date_arrive)->translatedFormat('d/m/Y H:i') }}
                </div>
              @else
                <em class="text-muted">@lang('tickets.flight_deleted')</em>
              @endif
            </dd>
          </div>

          {{-- Utilisateur --}}
          <div class="mb
