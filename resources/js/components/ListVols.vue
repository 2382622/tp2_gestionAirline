<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <header
                class="d-flex justify-content-between align-items-center mb-3"
            >
                <div>
                    <h1 class="h4 mb-1">Vols disponibles</h1>
                </div>
                <RouterLink
                    v-if="isAdmin"
                    class="btn btn-success"
                    to="/vols/create"
                >
                    Ajouter un vol
                </RouterLink>
            </header>

            <div v-if="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status" />
            </div>

            <div v-else-if="error" class="alert alert-danger">
                {{ error }}
            </div>

            <div v-else>
                <div v-if="vols.length === 0" class="alert alert-info mb-0">
                    Aucun vol trouvé.
                </div>

                <div v-else class="tickets-grid">
                    <div
                        v-for="vol in vols"
                        :key="vol.id"
                        class="ticket-card"
                        :class="{ mine: vol.has_ticket }"
                    >
                        <div class="ticket-header">
                            <div>
                                <div class="ticket-code">{{ vol.id }}</div>
                                <div class="ticket-route">
                                    {{ vol.origine }} → {{ vol.destination }}
                                </div>
                            </div>
                            <span v-if="vol.has_ticket" class="badge bg-success"
                                >Mes billets</span
                            >
                        </div>

                        <div class="ticket-body">
                            <div class="ticket-line">
                                <small class="text-muted">Départ</small>
                                <span>{{ formatDate(vol.date_depart) }}</span>
                            </div>
                            <div class="ticket-line">
                                <small class="text-muted">Arrivée</small>
                                <span>{{ formatDate(vol.date_arrive) }}</span>
                            </div>
                            <div class="ticket-line">
                                <small class="text-muted">Prix</small>
                                <strong>{{ vol.prix }} $</strong>
                            </div>
                            <div class="ticket-line">
                                <small class="text-muted">Avion</small>
                                <span>
                                    <template v-if="vol.avion">
                                        {{ vol.avion.modele }} ({{
                                            vol.avion.capacite
                                        }}
                                        pl.)
                                    </template>
                                    <template v-else>—</template>
                                </span>
                            </div>
                            <div v-if="isAdmin" class="ticket-actions">
                                <RouterLink
                                    class="btn btn-sm btn-outline-warning me-2"
                                    :to="`/vols/${vol.id}/edit`"
                                >
                                    Modifier
                                </RouterLink>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteVol(vol.id)"
                                >
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
    name: "ListVols",
    components: { RouterLink },
    data() {
        return {
            vols: [],
            loading: false,
            error: null,
        };
    },
    created() {
        this.fetchVols();
    },
    computed: {
        isAdmin() {
            const raw = localStorage.getItem("user");
            if (!raw) return false;
            try {
                const user = JSON.parse(raw);
                return user && user.role === "admin";
            } catch (e) {
                return false;
            }
        },
    },
    methods: {
        async fetchVols() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get("/api/vols");
                this.vols = response.data;
            } catch (e) {
                this.error = "Impossible de charger les vols.";
            } finally {
                this.loading = false;
            }
        },
        formatDate(value) {
            if (!value) return "";
            return new Date(value).toLocaleString();
        },
        async deleteVol(id) {
            if (!window.confirm("Supprimer ce vol ?")) return;

            const token = localStorage.getItem("token");
            if (token) {
                axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            }

            try {
                await axios.delete(`/api/vols/${id}`);
                this.vols = this.vols.filter((v) => v.id !== id);
            } catch (e) {
                alert("Impossible de supprimer le vol.");
            }
        },
    },
};
</script>

<style scoped>
.tickets-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}

.ticket-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px 16px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.12s ease, box-shadow 0.12s ease;
}

.ticket-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.ticket-card.mine {
    border-color: #22c55e;
    box-shadow: 0 6px 16px rgba(34, 197, 94, 0.12);
}

.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.ticket-code {
    font-weight: 800;
    font-size: 1.05rem;
}

.ticket-route {
    color: #6b7280;
    font-size: 0.95rem;
}

.ticket-body {
    display: grid;
    gap: 6px;
}

.ticket-line {
    display: flex;
    justify-content: space-between;
    font-size: 0.95rem;
}

.ticket-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 8px;
}
</style>
