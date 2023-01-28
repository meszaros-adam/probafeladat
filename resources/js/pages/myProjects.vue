<template>
    <div class="container py-3 text-white">
        <h1 class="mb-5">Projektjeim</h1>
        <div v-for="(project, p) in projects" :key="p" class="bg-dark project">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>Név: {{ project.name }}</h3>
                    <div>Leírás: {{ project.description }}</div>
                    <div>Státusz: {{ project.status }}</div>
                    <div>Létrehozva: {{ project.created_at }}</div>
                    <div>Frissítve: {{ project.updated_at }}</div>
                </div>
                <div>
                    <router-link :to="{ name: 'edit', params: { id: project.id } }">
                        <button title="Szerkesztés" type="button" class="btn btn-warning me-2">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </router-link>
                    <deleteButtonVue @click="deleteProject(project.id, p)"></deleteButtonVue>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { ref } from 'vue';
import { callApi } from '../common/common'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
export default {
    components: { deleteButtonVue },
    setup() {
        const toast = useToast();

        const projects = ref([])

        const getProjects = async () => {
            const res = await callApi('get', '/get-my-projects')

            if (res.status == 200) {
                projects.value = res.data.data
            } else {
                toast.error('Nem sikerült betölteni a projekteket!')
            }
        }

        
        //delete Project

        const deleteProject = async (id, index) => {
            const res = await callApi('post', '/delete_project', { id: id })

            if (res.status == 200) {
                projects.value.splice(index, 1)
            }
        }

        getProjects();

        return { projects, deleteProject}
    }
}
</script>