@extends('layouts.app')

@section('content')
    <style>
        /* ====== FOND ET STRUCTURE ====== */
        body {
            background:
                radial-gradient(1200px 600px at -10% -10%, #dbeafe 0%, transparent 60%),
                radial-gradient(1000px 600px at 110% 10%, #ede9fe 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Nunito', sans-serif;
        }

        .apropos-container {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            margin-top: 2rem;
            margin-bottom: 2rem;
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ====== TITRE PRINCIPAL ====== */
        .apropos-title {
            text-align: center;
            font-weight: 800;
            color: #1e293b;
            font-size: clamp(28px, 3vw, 36px);
            margin-bottom: 2rem;
            text-shadow: 1px 1px 4px rgba(99, 102, 241, 0.15);
            position: relative;
        }

        .apropos-title::after {
            content: "";
            display: block;
            width: 120px;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            margin: 12px auto 0;
            border-radius: 2px;
        }

        /* ====== CARTES ====== */
        .apropos-card {
            border: none;
            border-radius: 15px;
            background: white;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .apropos-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        }

        .apropos-card h4 {
            color: #4f46e5;
            font-weight: 700;
            border-left: 5px solid #8b5cf6;
            padding-left: 10px;
        }

        /* ====== LISTES ET PARAGRAPHES ====== */
        .apropos-card p,
        .apropos-card li {
            color: #334155;
            font-size: 1rem;
            line-height: 1.6;
        }

        ul,
        ol {
            margin-top: 1rem;
            margin-left: 1.5rem;
        }

        li {
            margin-bottom: 0.5rem;
        }

        /* ====== LIENS ====== */
        a {
            color: #4f46e5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .apropos-container {
                padding: 1.5rem;
            }

            .apropos-title {
                font-size: 1.8rem;
            }

            .apropos-card h4 {
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="container apropos-container">
        {{-- ===== TITRE DE LA PAGE ===== --}}
        <h1 class="apropos-title">À propos de l’application</h1>

        {{-- ===== SECTION INFORMATIONS GÉNÉRALES ===== --}}
        <div class="card apropos-card mb-4">
            <div class="card-body">
                <h4>Informations générales</h4>
                <p><strong>Noms :</strong> Kouanda Yuan Dietrich, Magra Sirine, Granger Samuel</p>
                <p><strong>Titre du cours :</strong> 420-5H6-MO – Applications Web transactionnelles</p>
                <p><strong>Session :</strong> Automne 2025</p>
                <p><strong>Établissement :</strong> Collège Montmorency</p>
            </div>
        </div>

        {{-- ===== DESCRIPTION ===== --}}
        <div class="card apropos-card mb-4">
            <div class="card-body">
                <h4>Description de l’application</h4>
                <p>
                    Cette application web permet de gérer les vols et les avions d’une compagnie aérienne.
                    Elle a été réalisée dans le cadre du cours <em>Applications Web transactionnelles</em> afin de démontrer
                    la création d’un site Laravel complet avec gestion de base de données, rôles utilisateurs et
                    interface multilingue.
                </p>

                <p><strong>Fonctionnalités principales :</strong></p>
                <ul>
                    <li>Affichage, recherche et gestion des vols.</li>
                    <li>Création, modification et suppression d’avions.</li>
                    <li>Autocomplétion dans la recherche des vols et avions.</li>
                    <li>Interface multilingue (Français, Anglais, Espagnol).</li>
                    <li>Système d’authentification avec rôles <em>admin</em> et <em>user</em>.</li>
                </ul>
            </div>
        </div>

        {{-- ===== ÉTAPES DE VÉRIFICATION ===== --}}
        <div class="card apropos-card mb-4">
            <div class="card-body">
                <h4>Étapes pour vérifier le fonctionnement</h4>
                <ol>
                    <li>
                        <strong>Accéder à l’accueil :</strong>
                        Depuis le menu principal, ouvrez la page d’accueil pour voir la liste de tous les vols.
                    </li>
                    <li>
                        <strong>Utiliser la barre de recherche :</strong>
                        Tapez une destination (ex. « Paris ») dans la barre de recherche pour voir l’autocomplétion.
                    </li>
                    <li>
                        <strong>Consulter les détails d’un vol :</strong>
                        Cliquez sur le bouton <em>Voir</em> pour afficher les informations détaillées du vol sélectionné.
                    </li>
                    <li>
                        <strong>Connexion admin :</strong>
                        <ul>
                            <li><strong>Email :</strong> admin@airline.com</li>
                            <li><strong>Mot de passe :</strong> admin123</li>
                        </ul>
                        Cela permet d’accéder aux options de création, modification et suppression de vols.
                    </li>
                    <li>
                        <strong>Créer un vol :</strong>
                        Cliquez sur <em>Créer un vol</em> et remplissez les champs requis, puis enregistrez.
                    </li>
                    <li>
                        <strong>Changer la langue :</strong>
                        Utilisez le menu déroulant du haut pour choisir la langue du site :
                        <ul>
                            <li>Français (FR)</li>
                            <li>Anglais (EN)</li>
                            <li>Espagnol (ES)</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>

        {{-- ===== REMARQUES ===== --}}
        <div class="card apropos-card mb-4">
            <div class="card-body">
                <h4>Remarques</h4>
                <ul>
                    <li>Si la recherche ne donne aucun résultat, le message « Aucun vol trouvé » s’affiche.</li>
                    <li>Les utilisateurs non connectés peuvent uniquement consulter les vols.</li>
                    <li>Les boutons « Modifier » et « Supprimer » sont réservés aux administrateurs.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection