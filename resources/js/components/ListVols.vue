<template>
    <div :dir="direction" :lang="lang">
        <div class="card shadow-sm">
            <div class="card-body">
                <header class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="h4 mb-1">{{ t('listVols.title') }}</h1>
                    </div>
                    <RouterLink v-if="isAdmin" class="btn btn-success" to="/vols/create">{{ t('listVols.add') }}</RouterLink>
                </header>

                <div v-if="loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status" />
                </div>

                <div v-else-if="error" class="alert alert-danger">
                    {{ error }}
                </div>

                <div v-else>
                    <div v-if="vols.length === 0" class="alert alert-info mb-0">{{ t('listVols.empty') }}</div>

                    <div v-else class="tickets-grid">
                        <div v-for="vol in vols" :key="vol.id" class="ticket-card" :class="{ mine: vol.has_ticket }">
                            <div v-if="vol.photo_url" class="ticket-photo">
                                <img :src="vol.photo_url" :alt="t('listVols.photoAlt', { id: vol.id })" />
                            </div>
                            <div class="ticket-header">
                                <div>
                                    <div class="ticket-code">{{ vol.id }}</div>
                                    <div class="ticket-route">{{ vol.origine }} → {{ vol.destination }}</div>
                                </div>
                                <span v-if="vol.has_ticket" class="badge bg-success">{{ t('listVols.mine') }}</span>
                            </div>

                            <div class="ticket-body">
                                <div class="ticket-line">
                                    <small class="text-muted">{{ t('listVols.depart') }}</small>
                                    <span>{{ formatDate(vol.date_depart) }}</span>
                                </div>
                                <div class="ticket-line">
                                    <small class="text-muted">{{ t('listVols.arrivee') }}</small>
                                    <span>{{ formatDate(vol.date_arrive) }}</span>
                                </div>
                                <div class="ticket-line">
                                    <small class="text-muted">{{ t('listVols.price') }}</small>
                                    <strong>{{ vol.prix }} $</strong>
                                </div>
                                <div class="ticket-line">
                                    <small class="text-muted">{{ t('listVols.plane') }}</small>
                                    <span>
                                        <template v-if="vol.avion">
                                            {{ vol.avion.modele }} ({{ vol.avion.capacite }} pl.)
                                        </template>
                                        <template v-else>{{ t('listVols.noPlane') }}</template>
                                    </span>
                                </div>
                                <div class="ticket-actions">
                                    <button class="btn btn-sm btn-outline-secondary me-2" @click="openDetails(vol)">
                                        {{ t('listVols.details') }}
                                    </button>
                                    <button class="btn btn-sm btn-primary me-2" @click="buyTicket(vol)">
                                        Acheter
                                    </button>
                                    <div v-if="isAdmin" class="d-inline-flex gap-2">
                                        <RouterLink class="btn btn-sm btn-outline-warning" :to="`/vols/${vol.id}/edit`">
                                            {{ t('listVols.modifier') }}
                                        </RouterLink>
                                        <button class="btn btn-sm btn-outline-danger" @click="deleteVol(vol.id)">
                                            {{ t('listVols.supprimer') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selectedVol" class="modal-mask" @click.self="closeDetails">
            <div class="modal-dialog">
                <div class="modal-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0">{{ t('listVols.detailsTitle', { id: selectedVol.id }) }}</h5>
                        <button class="btn-close" @click="closeDetails"></button>
                    </div>
                    <div v-if="selectedVol.photo_url" class="mb-3">
                        <img :src="selectedVol.photo_url" class="img-fluid rounded" :alt="selectedVol.id" />
                    </div>
                    <p><strong>{{ t('listVols.depart') }}:</strong> {{ formatDate(selectedVol.date_depart) }}</p>
                    <p><strong>{{ t('listVols.arrivee') }}:</strong> {{ formatDate(selectedVol.date_arrive) }}</p>
                    <p><strong>{{ t('listVols.price') }}:</strong> {{ selectedVol.prix }} $</p>
                    <p>
                        <strong>{{ t('listVols.plane') }}:</strong>
                        <span v-if="selectedVol.avion">
                            {{ selectedVol.avion.modele }} ({{ selectedVol.avion.capacite }} pl.)
                        </span>
                        <span v-else>{{ t('listVols.noPlane') }}</span>
                    </p>
                    <div class="d-flex justify-content-end gap-2">
                        <RouterLink v-if="isAdmin" class="btn btn-sm btn-outline-warning" :to="`/vols/${selectedVol.id}/edit`">
                            {{ t('listVols.modifier') }}
                        </RouterLink>
                        <button class="btn btn-sm btn-outline-secondary" @click="closeDetails">{{ t('listVols.fermer') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { RouterLink } from 'vue-router'
import { useI18n } from '../i18n'

export default {
    name: 'ListVols',
    components: { RouterLink },
    setup() {
        const { t, lang, direction } = useI18n()
        return { t, lang, direction }
    },
    data() {
        return {
            vols: [],
            loading: false,
            error: null,
            selectedVol: null,
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
                this.error = this.t('listVols.loadError')
            } finally {
                this.loading = false
            }
        },
        async buyTicket(vol) {
            const token = localStorage.getItem('token')
            if (!token) {
                this.$router.push({ name: 'login' })
                return
            }

            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

            try {
                await axios.post('/api/tickets', {
                    vol_id: vol.id,
                    quantite: 1,
                })
                this.$router.push({ name: 'tickets.index' })
            } catch (e) {
                if (e.response && e.response.status === 401) {
                    this.$router.push({ name: 'login' })
                } else {
                    alert(this.t('tickets.errors.load'))
                }
            }
        },
        formatDate(value) {
            if (!value) return ''
            return new Date(value).toLocaleString()
        },
        async deleteVol(id) {
            if (!window.confirm(this.t('listVols.deleteConfirm'))) return

            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                await axios.delete(`/api/vols/${id}`)
                this.vols = this.vols.filter((v) => v.id !== id)
            } catch (e) {
                alert(this.t('listVols.deleteError'))
            }
        },
        openDetails(vol) {
            this.selectedVol = vol
        },
        closeDetails() {
            this.selectedVol = null
        },
    },
    watch: {
        // Close details modal if route changes
        $route() {
            this.selectedVol = null
        },
    },
}
</script>

<style scoped>
.tickets-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}

.ticket-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px 16px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.12s ease, box-shadow 0.12s ease;
}

.ticket-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.ticket-card.mine {
    border-color: #22c55e;
    box-shadow: 0 6px 16px rgba(34, 197, 94, 0.12);
}

.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.ticket-code {
    font-weight: 800;
    font-size: 1.05rem;
}

.ticket-route {
    color: #6b7280;
    font-size: 0.95rem;
}

.ticket-photo {
    margin: -14px -16px 10px -16px;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
}

.ticket-photo img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}

.ticket-body {
    display: grid;
    gap: 6px;
}

.ticket-line {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
}

.ticket-actions {
    display: flex;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.modal-mask {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
    z-index: 1050;
    pointer-events: auto !important;
}
.modal-dialog {
    width: min(600px, 100%);
    pointer-events: auto !important;
}
.modal-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    padding: 16px;
}
</style>
