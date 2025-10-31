@extends('layouts.app') {{-- On hérite de la mise en page principale (header, footer, etc.) --}}

@section('content')
    <style>
        /* ======== FOND GLOBAL ======== */
        /* On définit le fond du site avec un dégradé de couleur douce et un effet radial */
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            /* Empêche de faire défiler la page */
            background: radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* ======== CENTRAGE DU CONTENU ======== */
        .ga-bg {
            height: 100vh;
            /* Pleine hauteur d’écran */
            display: flex;
            /* Flexbox pour centrer */
            align-items: center;
            /* Centre verticalement */
            justify-content: center;
            /* Centre horizontalement */
        }

        /* ======== STYLE DE LA CARTE (formulaire) ======== */
        .ga-card {
            backdrop-filter: blur(10px);
            /* Effet flou derrière la carte */
            background: rgba(255, 255, 255, 0.9);
            /* Couleur blanche semi-transparente */
            border: 1px solid rgba(15, 23, 42, 0.06);
            /* Bordure très légère */
            border-radius: 1.5rem;
            /* Coins arrondis */
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
            /* Ombre douce */
            padding: 2rem;
            /* Espacement interne */
        }

        /* ======== CHAMPS DE FORMULAIRE ======== */
        .ga-form-control {
            border-radius: 0.75rem;
            /* Arrondi des champs */
        }

        .ga-form-control:focus {
            /* Quand on clique dans un champ */
            border-color: #6366f1 !important;
            /* Bordure violette */
            box-shadow: 0 0 0 .25rem rgba(99, 102, 241, .25) !important;
            /* Halo violet */
        }

        /* ======== BOUTONS PRINCIPAUX ======== */
        .ga-btn-primary {
            background: #6366f1;
            /* Violet principal */
            border: none;
            border-radius: 0.75rem;
            transition: all 0.2s ease-in-out;
        }

        .ga-btn-primary:hover {
            background: #4f46e5;
            /* Un peu plus foncé au survol */
            transform: translateY(-1px);
            /* Légère animation vers le haut */
        }

        /* ======== BOUTONS SECONDAIRES (Annuler) ======== */
        .ga-btn-secondary {
            background: #94a3b8;
            /* Gris clair */
            border: none;
            border-radius: 0.75rem;
        }

        .ga-btn-secondary:hover {
            background: #64748b;
            /* Gris un peu plus foncé */
            transform: translateY(-1px);
        }

        /* ======== TITRE ======== */
        .ga-title {
            font-weight: 700;
            color: #1e293b;
            /* Bleu foncé */
        }

        /* ======== TEXTE SECONDAIRE ======== */
        .ga-muted {
            color: #64748b;
            /* Gris doux */
        }
    </style>

    {{-- Conteneur principal (fond centré) --}}
    <div class="ga-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-9 col-md-8 col-lg-6">
                    {{-- Carte blanche contenant le formulaire --}}
                    <div class="ga-card">
                        <h1 class="h3 text-center ga-title mb-4">@lang('general.creer_vol')</h1>

                        {{-- Vérifie s’il y a des erreurs de validation --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulaire d’ajout de vol --}}
                        <form action="{{ route('vols.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf {{-- Jeton de sécurité CSRF obligatoire pour Laravel --}}

                            {{-- Champ ID du vol --}}
                            <div class="mb-3">
                                <label for="id" class="form-label">@lang('general.id_vol')</label>
                                <input type="text" class="form-control ga-form-control" id="id" name="id" required>
                            </div>

                            {{-- Champ origine --}}
                            <div class="mb-3">
                                <label for="origine" class="form-label">@lang('general.origine')</label>
                                <input type="text" class="form-control ga-form-control" id="origine" name="origine"
                                    required>
                            </div>

                            {{-- Champ destination --}}
                            <div class="mb-3">
                                <label for="destination" class="form-label">@lang('general.destination')</label>
                                <input type="text" class="form-control ga-form-control" id="destination" name="destination"
                                    required>
                            </div>

                            {{-- Champ date de départ --}}
                            <div class="mb-3">
                                <label for="date_depart" class="form-label">@lang('general.date_depart')</label>
                                <input type="date" class="form-control ga-form-control" id="date_depart" name="date_depart"
                                    required>
                            </div>

                            {{-- Champ date d’arrivée --}}
                            <div class="mb-3">
                                <label for="date_arrive" class="form-label">@lang('general.date_arrivee')</label>
                                <input type="date" class="form-control ga-form-control" id="date_arrive" name="date_arrive"
                                    required>
                            </div>

                            {{-- Champ prix --}}
                            <div class="mb-3">
                                <label for="prix" class="form-label">@lang('general.prix')</label>
                                <input type="number" step="0.01" class="form-control ga-form-control" id="prix" name="prix"
                                    required>
                            </div>

                            {{-- Sélecteur avion --}}
                            <div class="mb-3">
                                <label for="avion_id" class="form-label">@lang('general.avion')</label>
                                <select name="avion_id" id="avion_id" class="form-select ga-form-control" required>
                                    <option value="">@lang('general.choisir_avion')</option>
                                    {{-- Boucle pour afficher tous les avions disponibles --}}
                                    @foreach($avions as $avion)
                                        <option value="{{ $avion->id }}">{{ $avion->modele }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Upload d’une photo --}}
                            <div class="mb-3">
                                <label class="form-label">@lang('general.photo_vol')</label>
                                <input type="file" name="photo" class="form-control ga-form-control"
                                    accept=".jpg,.jpeg,.png,.gif,.svg" required>
                                <small class="ga-muted">@lang('general.formats_autorises')</small>
                            </div>

                            {{-- Boutons d’action --}}
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn ga-btn-primary text-white px-4">
                                    @lang('general.enregistrer')
                                </button>
                                <a href="{{ route('vols.index') }}" class="btn ga-btn-secondary text-white px-4">
                                    @lang('general.annuler')
                                </a>
                            </div>
                        </form>

                        {{-- Pied de carte --}}
                        <div class="text-center ga-muted small mt-4">
                            © {{ date('Y') }} — Gestion Airline
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection