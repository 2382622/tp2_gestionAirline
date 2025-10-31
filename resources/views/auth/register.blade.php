@extends('layouts.app')

@section('content')
<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }

  /* Arrière-plan plein écran */
  body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;
    z-index: -1;
  }

  /* Conteneur central */
  .auth-section {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 56px); /* ajuste selon ta navbar */
    padding: 0;
  }

  /* Carte */
  .ga-card {
    width: 100%;
    max-width: 460px;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.92);
    border: 1px solid rgba(15,23,42,0.06);
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(2,6,23,.08);
    padding: 2.5rem;
  }

  /* Champs arrondis uniquement dans la carte */
  .ga-card .form-control {
    border-radius: 0.75rem;
  }

  .ga-card .form-control:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 .25rem rgba(99,102,241,.25) !important;
  }

  /* Bouton principal */
  .ga-btn {
    background: #6366f1;
    border: none;
    border-radius: 0.75rem;
    transition: all .2s ease-in-out;
  }
  .ga-btn:hover { background:#4f46e5; transform: translateY(-1px); }

  .ga-muted { color:#64748b; }
</style>

<div class="auth-section">
  <div class="ga-card">
    <div class="text-center mb-4">
      <h1 class="h3 fw-bold mt-2 mb-1">Créer un compte</h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input id="name" type="text"
               class="form-control @error('name') is-invalid @enderror"
               name="name" value="{{ old('name') }}" required placeholder="ex: Tremblay">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input id="prenom" type="text"
               class="form-control @error('prenom') is-invalid @enderror"
               name="prenom" value="{{ old('prenom') }}" required placeholder="ex: Marie">
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Adresse courriel</label>
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required placeholder="ex: marie.tremblay@email.com">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required placeholder="••••••••">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-4">
        <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
        <input id="password-confirm" type="password"
               class="form-control"
               name="password_confirmation" required placeholder="••••••••">
      </div>

      <button type="submit" class="btn ga-btn w-100 py-2 text-white fw-semibold">
        Créer mon compte
      </button>
    </form>

    <div class="text-center ga-muted small mt-4">
      Vous avez déjà un compte ?
      <a href="{{ route('login') }}" class="link-primary text-decoration-none">Se connecter</a>
    </div>

    <div class="text-center ga-muted small mt-2">
      © {{ date('Y') }} — Gestion Airline. Tous droits réservés.
    </div>
  </div>
</div>
@endsection
