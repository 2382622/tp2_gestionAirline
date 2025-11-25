<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Recherche de vols</h1>
            <p class="text-muted">Tapez une origine, une destination ou un code vol pour voir les suggestions.</p>

            <div class="mb-3">
                <input
                    v-model="query"
                    type="search"
                    class="form-control"
                    placeholder="Montréal, Paris, V-001..."
                    @input="debouncedSearch"
                />
            </div>

            <div v-if="loading" class="text-center py-3">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">{{ error }}</div>

            <div v-else-if="results.length === 0" class="alert alert-info">Aucun résultat pour l’instant.</div>

            <div v-else class="list-group">
                <div v-for="vol in results" :key="vol.id" class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="fw-bold">{{ vol.id }} — {{ vol.origine }} → {{ vol.destination }}</div>
                            <div class="text-muted small">
                                Départ: {{ formatDate(vol.date_depart) }} • Arrivée: {{ formatDate(vol.date_arrive) }}
                            </div>
                            <div class="text-muted small">
                                Avion: <span v-if="vol.avion">{{ vol.avion.modele }} ({{ vol.avion.capacite }} pl.)</span>
                                <span v-else>—</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong>{{ vol.prix }} $</strong>
                            <div v-if="vol.photo_url" class="thumb mt-1">
                                <img :src="vol.photo_url" :alt="`Photo ${vol.id}`" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'Search',
    data() {
        return {
            query: '',
            results: [],
            loading: false,
            error: null,
            timer: null,
        }
    },
    methods: {
        debouncedSearch() {
            clearTimeout(this.timer)
            this.timer = setTimeout(() => this.search(), 300)
        },
        async search() {
            if (!this.query) {
                this.results = []
                return
            }
            this.loading = true
            this.error = null
            try {
                const { data } = await axios.get('/api/vols-search', { params: { q: this.query } })
                this.results = data
            } catch (e) {
                this.error = 'Impossible de charger les résultats.'
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

<style scoped>
.thumb img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}
</style>
