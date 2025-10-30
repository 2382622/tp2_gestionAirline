<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion Airline</title>

    {{-- CSRF token (utile si tu fais des requêtes AJAX) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                {{-- Liens de navigation principaux --}}
                <a class="navbar-brand" href="{{ route('accueil') }}">Accueil</a>
                <a class="navbar-brand" href="{{ route('vols.index') }}">Vols</a>

                {{-- Tickets : visible seulement pour les utilisateurs connectés --}}
                @auth
                    <a class="navbar-brand" href="{{ route('tickets.index') }}">Tickets</a>
                @endauth
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="navbar-brand" href="{{ route('avions.index') }}">Avions</a>
                        <a class="navbar-brand" href="{{ route('admin.tickets.index') }}">Tickets (Admin)</a>
                    @endif
                @endauth

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Menu de droite (auth + langue) --}}
                <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        {{-- Zone Auth --}}
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                            </li>



                        @endguest

                        {{-- Sélecteur de langue --}}
                        <li class="nav-item dropdown ms-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Langue ({{ strtoupper(app()->getLocale()) }})
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('lang/fr') }}">Français</a></li>
                                <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                                <li><a class="dropdown-item" href="{{ url('lang/es') }}">Español</a></li>
                            </ul>
                            <a class="navbar-brand" href="{{ url('/apropos') }}">À propos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4 container">
            @yield('content')
        </main>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>



</html>