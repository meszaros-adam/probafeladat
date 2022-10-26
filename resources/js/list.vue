<template>
    <div class="container my-2">
        <div class="d-flex justify-content-between">
            <!-- Button Adding trigger modal -->
            <button type="button" class="btn btn-primary" @click="addingModal = true">
                Project hozzáadása!
            </button>
            <div>
                <div>Szűrés: </div>
                <select v-model="filterProjects" class="form-select">
                    <option value="null">Nincs</option>
                    <option value="waiting-for-development">Fejlesztésre vár</option>
                    <option value="in-progress">Folyamatban</option>
                    <option value="ready">Kész</option>
                </select>
            </div>
        </div>


        <div v-for="(project, p) in projects" :key="p" class="bg-primary rounded p-2 my-3">
            <div class="d-flex justify-content-between">
                <div>Név:{{ project.name }}</div>
                <div>Kapcsolattartók száma:{{ project.contacts_count }}</div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <div>Leírás: </div>
                    <div>{{ project.status }}</div>
                </div>
                <div>
                    <router-link :to="{ name: 'edit', params: { id: project.id } }">
                        <button type="button" class="btn btn-warning me-2">Szerkesztés</button>
                    </router-link>

                    <button @click="deleteProject(project.id, p)" type="button" class="btn btn-danger">Törlés</button>
                </div>
            </div>
        </div>
        <!-- pagination -->
        <b-pagination v-model="currentPage" :total-rows="total" :per-page="10" aria-controls="my-table">
        </b-pagination>
        <!-- pagination -->

        <!-- Adding Modal -->


        <b-modal v-model="addingModal" title="Projekt létrewhozása!" hide-footer>
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
                <div class="mb-3">
                    <div class="mb-3">Kapcsolattartó hozzáadása</div>
                    <div class="mb-3" v-for="(contact, c) in project.contacts" :key="c">
                        <span class="me-3">{{ contact.name }}</span>
                        <span>{{ contact.email }}</span>

                    </div>
                    <label for="contact-name" class="form-label">Név</label>
                    <input v-model="contact.name" type="text" class="form-control" id="contact-name">
                    <label for="contact-email" class="form-label">Email</label>
                    <input v-model="contact.email" type="email" class="form-control" id="contact-email">
                    <button @click="addContact" type="button" class="btn btn-primary mt-3">Kapcsolattartó
                        hozzáadása:
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                <button @click="sendingProject" type="button" class="btn btn-primary">Project mentése!</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import axios from 'axios'
export default {
    setup() {
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
            email: ''
        })

        const addContact = () => {
            project.value.contacts.push(contact.value)

            contact.value = {
                name: '',
                email: ''
            }
        }

        const sendingProject = async () => {
            try {
                const res = await axios({
                    method: 'post',
                    url: '/create_project',
                    data: project.value,
                })

                if (res.status == 201) {

                    projects.value.unshift(res.data)
                    addingModal.value = false

                    project.value = {
                        name: '',
                        description: '',
                        status: 'waiting-for-development',
                        contacts: [],
                    }
                }
            }
            catch (e) {
                return e.response
            }
        }

        //get projects

        const currentPage = ref(1)
        const total = ref(0)
        const projects = ref([])
        const filterProjects = ref(null)

        watch(currentPage, () => {
            getProjects()
        })

        watch(filterProjects, () => {
            getProjects()
        })

        const getProjects = async () => {
            try {
                const res = await axios({
                    method: 'get',
                    url: `/get_projects?page=${currentPage.value}&filter=${filterProjects.value}`,
                })

                if (res.status == 200) {
                    projects.value = res.data.data
                    total.value = res.data.total
                }
            }
            catch (e) {
                return e.response
            }
        }

        getProjects()

        //delete Project

        const deleteProject = async (id, index) => {
            try {
                const res = await axios({
                    method: 'post',
                    url: '/delete_project',
                    data: { id: id }
                })

                if (res.status == 200) {
                    projects.value.splice(index, 1)
                }
            }
            catch (e) {
                return e.response
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
        }

    }
}
</script>