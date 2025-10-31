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
        background:
            radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
            radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
            linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
        z-index: -1;
    }

    .email-section {
        min-height: calc(100vh - 56px);
        /* hauteur navbar Bootstrap */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ga-card {
        width: 100%;
        max-width: 520px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, .92);
        border: 1px solid rgba(15, 23, 42, .06);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(2, 6, 23, .08);
        padding: 2.5rem;
    }

    .ga-card .form-control {
        border-radius: .75rem;
    }

    .ga-card .form-control:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .25) !important;
    }

    .ga-btn {
        background: #6366f1;
        border: none;
        color: #fff;
        border-radius: .75rem;
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
        border-radius: .75rem;
    }
</style>

<div class="email-section">
    <div class="ga-card">
        <div class="text-center mb-4">
            <h1 class="h4 fw-bold mb-1">{{ __('Reset Password') }}</h1>
            <div class="ga-muted small">
                {{ __('Enter your email to receive a password reset link.') }}
            </div>
        </div>

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    placeholder="ex: jean.dupont@email.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn ga-btn w-100 py-2 fw-semibold">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>

        <div class="text-center ga-muted small mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none link-primary">
                {{ __('Back to login') }}
            </a>
        </div>

        <div class="text-center ga-muted small mt-2">
            © {{ date('Y') }} — Gestion Airline. Tous droits réservés.
        </div>
    </div>
</div>
@endsection