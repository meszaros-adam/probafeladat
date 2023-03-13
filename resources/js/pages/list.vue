<template>
    <pageContainer>
        <div class="d-flex container justify-content-end align-items-center">
            <filterProjects v-model="status"></filterProjects>
        </div>
        <div class="container list">
            <!-- pagination -->
            <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table" align="center">
            </b-pagination>
            <!-- pagination -->
            <transition-group name="project">
                <div v-for="project in projects" :key="project.id" class="project">
                    <router-link :to="{ name: 'project', params: { projectId: project.id } }">
                        <div>
                            <h3>Név: {{ project.name }}</h3>
                            <div>Leírás: {{ project.description }}</div>
                            <div>Státusz: {{ project.status }}</div>
                            <div>Kapcsolattartók száma: {{ project.contacts_count }}</div>
                            <div>Létrehozva: {{ project.created_at }}</div>
                        </div>
                    </router-link>
                </div>
            </transition-group>
            <!-- pagination -->
            <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table" align="center">
            </b-pagination>
            <!-- pagination -->
        </div>
    </pageContainer>
</template>

<script>
import { ref, watch } from 'vue'
import { callApi } from '../common/common.js'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
import filterProjects from '../partials/filterProjects.vue';
import pageContainer from '../partials/pageContainer.vue';
export default {
    components: { deleteButtonVue, filterProjects, pageContainer },
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