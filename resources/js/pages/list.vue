<template>
    <div>
        <div class="d-flex container py-3 bg-dark justify-content-between align-items-center">
            <!-- Button Adding trigger modal -->
            <div>
                <button class="button" @click="addingModal = true">
                    <i class="bi bi-plus-lg"></i>
                    <span>Project hozzáadása</span>
                </button>
            </div>
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
            <div v-for="(project, p) in projects" :key="p" class="bg-dark text-white p-2 my-3 project">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>Név: {{ project.name }}</h3>
                        <div>Leírás: {{ project.description }}</div>
                        <div>Státusz: {{ project.status }}</div>
                        <div>Kapcsolattartók száma: {{ project.contacts_count }}</div>
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
            <!-- pagination -->
            <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table"
                align="center">
            </b-pagination>
            <!-- pagination -->
        </div>



        <!-- Adding Modal -->
        <b-modal v-model="addingModal" title="Projekt létrehozása!" hide-footer>
            <div>
                <div class="mb-3">
                    <label for="name" class="form-label">Név:</label>
                    <input v-model="project.name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Leírás:</label>
                    <input v-model="project.description" type="text" class="form-control" id="description">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Státusz:</label>
                    <select v-model="project.status" class="form-select">
                        <option value="waiting-for-development">Fejlesztésre vár</option>
                        <option value="in-progress">Folyamatban</option>
                        <option value="ready">Kész</option>
                    </select>
                </div>
                <div class="mb-3 border-top">
                    <div class="mb-3">Kapcsolattartók listája: </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center bg-primary p-1 rounded"
                        v-for="(contact, c) in project.contacts" :key="c">
                        <span class="me-3">{{ contact.name }}</span>
                        <span>{{ contact.email }}</span>
                        <deleteButtonVue @click="removeContact(c)"></deleteButtonVue>
                    </div>
                </div>
                <div class="mb-3 border-top">
                    <label for="contact-name" class="form-label">Név</label>
                    <input v-model="contact.name" type="text" class="form-control" id="contact-name">
                    <label for="contact-email" class="form-label">Email</label>
                    <input v-model="contact.email" type="email" class="form-control" id="contact-email">
                    <button @click="addContact" type="button" class="button mt-3">
                        <i class="bi bi-plus-lg"></i>
                        <span>Kapcsolattartó hozzáadása</span>
                    </button>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="button secondary" data-bs-dismiss="modal">Mégse</button>
                <button @click="sendingProject" type="button" class="button">Projekt mentése!</button>
            </div>
        </b-modal>
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

        //adding project
        const addingModal = ref(false)

        const project = ref({
            name: '',
            description: '',
            status: 'waiting-for-development',
            contacts: [],
        })

        const contact = ref({
            name: '',
            email: '',
        })

        const addContact = () => {
            project.value.contacts.push(contact.value)

            contact.value = {
                name: '',
                email: ''
            }
        }

        const removeContact = (index) => {
            project.value.contacts.splice(index, 1)
        }

        const sendingProject = async () => {
            const res = await callApi('post', '/create_project', project.value)

            if (res.status == 201) {

                projects.value.unshift(res.data)
                addingModal.value = false

                project.value = {
                    name: '',
                    description: '',
                    status: 'waiting-for-development',
                    contacts: [],
                }
                toast.success("Projekt sikeresen létrehozva!");
            }else{
                toast.success('Projekt létrehozása sikertelen!');
            }
        }

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

        //delete Project

        const deleteProject = async (id, index) => {
            const res = await callApi('post', '/delete_project', { id: id })

            if (res.status == 200) {
                projects.value.splice(index, 1)
            }
        }

        return {
            project,
            contact,
            addContact,
            sendingProject,
            projects,
            currentPage,
            deleteProject,
            total,
            getProjects,
            filterProjects,
            addingModal,
            removeContact,
        }
    }
}
</script>