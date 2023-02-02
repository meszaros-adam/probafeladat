<template>
    <div>
        <div class="d-flex container py-3 bg-dark justify-content-end align-items-center">
            <div class="d-flex align-items-center">
                <div class="text-white me-3">Szűrés: </div>
                <div>
                    <select v-model="filterProjects" class="form-select">
                        <option value="null">Nincs</option>
                        <option value="waiting-for-development">Fejlesztésre vár</option>
                        <option value="in-progress">Folyamatban</option>
                        <option value="ready">Kész</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="container">
            <div v-for="(project, p) in projects" :key="p" class="project">
                <div>
                    <h3>Név: {{ project.name }}</h3>
                    <div>Leírás: {{ project.description }}</div>
                    <div>Státusz: {{ project.status }}</div>
                    <div>Kapcsolattartók száma: {{ project.contacts_count }}</div>
                </div>
            </div>
            <!-- pagination -->
            <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table"
                align="center">
            </b-pagination>
            <!-- pagination -->
        </div>
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import { callApi } from '../common/common.js'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
export default {
    components: { deleteButtonVue },
    setup() {
        const toast = useToast();

        //get projects

        const currentPage = ref(1)
        const total = ref(0)
        const projects = ref([])
        const filterProjects = ref(null)

        watch(currentPage, () => {
            getProjects()
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })

        watch(filterProjects, () => {
            getProjects()
        })

        const getProjects = async () => {
            const res = await callApi('get', `/get_projects?page=${currentPage.value}&filter=${filterProjects.value}`)

            if (res.status == 200) {
                projects.value = res.data.data
                total.value = res.data.total
            }
        }

        getProjects()

        return {
            projects,
            currentPage,
            total,
            getProjects,
            filterProjects,
        }
    }
}
</script>