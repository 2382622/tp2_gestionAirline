@extends('layouts.app')

@section('content')
<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }

  body::before {
    content: "";
    position: fixed;
    inset: 0;
    background:
      radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
      radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
      linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;
    z-index: -1;
  }

  .confirm-section {
    min-height: calc(100vh - 56px); /* hauteur de la navbar Bootstrap */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ga-card {
    width: 100%;
    max-width: 480px;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.9);
    border: 1px solid rgba(15,23,42,0.06);
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(2,6,23,.08);
    padding: 2.5rem;
  }

  .ga-card .form-control {
    border-radius: 0.75rem;
  }

  .ga-card .form-control:focus {
    border-color: #6366f1 !important;
    box-shadow: 0 0 0 .25rem rgba(99,102,241,.25) !important;
  }

  .ga-btn {
    background: #6366f1;
    border: none;
    border-radius: 0.75rem;
    color: white;
    transition: all 0.2s ease-in-out;
  }

  .ga-btn:hover {
    background: #4f46e5;
    transform: translateY(-1px);
  }

  .ga-muted {
    color: #64748b;
  }
</style>

<div class="confirm-section">
  <div class="ga-card">
    <div class="text-center mb-4">
      <h1 class="h4 fw-bold mb-1">{{ __('Confirmez votre mot de passe') }}</h1>
      <div class="ga-muted small">{{ __('Veuillez confirmer votre mot de passe avant de continuer.') }}</div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf

      {{-- Champ mot de passe --}}
      <div class="mb-4">
        <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
        <div class="input-group">
          <input id="password" type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 name="password" required autocomplete="current-password"
                 placeholder="••••••••">
          <span class="input-group-text toggle-eye" onclick="togglePw('password', this)">👁️</span>
          @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Boutons --}}
      <button type="submit" class="btn ga-btn w-100 py-2 fw-semibold">
        {{ __('Confirmer le mot de passe') }}
      </button>

      @if (Route::has('password.request'))
        <div class="text-center mt-3">
          <a href="{{ route('password.request') }}" class="link-primary text-decoration-none small">
            {{ __('Mot de passe oublié ?') }}
          </a>
        </div>
      @endif
    </form>

    <div class="text-center ga-muted small mt-4">
      <a href="{{ route('login') }}" class="text-decoration-none link-primary">
        {{ __('Retour à la connexion') }}
      </a>
    </div>

    <div class="text-center ga-muted small mt-2">
      © {{ date('Y') }} — Gestion Airline. Tous droits réservés.
    </div>
  </div>
</div>

<script>
  // Afficher / masquer le mot de passe
  function togglePw(id, el) {
    const input = document.getElementById(id);
    if (!input) return;
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
    el.textContent = type === 'password' ? '👁️' : '🙈';
  }
</script>
@endsection
