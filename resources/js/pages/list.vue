<template>
    <div>
        <div class="d-flex container py-3 my-4 bg-dark justify-content-end align-items-center">
            <filterProjects v-model="status"></filterProjects>
        </div>
        <div class="container">
            <!-- pagination -->
            <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table"
                align="center">
            </b-pagination>
            <!-- pagination -->
            <div v-for="(project, p) in projects" :key="p" class="project">
                <div>
                    <h3>Név: {{ project.name }}</h3>
                    <div>Leírás: {{ project.description }}</div>
                    <div>Státusz: {{ project.status }}</div>
                    <div>Kapcsolattartók száma: {{ project.contacts_count }}</div>
                    <div>Létrehozva: {{ project.created_at }}</div>
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
import filterProjects from '../partials/filterProjects.vue';
export default {
    components: { deleteButtonVue, filterProjects},
    setup() {
        const toast = useToast();

        //get projects

        const currentPage = ref(1)
        const total = ref(0)
        const projects = ref([])
        //filter by status
        const status = ref(null)

        watch(currentPage, () => {
            getProjects()
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })

        watch(status, () => {
            getProjects()
        })

        const getProjects = async () => {
            const res = await callApi('get', `/get_projects?page=${currentPage.value}&status=${status.value}`)

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
            status,
        }
    }
}
</script>