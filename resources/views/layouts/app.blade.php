<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion Airline</title>

    {{-- CSRF token (utile pour les requêtes AJAX) --}}
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
                <a class="navbar-brand" href="{{ route('accueil') }}">@lang('general.accueil')</a>
                <a class="navbar-brand" href="{{ route('vols.index') }}">@lang('general.vols')</a>

                {{-- Tickets : visibles seulement pour les utilisateurs connectés --}}
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
                                        @lang('general.deconnexion')
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
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
                            <a class="navbar-brand" href="{{ url('/apropos') }}">@lang('general.a_propos')</a>
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