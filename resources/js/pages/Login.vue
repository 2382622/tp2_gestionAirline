<template>
    <div class="modal-mask">
        <div class="modal-dialog">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="h4 mb-0">Connexion</h1>
                        <RouterLink class="btn-close" to="/" aria-label="Fermer"></RouterLink>
                    </div>

                    <div v-if="error" class="alert alert-danger">{{ error }}</div>

                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label" for="login-email">Courriel</label>
                            <input id="login-email" v-model="email" type="email" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="login-password">Mot de passe</label>
                            <input id="login-password" v-model="password" type="password" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">reCAPTCHA</label>
                            <div ref="recaptchaContainer" class="recaptcha-box"></div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                                Se connecter
                            </button>
                            <RouterLink class="btn btn-link" to="/register">Créer un compte</RouterLink>
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
    name: 'Login',
    components: { RouterLink },
    data() {
        return {
            email: '',
            password: '',
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

            this.loading = true
            this.error = null

            try {
                await axios.get('/sanctum/csrf-cookie')
                const response = await axios.post('/api/login', {
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
                if (e.response && e.response.data && e.response.data.message) {
                    this.error = e.response.data.message
                } else if (e.response && e.response.data && e.response.data.errors) {
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
    width: min(520px, 100%);
    pointer-events: auto;
}
.recaptcha-box {
    min-height: 78px;
}
</style>
