<template>
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">Tableau de bord</h1>
                    <p class="mb-1">
                        Bonjour
                        <strong>{{ fullName }}</strong>
                        !
                    </p>
                    <p class="text-muted mb-0">
                        Vous êtes connecté avec l’adresse
                        <strong>{{ user?.email }}</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Actions rapides</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <RouterLink class="btn btn-outline-primary w-100" to="/vols">
                                Voir tous les vols
                            </RouterLink>
                        </li>
                        <li class="mb-2" v-if="isAdmin">
                            <RouterLink class="btn btn-outline-success w-100" to="/vols/create">
                                Ajouter un vol
                            </RouterLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
    name: 'Dashboard',
    components: { RouterLink },
    data() {
        return {
            user: null,
        }
    },
    computed: {
        fullName() {
            if (!this.user) {
                return ''
            }
            return this.user.prenom
                ? `${this.user.prenom} ${this.user.name}`
                : this.user.name
        },
        isAdmin() {
            return this.user && this.user.role === 'admin'
        },
    },
    created() {
        const storedUser = localStorage.getItem('user')
        if (storedUser) {
            this.user = JSON.parse(storedUser)
        }
    },
}
</script>
