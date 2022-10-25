import { createRouter, createWebHistory } from 'vue-router'
import edit from './edit.vue'
import list from './list.vue'

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