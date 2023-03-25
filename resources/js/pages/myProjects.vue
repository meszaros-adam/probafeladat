<template>
    <pageContainer>
        <h1 class="mb-5">Projektjeim</h1>
        <div class="d-flex container py-3 my-4 bg-dark justify-content-between align-items-center">
            <router-link to="/create-project">
                <button @click="addingModal = true" class="btn btn-light">+ Projekt hozzáadása</button>
            </router-link>
            <filterProjects v-model="status"></filterProjects>
        </div>
        <!-- pagination -->
        <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table" align="center">
        </b-pagination>
        <!-- pagination -->
        <transition-group name="project">
            <div v-for="project in projects" :key="project.id" class="bg-dark project">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>Név: {{ project.name }}</h3>
                        <div>Leírás: {{ project.description }}</div>
                        <div>Státusz: {{ project.status }}</div>
                        <div>Kapcsolattartók száma: {{ project.contacts_count }}</div>
                        <div>Létrehozva: {{ project.created_at }}</div>
                        <div>Frissítve: {{ project.updated_at }}</div>
                    </div>
                    <div class="d-flex flex-column justify-content-around">
                        <router-link class="mb-2" :to="{ name: 'project', params: { projectId: project.id } }">
                            <button title="Megtekintés" type="button" class="btn btn-success">
                                <i class="bi bi-arrow-up-right"></i>
                            </button>
                        </router-link>
                        <router-link class="mb-2" :to="{ name: 'edit', params: { id: project.id } }">
                            <button title="Szerkesztés" type="button" class="btn btn-warning">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </router-link>
                        <deleteButtonVue @click="showDeleteModal(project.id)"></deleteButtonVue>
                    </div>
                </div>
            </div>
        </transition-group>
        <!-- pagination -->
        <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table" align="center">
        </b-pagination>
        <!-- pagination -->

        <!-- Delete Modal -->
        <b-modal v-model="deleteModal" title="Projekt törlése" hide-footer>
            <h1>Biztosan törölni akarod a projektet?</h1>
            <div class="modal-footer">
                <button type="button" class="button secondary" data-bs-dismiss="modal">Mégse</button>
                <button @click="deleteProject" type="button" class="button">Projekt Törlése!</button>
            </div>
        </b-modal>
        <!-- Delete Modal -->
    </pageContainer>
</template>

<script>
import { ref, watch } from 'vue';
import { callApi } from '../common/common'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
import filterProjects from '../partials/filterProjects.vue';
import pageContainer from '../partials/pageContainer.vue';
export default {
    components: { deleteButtonVue, filterProjects, pageContainer },
    setup() {
        const toast = useToast();

        //get projects

        const projects = ref([])

        const status = ref(null)

        const currentPage = ref(1)
        const total = ref(0)

        watch(currentPage, () => {
            getProjects()

            //window.scrollTo({ top: 0, behavior: 'smooth' });

        })

        watch(status, () => {
            getProjects()
        })

        const getProjects = async () => {
            const res = await callApi('get', `/get-my-projects?page=${currentPage.value}&status=${status.value}`)

            if (res.status == 200) {
                projects.value = res.data.data
                total.value = res.data.total
            } else {
                toast.error('Nem sikerült betölteni a projekteket!')
            }
        }

        getProjects();

        //delete Project

        const deleteModal = ref(false)
        const deleteId = ref(null);

        const showDeleteModal = (id) => {
            deleteId.value = id
            deleteModal.value = true;
        }

        const deleteProject = async () => {
            const res = await callApi('post', '/delete_project', { id: deleteId.value })

            if (res.status == 200) {
                projects.value.splice(projects.value.findIndex(obj => obj.id == deleteId.value), 1)
                toast.success('Projekt sikeresen törölve!')
            } else {
                toast.error('Projekt törlése sikertelen!')
            }
            deleteModal.value = false
        }

        return {
            projects,
            deleteProject,
            deleteModal,
            showDeleteModal,
            total,
            currentPage,
            status,
        }
    }
}
</script>