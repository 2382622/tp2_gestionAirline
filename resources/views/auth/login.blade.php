@extends('layouts.app')

@section('content')
<style>
    /* ======== Fond global ======== */
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        /* empêche le défilement */
        background: radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
            radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
            linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    /* ======== Centrage ======== */
    .ga-bg {
        height: 100vh;
        /* pleine hauteur */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ======== Carte ======== */
    .ga-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.06);
        border-radius: 1.5rem;
        /* coins arrondis */
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
    }

    /* ======== Champs ======== */
    .ga-form-control {
        border-radius: 0.75rem;
        /* plus arrondi */
    }

    .ga-form-control:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .25) !important;
    }

    /* ======== Bouton ======== */
    .ga-btn {
        background: #6366f1;
        border: none;
        border-radius: 0.75rem;
        /* arrondi aussi */
        transition: all 0.2s ease-in-out;
    }

    .ga-btn:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }

    /* ======== Texte secondaire ======== */
    .ga-muted {
        color: #64748b;
    }
</style>


<div class="ga-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-9 col-md-7 col-lg-5">
                <div class="ga-card p-4 p-sm-5">
                    <div class="text-center mb-4">

                        <h1 class="h3 fw-bold mt-3 mb-1">@lang('login.login') </h1>
                    </div>

                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('login.email_addr')</label>
                            <input id="email" type="email"
                                class="form-control ga-form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="ex: jean.dupont@email.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password + lien oublié --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label mb-0">@lang('login.password')</label>
                                @if (Route::has('password.request'))
                                <a class="link-primary small" href="{{ route('password.request') }}">
                                    @lang('login.forgot_password')
                                </a>
                                @endif
                            </div>
                            <input id="password" type="password"
                                class="form-control ga-form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">@lang('login.remember_me')</label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn ga-btn w-100 py-2 text-white fw-semibold">
                            @lang('login.log_in')
                        </button>
                    </form>

                    {{-- Footer --}}
                    <div class="text-center ga-muted small mt-4">
                        © {{ date('Y') }} — @lang('general.rights')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection