<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Mes billets</h1>

            <div v-if="loading" class="text-center my-3">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">
                {{ error }}
            </div>

            <div v-else>
                <p v-if="tickets.length === 0" class="text-muted mb-0">
                    Vous n’avez encore aucun billet
                </p>

                <div v-else class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vol</th>
                                <th>Utilisateur</th>
                                <th>Quantité</th>
                                <th v-if="isAdmin" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ticket in tickets" :key="ticket.id">
                                <td>{{ ticket.id }}</td>
                                <td>{{ ticket.vol_id }}</td>
                                <td>{{ ticket.user_id }}</td>
                                <td>{{ ticket.quantite }}</td>
                                <td v-if="isAdmin" class="text-end">
                                    <button class="btn btn-sm btn-outline-warning me-1" @click="editTicket(ticket)">
                                        Modifier
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" @click="deleteTicket(ticket)">
                                        Supprimer
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

export default {
    name: 'MyTickets',
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
                    this.error = 'Accès refusé. Veuillez vous reconnecter pour voir vos billets.'
                } else {
                    this.error = 'Impossible de charger les billets.'
                }
            } finally {
                this.loading = false
            }
        },
        async editTicket(ticket) {
            const quantite = window.prompt('Quantité', ticket.quantite)
            if (quantite === null || quantite === '') return

            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                await axios.put(`/api/tickets/${ticket.id}`, { quantite: Number(quantite) })
                ticket.quantite = Number(quantite)
            } catch (e) {
                alert('Impossible de modifier le billet.')
            }
        },
        async deleteTicket(ticket) {
            if (!window.confirm('Supprimer ce billet ?')) return

            const token = localStorage.getItem('token')
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            }

            try {
                await axios.delete(`/api/tickets/${ticket.id}`)
                this.tickets = this.tickets.filter((t) => t.id !== ticket.id)
            } catch (e) {
                alert('Impossible de supprimer le billet.')
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

