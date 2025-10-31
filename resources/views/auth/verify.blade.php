@extends('layouts.app')

@section('content')
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
            radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
            linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
        z-index: -1;
    }

    .verify-section {
        min-height: calc(100vh - 56px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ga-card {
        width: 100%;
        max-width: 520px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.06);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(2, 6, 23, .08);
        padding: 2.5rem;
        text-align: center;
    }

    .ga-btn {
        background: #6366f1;
        border: none;
        border-radius: 0.75rem;
        color: white;
        padding: 0.5rem 1.25rem;
        transition: all .2s ease-in-out;
    }

    .ga-btn:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }

    .ga-muted {
        color: #64748b;
    }

    .alert {
        border-radius: 0.75rem;
    }
</style>

<div class="verify-section">
    <div class="ga-card">
        <h1 class="h4 fw-bold mb-3">Vérifiez votre adresse courriel</h1>

        @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Un nouveau lien de vérification a été envoyé à votre adresse courriel.
        </div>
        @endif

        <p class="ga-muted mb-3">
            Avant de continuer, veuillez consulter vos courriels pour trouver le lien de vérification.
        </p>

        <p class="ga-muted mb-4">
            Si vous n’avez pas reçu de courriel, vous pouvez en demander un autre ci-dessous.
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="ga-btn fw-semibold">Renvoyer le lien de vérification</button>
        </form>

        <div class="text-center ga-muted small mt-4">
            Besoin d’aide ? <a href="{{ route('login') }}" class="text-decoration-none link-primary">Retour à la connexion</a>
        </div>

        <div class="text-center ga-muted small mt-3">
            © {{ date('Y') }} — Gestion Airline. Tous droits réservés.
        </div>
    </div>
</div>
@endsection