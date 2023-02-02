<template>
    <div class="container py-3 text-white">
        <h1 class="mb-5">Projektjeim</h1>
        <button @click="addingModal = true" class="btn btn-dark">+ Projekt hozzáadása</button>
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
                    <div class="mb-3 d-flex justify-content-between align-items-center bg-primary p-1"
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
import { ref } from 'vue';
import { callApi } from '../common/common'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
import { validateEmail } from '../common/common.js';
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

        //adding project
        const addingModal = ref(false)

        const projectInitialValue = () => {
            return {
                name: '',
                description: '',
                status: 'waiting-for-development',
                contacts: [],
            }
        }

        const project = ref(projectInitialValue())

        const contactInitialValue = () => {
            return {
                name: '',
                email: '',
            }
        }

        const contact = ref(contactInitialValue())

        const addContact = () => {
            if (!validateEmail(contact.value.email)) return toast.error('Érvényes email címet kell megadni!')

            project.value.contacts.push(contact.value)

            contact.value = contactInitialValue()
        }

        const removeContact = (index) => {
            project.value.contacts.splice(index, 1)
        }

        const sendingProject = async () => {

            const res = await callApi('post', '/create_project', project.value)

            if (res.status == 201) {

                projects.value.unshift(res.data)
                addingModal.value = false

                project.value = projectInitialValue()

                toast.success("Projekt sikeresen létrehozva!");
            } else {
                toast.error('Projekt létrehozása sikertelen!');
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

        return {
            projects,
            deleteProject,
            project,
            contact,
            addingModal,
            addContact,
            removeContact,
            sendingProject,
        }
    }
}
</script>