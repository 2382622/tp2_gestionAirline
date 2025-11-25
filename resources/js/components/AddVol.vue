<template>
    <div class="modal-mask">
        <div class="modal-dialog">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="h4 mb-0">{{ isEdit ? 'Modifier un vol' : 'Ajouter un vol' }}</h1>
                        <RouterLink class="btn-close" to="/vols" aria-label="Fermer"></RouterLink>
                    </div>

                    <div v-if="success" class="alert alert-success">Vol enregistré avec succès.</div>
                    <div v-if="error" class="alert alert-danger">{{ error }}</div>

                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vol-id">Code du vol</label>
                                <input id="vol-id" v-model="form.id" type="text" class="form-control" :disabled="isEdit" required />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vol-origine">Origine</label>
                                <input id="vol-origine" v-model="form.origine" type="text" class="form-control" required />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vol-destination">Destination</label>
                                <input id="vol-destination" v-model="form.destination" type="text" class="form-control" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="vol-depart">Date de départ</label>
                                <input
                                    id="vol-depart"
                                    v-model="form.date_depart"
                                    type="datetime-local"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="vol-arrivee">Date d'arrivée</label>
                                <input
                                    id="vol-arrivee"
                                    v-model="form.date_arrive"
                                    type="datetime-local"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vol-prix">Prix ($)</label>
                                <input
                                    id="vol-prix"
                                    v-model.number="form.prix"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="vol-avion">Avion</label>
                                <select id="vol-avion" v-model="form.avion_id" class="form-select" required>
                                    <option value="" disabled>Choisir un avion…</option>
                                    <option v-for="avion in avions" :key="avion.id" :value="avion.id">
                                        {{ avion.modele }} ({{ avion.capacite }} pl.)
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Photo (glisser-déposer)</label>
                                <div
                                    class="dropzone"
                                    :class="{ over: dragOver }"
                                    @dragover.prevent="dragOver = true"
                                    @dragleave.prevent="dragOver = false"
                                    @drop.prevent="onDrop"
                                    @click="$refs.fileInput.click()"
                                >
                                    <input ref="fileInput" type="file" accept="image/*" class="d-none" @change="onFileSelect" />
                                    <div v-if="previewUrl">
                                        <img :src="previewUrl" alt="Prévisualisation" class="img-fluid rounded mb-1" />
                                        <div class="text-muted small">{{ fileName || 'Image existante' }}</div>
                                    </div>
                                    <div v-else class="text-muted small">Glissez une image ici ou cliquez pour choisir.</div>
                                </div>
                                <small class="text-muted">PNG/JPG, 4 Mo max.</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-success" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                                Enregistrer le vol
                            </button>
                            <RouterLink class="btn btn-outline-secondary" to="/vols">Annuler</RouterLink>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { RouterLink } from 'vue-router'

export default {
    name: 'AddVol',
    components: { RouterLink },
    data() {
        return {
            avions: [],
            form: {
                id: '',
                origine: '',
                destination: '',
                date_depart: '',
                date_arrive: '',
                prix: null,
                avion_id: '',
            },
            file: null,
            previewUrl: '',
            fileName: '',
            loading: false,
            error: null,
            success: false,
            dragOver: false,
        }
    },
    computed: {
        isEdit() {
            return Boolean(this.$route.params.id)
        },
    },
    created() {
        this.fetchAvions()
        if (this.isEdit) {
            this.fetchVol()
        }
        // Assure que le focus clavier reste possible même si un overlay précédent est resté affiché
        document.body.classList.remove('modal-open-block')
    },
    methods: {
        setAuthHeader() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }
        },
        async fetchAvions() {
            this.setAuthHeader()
            try {
                const response = await axios.get('/api/avions')
                this.avions = response.data
            } catch {
                this.error = 'Impossible de charger la liste des avions. Vérifiez que vous êtes connecté.'
            }
        },
        async fetchVol() {
            this.setAuthHeader()
            try {
                const { data } = await axios.get(`/api/vols/${this.$route.params.id}`)
                this.form = {
                    id: data.id,
                    origine: data.origine,
                    destination: data.destination,
                    date_depart: data.date_depart,
                    date_arrive: data.date_arrive,
                    prix: data.prix,
                    avion_id: data.avion_id,
                }
                if (data.photo_url) {
                    this.previewUrl = data.photo_url
                    this.fileName = data.photo?.split('/').pop() || 'image'
                }
            } catch (e) {
                this.error = 'Impossible de charger le vol.'
            }
        },
        onDrop(e) {
            this.dragOver = false
            const file = e.dataTransfer.files[0]
            if (file) {
                this.setFile(file)
            }
        },
        onFileSelect(e) {
            const file = e.target.files[0]
            if (file) {
                this.setFile(file)
            }
        },
        setFile(file) {
            this.file = file
            this.previewUrl = URL.createObjectURL(file)
            this.fileName = file.name
        },
        async submit() {
            this.setAuthHeader()

            this.loading = true
            this.error = null
            this.success = false

            try {
                const payload = new FormData()
                Object.keys(this.form).forEach((key) => {
                    if (this.form[key] !== null && this.form[key] !== '') {
                        payload.append(key, this.form[key])
                    }
                })
                if (this.file) {
                    payload.append('photo', this.file)
                }

                if (this.isEdit) {
                    await axios.post(`/api/vols/${this.$route.params.id}?_method=PUT`, payload, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    })
                } else {
                    await axios.post('/api/vols', payload, { headers: { 'Content-Type': 'multipart/form-data' } })
                }

                this.success = true
                if (!this.isEdit) {
                    this.form = {
                        id: '',
                        origine: '',
                        destination: '',
                        date_depart: '',
                        date_arrive: '',
                        prix: null,
                        avion_id: '',
                    }
                    this.file = null
                    this.previewUrl = ''
                    this.fileName = ''
                }
            } catch (e) {
                if (e.response && e.response.status === 401) {
                    this.error = 'Accès refusé. Veuillez vous connecter.'
                } else if (e.response && e.response.data && e.response.data.errors) {
                    const errors = e.response.data.errors
                    const firstKey = Object.keys(errors)[0]
                    this.error = errors[firstKey][0]
                } else {
                    this.error = "Impossible d'enregistrer le vol."
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>

<style scoped>
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
    width: min(960px, 100%);
    pointer-events: auto !important;
}
.dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.15s ease, background 0.15s ease;
    min-height: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.dropzone.over {
    border-color: #6366f1;
    background: #eef2ff;
}
</style>
