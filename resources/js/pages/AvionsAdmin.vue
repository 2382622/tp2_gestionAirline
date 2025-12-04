<template>
    <div class="card shadow-sm" :dir="direction" :lang="lang">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 m-0">{{ t('avions.title') }}</h1>
            </div>

            <div v-if="success" class="alert alert-success py-2">
                {{ success }}
            </div>
            <div v-if="error" class="alert alert-danger py-2">{{ error }}</div>

            <div v-if="loading" class="text-center my-4">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ t('avions.table.id') }}</th>
                            <th>{{ t('avions.table.model') }}</th>
                            <th>{{ t('avions.table.capacity') }}</th>
                            <th class="text-end">{{ t('avions.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="avion in avions" :key="avion.id">
                            <td>{{ avion.id }}</td>
                            <td>
                                <div v-if="editingId === avion.id">
                                    <input
                                        v-model="form.modele"
                                        type="text"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                                <div v-else>{{ avion.modele }}</div>
                            </td>
                            <td>
                                <div v-if="editingId === avion.id">
                                    <input
                                        v-model.number="form.capacite"
                                        type="number"
                                        min="1"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                                <div v-else>{{ avion.capacite }}</div>
                            </td>
                            <td class="text-end">
                                <template v-if="editingId === avion.id">
                                    <button
                                        class="btn btn-sm btn-primary me-2"
                                        @click="saveEdit(avion)"
                                    >
                                        {{ t('avions.save') }}
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-secondary"
                                        @click="cancelEdit"
                                    >
                                        {{ t('avions.cancel') }}
                                    </button>
                                </template>
                                <template v-else>
                                    <button
                                        class="btn btn-sm btn-outline-primary me-2"
                                        @click="startEdit(avion)"
                                    >
                                        {{ t('avions.edit') }}
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        @click="deleteAvion(avion)"
                                    >
                                        {{ t('avions.delete') }}
                                    </button>
                                </template>
                            </td>
                        </tr>
                        <tr v-if="!avions.length && !loading">
                            <td colspan="4" class="text-center text-muted">
                                {{ t('avions.empty') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { useI18n } from '../i18n'

export default {
    name: 'AvionsAdmin',
    setup() {
        const { t, lang, direction } = useI18n()
        return { t, lang, direction }
    },
    data() {
        return {
            avions: [],
            loading: false,
            error: null,
            success: null,
            editingId: null,
            form: {
                modele: '',
                capacite: 0,
            },
        }
    },
    created() {
        this.setAuthHeader()
        this.fetchAvions()
    },
    methods: {
        setAuthHeader() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common.Authorization = `Bearer ${token}`
            }
        },
        async fetchAvions() {
            this.loading = true
            this.error = null
            this.success = null

            try {
                const { data } = await axios.get('/api/avions')
                this.avions = data
            } catch (e) {
                this.error = this.t('avions.errorLoad')
            } finally {
                this.loading = false
            }
        },
        startEdit(avion) {
            this.editingId = avion.id
            this.form = {
                modele: avion.modele,
                capacite: avion.capacite,
            }
            this.success = null
            this.error = null
        },
        cancelEdit() {
            this.editingId = null
            this.form = { modele: '', capacite: 0 }
        },
        async deleteAvion(avion) {
            if (!window.confirm(this.t('avions.delete'))) return

            this.setAuthHeader()
            this.error = null
            this.success = null

            try {
                await axios.delete(`/api/avions/${avion.id}`)
                this.avions = this.avions.filter((a) => a.id !== avion.id)
                this.success = this.t('avions.successDelete')
            } catch (e) {
                this.error = this.t('avions.errorDelete')
            }
        },
        async saveEdit(avion) {
            if (!this.form.modele || !this.form.capacite) {
                this.error = this.t('avions.errorRequired')
                return
            }

            this.setAuthHeader()
            this.error = null

            try {
                const response = await axios.put(`/api/avions/${avion.id}`, {
                    modele: this.form.modele,
                    capacite: Number(this.form.capacite),
                })
                Object.assign(avion, response.data)
                this.success = this.t('avions.successUpdate')
                this.cancelEdit()
            } catch (e) {
                this.error = this.t('avions.errorUpdate')
            }
        },
    },
}
</script>
