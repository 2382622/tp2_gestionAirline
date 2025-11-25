<template>
    <div class="row">
        <div class="col-md-7 mb-4">
            <h1 class="mb-3">Bienvenue sur Gestion Airline</h1>
            <p>
                Connectez-vous pour consulter la liste complète des vols, créer
                un nouveau vol ou gérer vos tickets.
            </p>

            <div class="mt-4">
                <RouterLink
                    v-if="!isAuthenticated"
                    class="btn btn-primary me-2"
                    to="/login"
                >
                    Se connecter
                </RouterLink>
                <RouterLink
                    v-if="!isAuthenticated"
                    class="btn btn-outline-secondary"
                    to="/register"
                >
                    Créer un compte
                </RouterLink>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">
                        Vols en provenance de Montréal
                    </h5>

                    <div v-if="loading" class="text-center my-3">
                        <div
                            class="spinner-border text-primary"
                            role="status"
                        />
                    </div>

                    <div v-else-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>

                    <ul v-else class="list-unstyled mb-0">
                        <li v-if="vols.length === 0" class="text-muted">
                            Aucun vol trouvé au départ ou à destination de
                            Montréal.
                        </li>
                        <li
                            v-for="vol in vols"
                            v-else
                            :key="vol.id"
                            class="mb-2"
                        >
                            <strong>{{ vol.id }}</strong>
                            &nbsp;:&nbsp;
                            {{ vol.origine }} → {{ vol.destination }}
                            <br />
                            <small class="text-muted">
                                Départ : {{ formatDate(vol.date_depart) }} |
                                Prix : {{ vol.prix }} $
                            </small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
    name: "Home",
    components: { RouterLink },
    data() {
        return {
            vols: [],
            loading: false,
            error: null,
        };
    },
    computed: {
        isAuthenticated() {
            return !!localStorage.getItem("token");
        },
    },
    created() {
        this.fetchRandomVols();
    },
    methods: {
        async fetchRandomVols() {
            this.loading = true;
            this.error = null;
        },
        formatDate(value) {
            if (!value) {
                return "";
            }
            return new Date(value).toLocaleString();
        },
    },
};
</script>
