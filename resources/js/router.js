import { createRouter, createWebHistory } from 'vue-router'
import edit from './pages/edit.vue'
import list from './pages/list.vue'

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
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router