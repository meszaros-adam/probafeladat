import { createRouter, createWebHistory } from 'vue-router'
import editProject from './pages/editProject.vue'
import list from './pages/list.vue'
import login from './pages/login.vue'
import register from './pages/register.vue'
import myProjects from './pages/myProjects.vue'
import project from './pages/project.vue'
import createProject from './pages/createProject.vue'

const routes = [
    {
        path: '/',
        name: 'list',
        component: list,
    },
    {
        path: '/edit-project/:id',
        name: 'edit',
        component: editProject,
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
    {
        path: '/my-projects',
        name: 'myProjects',
        component: myProjects,
    },
    {
        path: '/projects/:projectId',
        name: 'project',
        component: project,
    },
    {
        path: '/create-project',
        name: 'createProject',
        component: createProject
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router