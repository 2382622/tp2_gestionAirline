<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Liste des vols</h1>
                <RouterLink v-if="isAdmin" class="btn btn-success" to="/vols/create">
                    Ajouter un vol
                </RouterLink>
            </div>

            <div v-if="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">
                {{ error }}
            </div>

            <div v-else>
                <div v-if="vols.length === 0" class="alert alert-info mb-0">
                    Aucun vol trouvé.
                </div>

                <div v-else class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Origine</th>
                                <th>Destination</th>
                                <th>Départ</th>
                                <th>Arrivée</th>
                                <th>Prix</th>
                                <th>Avion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="vol in vols"
                                :key="vol.id"
                                :class="{ 'table-success': vol.has_ticket }"
                            >
                                <td>{{ vol.id }}</td>
                                <td>{{ vol.origine }}</td>
                                <td>{{ vol.destination }}</td>
                                <td>{{ formatDate(vol.date_depart) }}</td>
                                <td>{{ formatDate(vol.date_arrive) }}</td>
                                <td>{{ vol.prix }} $</td>
                                <td>
                                    <span v-if="vol.avion">
                                        {{ vol.avion.modele }} ({{ vol.avion.capacite }} pl.)
                                    </span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { RouterLink } from 'vue-router'

export default {
    name: 'ListVols',
    components: { RouterLink },
    data() {
        return {
            vols: [],
            loading: false,
            error: null,
        }
    },
    created() {
        this.fetchVols()
    },
    computed: {
        isAdmin() {
            const raw = localStorage.getItem('user')
            if (!raw) return false
            try {
                const user = JSON.parse(raw)
                return user && user.role === 'admin'
            } catch (e) {
                return false
            }
        },
    },
    methods: {
        async fetchVols() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/vols')
                this.vols = response.data
            } catch (e) {
                this.error = 'Impossible de charger les vols.'
            } finally {
                this.loading = false
            }
        },
        formatDate(value) {
            if (!value) return ''
            return new Date(value).toLocaleString()
        },
    },
}
</script>
