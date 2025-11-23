<template>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">Inscription</h1>

                    <div v-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-name">Nom</label>
                                <input
                                    id="register-name"
                                    v-model="name"
                                    type="text"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-prenom">Prénom</label>
                                <input
                                    id="register-prenom"
                                    v-model="prenom"
                                    type="text"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="register-email">Courriel</label>
                            <input
                                id="register-email"
                                v-model="email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-password">Mot de passe</label>
                                <input
                                    id="register-password"
                                    v-model="password"
                                    type="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-password-confirm">
                                    Confirmation
                                </label>
                                <input
                                    id="register-password-confirm"
                                    v-model="passwordConfirmation"
                                    type="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                            Créer mon compte
                        </button>

                        <RouterLink class="btn btn-link" to="/login">
                            Déjà inscrit ? Se connecter
                        </RouterLink>
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
    name: 'Register',
    components: { RouterLink },
    data() {
        return {
            name: '',
            prenom: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            loading: false,
            error: null,
        }
    },
    methods: {
        async submit() {
            this.error = null

            if (this.password !== this.passwordConfirmation) {
                this.error = 'Les mots de passe ne correspondent pas.'
                return
            }

            this.loading = true

            try {
                const response = await axios.post('/api/register', {
                    name: this.name,
                    prenom: this.prenom,
                    email: this.email,
                    password: this.password,
                })

                const { token, user } = response.data

                localStorage.setItem('token', token)
                localStorage.setItem('user', JSON.stringify(user))
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

                this.$router.push({ name: 'dashboard' })
            } catch (e) {
                if (e.response && e.response.data && e.response.data.errors) {
                    const errors = e.response.data.errors
                    const firstKey = Object.keys(errors)[0]
                    this.error = errors[firstKey][0]
                } else {
                    this.error = 'Une erreur est survenue. Veuillez réessayer.'
                }
            } finally {
                this.loading = false
            }
        },
    },
}
</script>
