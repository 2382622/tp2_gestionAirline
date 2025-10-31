<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion Airline</title>

    {{-- CSRF token pour sécuriser les requêtes AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Importation des polices et styles externes --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

    <style>
        /* ====== FOND GLOBAL ====== */
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

        /* ====== STRUCTURE PRINCIPALE ====== */
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            /* pousse le footer vers le bas */
        }

        /* ====== NAVBAR ====== */
        .navbar {
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .navbar-brand {
            color: #4f46e5 !important;
            font-weight: 700;
            transition: color 0.2s ease;
        }

        .navbar-brand:hover {
            color: #6366f1 !important;
        }

        .nav-link {
            color: #334155 !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #6366f1 !important;
        }

        /* ====== FOOTER FIXE ====== */
        footer {
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            color: white;
            text-align: center;
            padding: 1rem 0;
            font-size: 0.95rem;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            /* empêche le chevauchement */
            width: 100%;
        }

        footer a {
            color: #c7d2fe;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer a:hover {
            color: white;
            text-decoration: underline;
        }

        /* ====== BOUTON LANGUE ====== */
        .btn-outline-secondary {
            border-color: #cbd5e1;
            color: #334155;
        }

        .btn-outline-secondary:hover {
            background-color: #6366f1;
            color: white;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        {{-- ====== BARRE DE NAVIGATION ====== --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                {{-- Liens principaux --}}
                <a class="navbar-brand" href="{{ route('accueil') }}">@lang('general.accueil')</a>
                <a class="navbar-brand" href="{{ route('vols.index') }}">@lang('general.vols')</a>

                {{-- Tickets visibles seulement si connecté --}}
                @auth
                    <a class="navbar-brand" href="{{ route('tickets.index') }}">@lang('general.tickets')</a>
                @endauth

                {{-- Liens admin --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="navbar-brand" href="{{ route('avions.index') }}">@lang('general.avions')</a>
                        <a class="navbar-brand" href="{{ route('admin.tickets.index') }}">@lang('general.tickets_admin')</a>
                    @endif
                @endauth

                {{-- Bouton burger mobile --}}
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Menu droit : Auth + Langue --}}
                <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        {{-- Si connecté --}}
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

                        {{-- Si invité --}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">@lang('general.connexion')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('general.inscription')</a>
                            </li>
                        @endguest

                        {{-- Sélecteur de langue --}}
                        <li class="nav-item dropdown ms-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @lang('general.langue') ({{ strtoupper(app()->getLocale()) }})
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('lang/fr') }}">@lang('general.lang_fr')</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('lang/en') }}">@lang('general.lang_en')</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('lang/es') }}">@lang('general.lang_es')</a>
                                </li>
                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- ====== CONTENU PRINCIPAL ====== --}}
        <main class="py-4 container">
            @yield('content')
        </main>

        {{-- ====== FOOTER FIXE EN BAS ====== --}}
        <footer>
            <div>
                © {{ date('Y') }} — Gestion Airline |
                <a href="{{ url('/apropos') }}">@lang('general.a_propos')</a>
            </div>
            <div class="small text-light mt-1">
                @lang('general.langue'):
                <a href="{{ url('lang/fr') }}">FR</a> ·
                <a href="{{ url('lang/en') }}">EN</a> ·
                <a href="{{ url('lang/es') }}">ES</a>
            </div>
        </footer>
    </div>

    {{-- Scripts JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>