@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">À propos de l’application</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Informations générales</h4>
                <p><strong>Noms :</strong> Kouanda Yuan Dietrich, Magra Sirine, Granger Samuel</p>
                <p><strong>Titre du cours :</strong> 420-5H6-MO – Applications Web transactionnelles</p>
                <p><strong>Session :</strong> Automne 2023</p>
                <p><strong>Établissement :</strong> Collège Montmorency</p>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="mb-3">Description de l’application</h4>
                <p>
                    Cette application web permet de gérer les vols et les avions d’une
                    compagnie aérienne.
                    Elle a été réalisée dans le cadre du cours <em>Applications Web transactionnelles</em> afin de démontrer
                    la création d’un site Laravel complet avec gestion de base de données, rôles utilisateurs et
                    multilinguisme.
                </p>

                <p>L’application inclut les principales fonctionnalités suivantes :</p>
                <ul>
                    <li>Affichage, recherche et gestion des vols.</li>
                    <li>Création, modification et suppression d’avions.</li>
                    <li>Autocomplétion dans la recherche des vols et avions.</li>
                    <li>Interface multilingue (Français, Anglais, Espagnol).</li>
                    <li>Système d’authentification avec rôles <em>admin</em> et <em>user</em>.</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="mb-3">Étapes pour vérifier le fonctionnement</h4>

                <ol>
                    <li>
                        <strong>Accéder à l’accueil :</strong>
                        Rendez-vous sur la page d’accueil à partir du menu principal.
                        Vous verrez la liste de tous les vols enregistrés dans la base de données.
                    </li>

                    <li>
                        <strong>Utiliser la barre de recherche :</strong>
                        Tapez une destination (ex : “Paris”) dans la barre de recherche.
                        → Des suggestions apparaîtront automatiquement grâce à l’autocomplétion.
                        → Sélectionnez un vol pour consulter sa page de détails.
                    </li>

                    <li>
                        <strong>Consulter les détails d’un vol :</strong>
                        Cliquez sur le bouton « Voir » pour afficher les informations d’un vol :
                        <em>origine, destination, dates, prix et avion associé.</em>
                    </li>

                    <li>
                        <strong>Se connecter comme administrateur :</strong>
                        Utilisez les identifiants suivants :
                        <ul>
                            <li><strong>Email :</strong> admin@airline.com</li>
                            <li><strong>Mot de passe :</strong> admin123</li>
                        </ul>
                        Une fois connecté, vous aurez accès à de nouvelles options :
                        <ul>
                            <li>Créer un vol</li>
                            <li>Modifier un vol</li>
                            <li>Supprimer un vol</li>
                        </ul>
                    </li>

                    <li>
                        <strong>Créer un vol :</strong>
                        Cliquez sur « Créer un vol » et remplissez le formulaire avec :
                        <ul>
                            <li>L’origine et la destination</li>
                            <li>Les dates de départ et d’arrivée</li>
                            <li>Le prix du billet</li>
                            <li>L’avion choisi</li>
                        </ul>
                        Cliquez sur <strong>Enregistrer</strong> pour l’ajouter à la liste.
                    </li>

                    <li>
                        <strong>Changer la langue :</strong>
                        Utilisez le menu déroulant du haut pour sélectionner :
                        <ul>
                            <li>Français FR</li>
                            <li>Anglais EN</li>
                            <li>Espagnol ES</li>
                        </ul>
                        Le contenu du site s’adapte automatiquement à la langue choisie.
                    </li>
                </ol>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="mb-3">Remarques</h4>
                <ul>
                    <li>Si la recherche ne donne aucun résultat, le message « Aucun vol trouvé » s’affiche.</li>
                    <li>Les utilisateurs non connectés peuvent consulter uniquement les vols.</li>
                    <li>Les boutons « Modifier » et « Supprimer » sont réservés aux administrateurs.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection