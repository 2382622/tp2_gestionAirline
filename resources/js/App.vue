<template>
    <div class="app-shell" :dir="direction" :lang="lang">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4">
            <div class="container">
                <RouterLink class="navbar-brand" to="/">{{ t('nav.brand') }}</RouterLink>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#spaNavbar"
                    aria-controls="spaNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="spaNavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/">{{ t('nav.home') }}</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/vols">{{ t('nav.flights') }}</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/tickets">{{ t('nav.tickets') }}</RouterLink>
                        </li>
                        <li class="nav-item">
                            <RouterLink class="nav-link" to="/recherche">{{ t('nav.search') }}</RouterLink>
                        </li>
                        <li class="nav-item" v-if="isAdmin">
                            <RouterLink class="nav-link" :to="{ name: 'avions.index' }">{{ t('nav.listPlanes') }}</RouterLink>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-md-center gap-2">
                        <li class="nav-item dropdown">
                            <button
                                class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <span>{{ currentLanguage.flag }}</span>
                                <span>{{ currentLanguage.label }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li v-for="option in languages" :key="option.code">
                                    <button
                                        class="dropdown-item d-flex align-items-center gap-2"
                                        type="button"
                                        @click="changeLang(option.code)"
                                    >
                                        <span>{{ option.flag }}</span>
                                        <span>{{ option.label }}</span>
                                    </button>
                                </li>
                            </ul>
                        </li>

                        <template v-if="isAuthenticated">
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/dashboard">
                                    {{ currentUserName }}
                                </RouterLink>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-danger btn-sm ms-md-2" @click="logout">
                                    {{ t('nav.logout') }}
                                </button>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/login">{{ t('nav.login') }}</RouterLink>
                            </li>
                            <li class="nav-item">
                                <RouterLink class="nav-link" to="/register">{{ t('nav.register') }}</RouterLink>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container pb-5 flex-grow-1">
            <RouterView />
        </main>

        <footer class="app-footer">
            <div class="container text-center">
                <RouterLink class="app-footer-link" to="/about">
                    {{ t('nav.about') }}
                </RouterLink>
            </div>
        </footer>
    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import axios from 'axios'
import { useI18n } from './i18n'

export default {
    name: 'App',
    components: {
        RouterLink,
        RouterView,
    },
    setup() {
        const { t, lang, direction, languages, setLang } = useI18n()
        return { t, lang, direction, languages, setLang }
    },
    data() {
        return {
            user: null,
        }
    },
    computed: {
        isAuthenticated() {
            return !!this.user
        },
        isAdmin() {
            return this.user && this.user.role === 'admin'
        },
        currentUserName() {
            if (!this.user) {
                return ''
            }
            return this.user.prenom
                ? `${this.user.prenom} ${this.user.name}`
                : this.user.name
        },
        currentLanguage() {
            return this.languages.find((l) => l.code === this.lang) || this.languages[0]
        },
    },
    created() {
        const storedUser = localStorage.getItem('user')
        if (storedUser) {
            this.user = JSON.parse(storedUser)
        }
    },
    methods: {
        async logout() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common.Authorization = `Bearer ${token}`
                try {
                    await axios.post('/api/logout')
                } catch (e) {
                    // ignore logout errors
                }
            }
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common.Authorization
            this.user = null
            this.$router.push({ name: 'home' })
        },
        changeLang(code) {
            this.setLang(code)
        },
    },
    watch: {
        $route() {
            const storedUser = localStorage.getItem('user')
            this.user = storedUser ? JSON.parse(storedUser) : null
        },
    },
}
</script>

<style scoped>
.app-shell {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.app-footer {
    margin-top: auto;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 0.75rem 0;
    font-size: 0.9rem;
    color: #64748b;
}

.app-footer-link {
    color: #6366f1;
    text-decoration: none;
    font-weight: 500;
}

.app-footer-link:hover {
    text-decoration: underline;
}
</style>
