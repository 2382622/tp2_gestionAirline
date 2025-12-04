<template>
    <div class="row" :dir="direction" :lang="lang">
        <div class="col-md-7 mb-4">
            <h1 class="mb-3">{{ t('home.title') }}</h1>
            <p>{{ t('home.intro') }}</p>

            <div class="mt-4">
                <RouterLink
                    v-if="!isAuthenticated"
                    class="btn btn-primary me-2"
                    to="/login"
                >
                    {{ t('home.ctaLogin') }}
                </RouterLink>
                <RouterLink
                    v-if="!isAuthenticated"
                    class="btn btn-outline-secondary"
                    to="/register"
                >
                    {{ t('home.ctaRegister') }}
                </RouterLink>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">
                        {{ t('home.cardTitle') }}
                    </h5>

                    <div v-if="loading" class="text-center my-3">
                        <div
                            class="spinner-border text-primary"
                            role="status"
                        />
                    </div>

                    <div v-else-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>

                    <ul v-else class="list-unstyled mb-0">
                        <li v-if="vols.length === 0" class="text-muted">
                            {{ t('home.empty') }}
                        </li>
                        <li
                            v-for="vol in vols"
                            v-else
                            :key="vol.id"
                            class="mb-2"
                        >
                            <strong>{{ vol.id }}</strong>
                            &nbsp;:&nbsp;
                            {{ vol.origine }} → {{ vol.destination }}
                            <br />
                            <small class="text-muted">
                                {{ t('home.depart') }} : {{ formatDate(vol.date_depart) }} |
                                {{ t('home.price') }} : {{ vol.prix }} $
                            </small>
                        </li>
                    </ul>
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
    name: 'Home',
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
        }
    },
    computed: {
        isAuthenticated() {
            return !!localStorage.getItem('token')
        },
    },
    created() {
        this.fetchRandomVols()
    },
    methods: {
        async fetchRandomVols() {
            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/vols-home')
                this.vols = response.data
            } catch (e) {
                this.error = this.t('home.error')
            } finally {
                this.loading = false
            }
        },
        formatDate(value) {
            if (!value) {
                return ''
            }
            return new Date(value).toLocaleString()
        },
    },
}
</script>
