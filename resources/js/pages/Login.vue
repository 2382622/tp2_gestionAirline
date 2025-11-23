<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">Connexion</h1>

                    <div v-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label" for="login-email">Courriel</label>
                            <input
                                id="login-email"
                                v-model="email"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="login-password">Mot de passe</label>
                            <input
                                id="login-password"
                                v-model="password"
                                type="password"
                                class="form-control"
                                required
                            />
                        </div>

                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                            Se connecter
                        </button>

                        <RouterLink class="btn btn-link" to="/register">
                            Créer un compte
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
    name: 'Login',
    components: { RouterLink },
    data() {
        return {
            email: '',
            password: '',
            loading: false,
            error: null,
        }
    },
    methods: {
        async submit() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                })

                const { token, user } = response.data

                localStorage.setItem('token', token)
                localStorage.setItem('user', JSON.stringify(user))
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

                this.$router.push({ name: 'dashboard' })
            } catch (e) {
                if (e.response && e.response.data && e.response.data.message) {
                    this.error = e.response.data.message
                } else if (e.response && e.response.data && e.response.data.errors) {
                    this.error = 'Identifiants incorrects.'
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
