<template>
    <div class="app-shell">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4">
            <div class="container">
                <RouterLink class="navbar-brand" to="/">Gestion Airline</RouterLink>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#spaNavbar"
                    aria-controls="spaNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="spaNavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/">Accueil</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/vols">Vols</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/tickets">Mes billets</RouterLink>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <RouterLink class="nav-link" to="/vols/create">Ajouter un vol</RouterLink>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <a class="nav-link" href="/avions">Liste Avions</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <template v-if="isAuthenticated">
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/dashboard">
                                    {{ currentUserName }}
                                </RouterLink>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-danger btn-sm ms-2" @click="logout">
                                    Déconnexion
                                </button>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/login">Connexion</RouterLink>
                            </li>
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/register">Inscription</RouterLink>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container pb-5 flex-grow-1">
            <RouterView />
        </main>

        <footer class="app-footer">
            <div class="container text-center">
                <RouterLink class="app-footer-link" to="/about">
                    À propos
                </RouterLink>
            </div>
        </footer>
    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import axios from 'axios'

export default {
    name: 'App',
    components: {
        RouterLink,
        RouterView,
    },
    data() {
        return {
            user: null,
        }
    },
    computed: {
        isAuthenticated() {
            return !!this.user
        },
        isAdmin() {
            return this.user && this.user.role === 'admin'
        },
        currentUserName() {
            if (!this.user) {
                return ''
            }
            return this.user.prenom
                ? `${this.user.prenom} ${this.user.name}`
                : this.user.name
        },
    },
    created() {
        const storedUser = localStorage.getItem('user')
        if (storedUser) {
            this.user = JSON.parse(storedUser)
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common.Authorization
            this.user = null
            this.$router.push({ name: 'home' })
        },
    },
    watch: {
        $route() {
            const storedUser = localStorage.getItem('user')
            this.user = storedUser ? JSON.parse(storedUser) : null
        },
    },
}
</script>

<style scoped>
.app-shell {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.app-footer {
    margin-top: auto;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 0.75rem 0;
    font-size: 0.9rem;
    color: #64748b;
}

.app-footer-link {
    color: #6366f1;
    text-decoration: none;
    font-weight: 500;
}

.app-footer-link:hover {
    text-decoration: underline;
}
</style>

