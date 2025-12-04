<template>
    <div class="row" :dir="direction" :lang="lang">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">{{ t('dashboard.title') }}</h1>
                    <p class="mb-1">
                        {{ t('dashboard.hello', { name: fullName || '...' }) }}
                    </p>
                    <p class="text-muted mb-0" v-if="user">
                        {{ t('dashboard.connectedAs', { email: user.email }) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">{{ t('dashboard.quickActions') }}</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <RouterLink class="btn btn-outline-primary w-100" to="/vols">
                                {{ t('dashboard.viewFlights') }}
                            </RouterLink>
                        </li>
                        <li class="mb-2" v-if="isAdmin">
                            <RouterLink class="btn btn-outline-success w-100" to="/vols/create">
                                {{ t('dashboard.addFlight') }}
                            </RouterLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router'
import { useI18n } from '../i18n'

export default {
    name: 'Dashboard',
    components: { RouterLink },
    setup() {
        const { t, lang, direction } = useI18n()
        return { t, lang, direction }
    },
    data() {
        return {
            user: null,
        }
    },
    computed: {
        fullName() {
            if (!this.user) {
                return ''
            }
            return this.user.prenom
                ? `${this.user.prenom} ${this.user.name}`
                : this.user.name
        },
        isAdmin() {
            return this.user && this.user.role === 'admin'
        },
    },
    created() {
        const storedUser = localStorage.getItem('user')
        if (storedUser) {
            this.user = JSON.parse(storedUser)
        }
    },
}
</script>
