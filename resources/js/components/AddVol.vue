<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Ajouter un vol</h1>

            <div v-if="success" class="alert alert-success">
                Vol ajouté avec succès.
            </div>
            <div v-if="error" class="alert alert-danger">
                {{ error }}
            </div>

            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="vol-id">Code du vol</label>
                        <input
                            id="vol-id"
                            v-model="form.id"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="vol-origine">Origine</label>
                        <input
                            id="vol-origine"
                            v-model="form.origine"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="vol-destination">Destination</label>
                        <input
                            id="vol-destination"
                            v-model="form.destination"
                            type="text"
                            class="form-control"
                            required
                        />
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
                        <label class="form-label" for="vol-arrivee">Date d’arrivée</label>
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
                        <select
                            id="vol-avion"
                            v-model="form.avion_id"
                            class="form-select"
                            required
                        >
                            <option value="" disabled>Choisir un avion…</option>
                            <option v-for="avion in avions" :key="avion.id" :value="avion.id">
                                {{ avion.modele }} ({{ avion.capacite }} pl.)
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="vol-photo">Photo (nom de fichier)</label>
                        <input
                            id="vol-photo"
                            v-model="form.photo"
                            type="text"
                            class="form-control"
                            placeholder="ex: avion1.jpg"
                        />
                        <small class="text-muted">
                            Pour l’API, seul le nom du fichier est envoyé.
                        </small>
                    </div>
                </div>

                <button type="submit" class="btn btn-success" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                    Enregistrer le vol
                </button>
                <RouterLink class="btn btn-link" to="/vols">
                    Retour à la liste
                </RouterLink>
            </form>
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
                photo: '',
            },
            loading: false,
            error: null,
            success: false,
        }
    },
    created() {
        this.fetchAvions()
    },
    methods: {
        async fetchAvions() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }
            try {
                const response = await axios.get('/api/avions')
                this.avions = response.data
            } catch {
                this.error =
                    'Impossible de charger la liste des avions. Vérifiez que vous êtes connecté.'
            }
        },
        async submit() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            this.loading = true
            this.error = null
            this.success = false

            try {
                await axios.post('/api/vols', this.form)
                this.success = true
                this.form = {
                    id: '',
                    origine: '',
                    destination: '',
                    date_depart: '',
                    date_arrive: '',
                    prix: null,
                    avion_id: '',
                    photo: '',
                }
            } catch (e) {
                if (e.response && e.response.status === 401) {
                    this.error = 'Accès refusé. Veuillez vous connecter.'
                } else if (e.response && e.response.data && e.response.data.errors) {
                    const errors = e.response.data.errors
                    const firstKey = Object.keys(errors)[0]
                    this.error = errors[firstKey][0]
                } else {
                    this.error = 'Impossible d’enregistrer le vol.'
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
