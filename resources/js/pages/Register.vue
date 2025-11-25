<template>
    <div class="modal-mask">
        <div class="modal-dialog">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="h4 mb-0">Inscription</h1>
                        <RouterLink class="btn-close" to="/" aria-label="Fermer"></RouterLink>
                    </div>

                    <div v-if="error" class="alert alert-danger">{{ error }}</div>

                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-name">Nom</label>
                                <input id="register-name" v-model="name" type="text" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-prenom">Prénom</label>
                                <input id="register-prenom" v-model="prenom" type="text" class="form-control" required />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="register-email">Courriel</label>
                            <input id="register-email" v-model="email" type="email" class="form-control" required />
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-password">Mot de passe</label>
                                <input id="register-password" v-model="password" type="password" class="form-control" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="register-password-confirm">Confirmation</label>
                                <input
                                    id="register-password-confirm"
                                    v-model="passwordConfirmation"
                                    type="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">reCAPTCHA</label>
                            <div ref="recaptchaContainer" class="recaptcha-box"></div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-success" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                                Créer mon compte
                            </button>

                            <RouterLink class="btn btn-link" to="/login">Déjà inscrit ? Se connecter</RouterLink>
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
    name: 'Register',
    components: { RouterLink },
    data() {
        return {
            name: '',
            prenom: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            recaptchaToken: '',
            recaptchaWidgetId: null,
            captchaInterval: null,
            loading: false,
            error: null,
        }
    },
    mounted() {
        this.waitAndRenderCaptcha()
    },
    beforeUnmount() {
        if (this.captchaInterval) {
            clearInterval(this.captchaInterval)
        }
        this.resetCaptcha()
    },
    methods: {
        waitAndRenderCaptcha() {
            const siteKey = window.RECAPTCHA_SITE_KEY || ''
            if (!siteKey) {
                this.error = 'reCAPTCHA non configuré.'
                return
            }

            this.captchaInterval = setInterval(() => {
                if (window.grecaptcha && window.grecaptcha.render && this.$refs.recaptchaContainer) {
                    clearInterval(this.captchaInterval)
                    this.captchaInterval = null
                    this.recaptchaWidgetId = window.grecaptcha.render(this.$refs.recaptchaContainer, {
                        sitekey: siteKey,
                        callback: (token) => {
                            this.recaptchaToken = token
                            this.error = null
                        },
                        'error-callback': () => {
                            this.recaptchaToken = ''
                            this.error = 'Captcha invalide.'
                        },
                        'expired-callback': () => {
                            this.recaptchaToken = ''
                        },
                    })
                }
            }, 300)
        },
        resetCaptcha() {
            if (window.grecaptcha && this.recaptchaWidgetId !== null) {
                window.grecaptcha.reset(this.recaptchaWidgetId)
            }
            this.recaptchaToken = ''
        },
        async submit() {
            if (!this.recaptchaToken) {
                this.error = 'Merci de valider le captcha.'
                return
            }

            if (this.password !== this.passwordConfirmation) {
                this.error = 'Les mots de passe ne correspondent pas.'
                return
            }

            this.loading = true
            this.error = null

            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/register', {
                    name: this.name,
                    prenom: this.prenom,
                    email: this.email,
                    password: this.password,
                    recaptcha_token: this.recaptchaToken,
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
                this.resetCaptcha()
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
    pointer-events: none;
}
.modal-dialog {
    width: min(620px, 100%);
    pointer-events: auto;
}
.recaptcha-box {
    min-height: 78px;
}
</style>
