<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestion Airline</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Accueil</a>
                <a class="navbar-brand" href="{{ url('/avions') }}">Avions</a>
                <a class="navbar-brand" href="{{ url('/vols') }}">Vols</a>
                <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>


                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#langNav" aria-controls="langNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

              
                <div class="collapse navbar-collapse justify-content-end" id="langNav">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Langue ({{ strtoupper(app()->getLocale()) }})
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ url('lang/fr') }}">Français</a></li>
                            <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ url('lang/es') }}">Español</a></li>
                        </ul>
                    </div>
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
</body>
</html>
