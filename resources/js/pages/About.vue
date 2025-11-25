<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">À propos</h1>
            <p class="mb-1">
                <strong>Nom :</strong> Kouanda Yuan Dietrich - Sirine Magra -
                Samuel Granger
            </p>
            <p class="mb-3">
                <strong>Cours :</strong> 420-267 MO Développer un site Web et
                une application pour Internet — Automne 2021, Collège
                Montmorency.
            </p>

            <h2 class="h5 mt-4">Comment vérifier l’application</h2>
            <ol>
                <li>
                    Créer un compte (captcha requis) via le popup d’inscription,
                    ou se connecter si admin.
                </li>
                <li>
                    Avec un compte admin : créer/éditer/supprimer un vol (popup
                    avec drag & drop d’image) et un avion.
                </li>
                <li>
                    Avec un compte client : acheter des billets, consulter “Mes
                    billets” (seulement vos billets).
                </li>
                <li>
                    Consulter la liste des vols, avec filtres (date, prix,
                    destination).
                </li>
            </ol>

            <h2 class="h5 mt-4">Diagramme BD</h2>
        </div>
    </div>
</template>

<script>
export default {
    name: "About",
};
</script>
