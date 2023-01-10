import { createRouter, createWebHistory } from 'vue-router'
import edit from './pages/edit.vue'
import list from './pages/list.vue'
import login from './pages/login.vue'
import register from './pages/register.vue'

const routes = [
    {
        path: '/',
        name: 'list',
        component: list,
    },
    {
        path: '/edit-project/:id',
        name: 'edit',
        component: edit,
    },
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/register',
        name: 'register',
        component: register,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router