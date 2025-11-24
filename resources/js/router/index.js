import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Dashboard from '../pages/Dashboard.vue'
import ListVols from '../components/ListVols.vue'
import AddVol from '../components/AddVol.vue'
import MyTickets from '../pages/MyTickets.vue'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/about', name: 'about', component: About },
    { path: '/login', name: 'login', component: Login, meta: { guest: true } },
    { path: '/register', name: 'register', component: Register, meta: { guest: true } },
    { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/vols', name: 'vols.index', component: ListVols },
    {
        path: '/vols/create',
        name: 'vols.create',
        component: AddVol,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: '/vols/:id/edit',
        name: 'vols.edit',
        component: AddVol,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    { path: '/tickets', name: 'tickets.index', component: MyTickets, meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')
    const rawUser = localStorage.getItem('user')
    let user = null

    if (rawUser) {
        try {
            user = JSON.parse(rawUser)
        } catch (e) {
            user = null
        }
    }

    if (to.meta.requiresAuth && !token) {
        return next({ name: 'login' })
    }

    if (to.meta.requiresAdmin && (!user || user.role !== 'admin')) {
        return next({ name: 'vols.index' })
    }

    if (to.meta.guest && token) {
        return next({ name: 'dashboard' })
    }

    return next()
})

export default router
