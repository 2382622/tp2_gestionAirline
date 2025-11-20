<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion Airline</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            display: flex;
            flex-direction: column;
        }

        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
            font-weight: 600;
        }

        .navbar-brand {
            color: #4f46e5 !important;
            font-weight: 700;
            transition: color .2s;
        }

        .navbar-brand:hover {
            color: #6366f1 !important;
        }

        .nav-link {
            color: #334155 !important;
            transition: color .2s;
        }

        .nav-link:hover {
            color: #6366f1 !important;
        }

        /* Drapeaux */
        .flag {
            width: 22px;
            height: 22px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, .08);
        }

        .flag-sm {
            width: 18px;
            height: 18px;
        }

        .flag-inline {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        /* Bouton langue */
        .btn-lang {
            border-color: #cbd5e1;
            color: #334155;
            background: #fff;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .btn-lang:hover {
            background: #6366f1;
            color: #fff;
        }

        .dropdown-item .flag {
            margin-right: .5rem;
        }

        footer {
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            font-size: .95rem;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, .05);
            width: 100%;
        }

        footer a {
            color: #c7d2fe;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .footer-flags a {
            display: inline-flex;
            align-items: center;
            margin: 0 .35rem;
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- Détermine le drapeau courant --}}
        @php
            $flagMap = ['fr' => 'drapeau_fr', 'en' => 'drapeau_en', 'es' => 'drapeau_es'];
            $locale = app()->getLocale();
            $flagCurrent = $flagMap[$locale] ?? 'drapeau_en';
            $ext = 'png'; // <-- change en 'svg' si tes fichiers sont en .svg
        @endphp

        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('accueil') }}">@lang('general.accueil')</a>
                <a class="navbar-brand" href="{{ route('vols.index') }}">@lang('general.vols')</a>

                @auth
                    <a class="navbar-brand" href="{{ route('tickets.index') }}">@lang('general.tickets')</a>
                @endauth
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="navbar-brand" href="{{ route('avions.index') }}">@lang('general.avions')</a>
                        <a class="navbar-brand" href="{{ route('admin.tickets.index') }}">@lang('general.tickets_admin')</a>
                    @endif
                @endauth

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-center">

                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        @lang('general.deconnexion')
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                                    </form>
                                </div>
                            </li>
                        @endauth

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">@lang('general.connexion')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('general.inscription')</a>
                            </li>
                        @endguest

                        {{-- Sélecteur de langue en drapeaux --}}
                        <li class="nav-item dropdown ms-2">
                            <button class="btn btn-outline-secondary btn-lang dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="flag" src="{{ asset('images/' . $flagCurrent . '.' . $ext) }}" alt="lang">
                                <span>{{ strtoupper($locale) }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item flag-inline" href="{{ url('lang/fr') }}"
                                        aria-label="Français">
                                        <img class="flag" src="{{ asset('images/drapeau_fr.' . $ext) }}" alt="FR">
                                        <span>Français</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item flag-inline" href="{{ url('lang/en') }}"
                                        aria-label="English">
                                        <img class="flag" src="{{ asset('images/drapeau_en.' . $ext) }}" alt="EN">
                                        <span>English</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item flag-inline" href="{{ url('lang/es') }}"
                                        aria-label="Español">
                                        <img class="flag" src="{{ asset('images/drapeau_es.' . $ext) }}" alt="ES">
                                        <span>Español</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>

        <footer>
            <div>
                © {{ date('Y') }} — Gestion Airline |
                <a href="{{ url('/apropos') }}">@lang('general.a_propos')</a>
            </div>
            <div class="mt-2 footer-flags">
                <a href="{{ url('lang/fr') }}" title="Français">
                    <img class="flag flag-sm" src="{{ asset('images/drapeau_fr.' . $ext) }}" alt="FR">
                </a>
                <a href="{{ url('lang/en') }}" title="English">
                    <img class="flag flag-sm" src="{{ asset('images/drapeau_en.' . $ext) }}" alt="EN">
                </a>
                <a href="{{ url('lang/es') }}" title="Español">
                    <img class="flag flag-sm" src="{{ asset('images/drapeau_es.' . $ext) }}" alt="ES">
                </a>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>