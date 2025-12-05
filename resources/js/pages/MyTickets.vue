<template>
    <div class="card shadow-sm" :dir="direction" :lang="lang">
        <div class="card-body">
            <h1 class="h4 mb-3">{{ t('tickets.title') }}</h1>

            <div v-if="loading" class="text-center my-3">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">
                {{ error }}
            </div>

            <div v-else>
                <p v-if="tickets.length === 0" class="text-muted mb-0">
                    {{ t('tickets.empty') }}
                </p>

                <div v-else class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ t('tickets.columns.id') }}</th>
                                <th>{{ t('tickets.columns.flight') }}</th>
                                <th>{{ t('tickets.columns.user') }}</th>
                                <th>{{ t('tickets.columns.quantity') }}</th>
                                <th class="text-end">{{ t('tickets.columns.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ticket in tickets" :key="ticket.id">
                                <td>{{ ticket.id }}</td>
                                <td>{{ ticket.vol_id }}</td>
                                <td>{{ ticket.user_id }}</td>
                                <td>{{ ticket.quantite }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary me-1" @click="removeOne(ticket)">
                                        Supprimer 1
                                    </button>
                                    <button
                                        v-if="isAdmin"
                                        class="btn btn-sm btn-outline-warning me-1"
                                        @click="editTicket(ticket)"
                                    >
                                        {{ t('listVols.modifier') }}
                                    </button>
                                    <button
                                        v-if="isAdmin"
                                        class="btn btn-sm btn-outline-danger"
                                        @click="deleteTicket(ticket)"
                                    >
                                        {{ t('listVols.supprimer') }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { useI18n } from '../i18n'

export default {
    name: 'MyTickets',
    setup() {
        const { t, lang, direction } = useI18n()
        return { t, lang, direction }
    },
    data() {
        return {
            tickets: [],
            loading: false,
            error: null,
            user: null,
        }
    },
    created() {
        const storedUser = localStorage.getItem('user')
        if (storedUser) {
            this.user = JSON.parse(storedUser)
        }
        this.fetchTickets()
    },
    methods: {
        async fetchTickets() {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            this.loading = true
            this.error = null

            try {
                const response = await axios.get('/api/tickets')
                this.tickets = response.data
            } catch (e) {
                if (e.response && e.response.status === 401) {
                    this.error = this.t('tickets.errors.access')
                } else {
                    this.error = this.t('tickets.errors.load')
                }
            } finally {
                this.loading = false
            }
        },
        async editTicket(ticket) {
            const quantite = window.prompt(this.t('tickets.editPrompt'), ticket.quantite)
            if (quantite === null || quantite === '') return

            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                await axios.put(`/api/tickets/${ticket.id}`, { quantite: Number(quantite) })
                ticket.quantite = Number(quantite)
            } catch (e) {
                alert(this.t('tickets.editError'))
            }
        },
        async deleteTicket(ticket) {
            if (!window.confirm(this.t('tickets.deleteConfirm'))) return

            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                await axios.delete(`/api/tickets/${ticket.id}`)
                this.tickets = this.tickets.filter((t) => t.id !== ticket.id)
            } catch (e) {
                alert(this.t('tickets.deleteError'))
            }
        },
        async removeOne(ticket) {
            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                if (ticket.quantite > 1) {
                    const nouvelleQuantite = ticket.quantite - 1
                    await axios.put(`/api/tickets/${ticket.id}`, { quantite: nouvelleQuantite })
                    ticket.quantite = nouvelleQuantite
                } else {
                    await axios.delete(`/api/tickets/${ticket.id}`)
                    this.tickets = this.tickets.filter((t) => t.id !== ticket.id)
                }
            } catch (e) {
                alert(this.t('tickets.deleteError'))
            }
        },
    },
    computed: {
        isAdmin() {
            return this.user && this.user.role === 'admin'
        },
    },
}
</script>
