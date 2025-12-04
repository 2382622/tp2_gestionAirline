<template>
    <div class="card shadow-sm" :dir="direction" :lang="lang">
        <div class="card-body">
            <h1 class="h4 mb-3">{{ t('search.title') }}</h1>
            <p class="text-muted">{{ t('search.subtitle') }}</p>

            <div class="mb-3">
                <input
                    v-model="query"
                    type="search"
                    class="form-control"
                    :placeholder="t('search.placeholder')"
                    @input="debouncedSearch"
                />
            </div>

            <div v-if="loading" class="text-center py-3">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">{{ error }}</div>

            <div v-else-if="results.length === 0" class="alert alert-info">{{ t('search.noResults') }}</div>

            <div v-else class="list-group">
                <div v-for="vol in results" :key="vol.id" class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="fw-bold">{{ vol.id }} – {{ vol.origine }} → {{ vol.destination }}</div>
                            <div class="text-muted small">
                                {{ t('search.depart') }}: {{ formatDate(vol.date_depart) }} •
                                {{ t('search.arrivee') }}: {{ formatDate(vol.date_arrive) }}
                            </div>
                            <div class="text-muted small">
                                {{ t('search.plane') }}:
                                <span v-if="vol.avion">{{ vol.avion.modele }} ({{ vol.avion.capacite }} pl.)</span>
                                <span v-else>{{ t('search.noPlane') }}</span>
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
import { useI18n } from '../i18n'

export default {
    name: 'Search',
    setup() {
        const { t, lang, direction } = useI18n()
        return { t, lang, direction }
    },
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
                this.error = this.t('search.error')
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
