<template>
    <div class="container py-3 text-white">
        <h1 class="mb-5">Projektjeim</h1>
        <button @click="addingModal = true" class="btn btn-dark">+ Projekt hozzáadása</button>
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
                    <div class="d-flex flex-column">
                        <router-link :to="{ name: 'edit', params: { id: project.id } }" class="mb-2">
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
        <!-- Adding Modal -->

        <!-- Delete Modal -->
        <b-modal v-model="deleteModal" title="Projekt törlése" hide-footer>
            <h1>Biztosan törölni akarod a projektet?</h1>
            <div class="modal-footer">
                <button type="button" class="button secondary" data-bs-dismiss="modal">Mégse</button>
                <button @click="deleteProject" type="button" class="button">Projekt Törlése!</button>
            </div>
        </b-modal>
        <!-- Delete Modal -->
    </div>

</template>

<script>
import { ref, watch } from 'vue';
import { callApi } from '../common/common'
import { useToast } from "vue-toastification";
import deleteButtonVue from '../partials/deleteButton.vue'
import { validateEmail } from '../common/common.js';
export default {
    components: { deleteButtonVue },
    setup() {
        const toast = useToast();

        //get projects

        const projects = ref([])

        const currentPage = ref(1)
        const total = ref(0)

        watch(currentPage, () => {
            getProjects()
            setTimeout(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 1000)
            //window.scrollTo({ top: 0, behavior: 'smooth' });
        })

        const getProjects = async () => {
            const res = await callApi('get', `/get-my-projects?page=${currentPage.value}`)

            if (res.status == 200) {
                projects.value = res.data.data
                total.value = res.data.total
            } else {
                toast.error('Nem sikerült betölteni a projekteket!')
            }
        }

        getProjects();

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

                addingModal.value = false

                projects.value.unshift(res.data)
                project.value = projectInitialValue()
                toast.success("Projekt sikeresen létrehozva!");
            } else {
                toast.error('Projekt létrehozása sikertelen!');
            }
        }

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
            project,
            contact,
            addingModal,
            addContact,
            removeContact,
            sendingProject,
            deleteModal,
            showDeleteModal,
            total,
            currentPage,
        }
    }
}
</script>
<style>
.project-enter-active,
.project-leave-active,
.project-move {
    transition: 0.4s ease all;
}

.project-enter-from,
.project-leave-to {
    opacity: 0;
    transform: scale(0.6);
}

.project-leave-active{
    position: absolute;
}
</style>