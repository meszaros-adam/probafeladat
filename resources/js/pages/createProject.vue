<template>
    <div>
        <pageContainer v-if="project" class="bg-dark">
            <h1>Project létrehozása: </h1>
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
                    <option selected value="waiting-for-development">Fejlesztésre vár</option>
                    <option value="in-progress">Folyamatban</option>
                    <option value="ready">Kész</option>
                </select>
            </div>
            <div class="mb-3  border-top">
                <h3 class="mb-3">Kapcsolattartók:</h3>
                <transition-group name="contact">
                    <div class="mb-3 bg-primary p-1 d-flex text-white justify-content-between align-items-center"
                        v-for="(contact, c) in project.contacts" :key="contact">
                        <div>
                            <span class="me-3">{{ contact.name }}</span>
                            <span>{{ contact.email }}</span>
                        </div>
                        <deleteButtonVue @click="removeContact(c)"></deleteButtonVue>
                    </div>
                </transition-group>
            </div>
            <div class="mb-3  border-top">
                <h3>Kapcsolattartó hozzáadása: </h3>
                <label for="contact-name" class="form-label">Név</label>
                <input v-model="contact.name" type="text" class="form-control" id="contact-name">
                <label for="contact-email" class="form-label">Email</label>
                <input v-model="contact.email" type="email" class="form-control" id="contact-email">
                <button @click="addContact" type="button" class="button mt-3">
                    <i class="bi bi-plus-lg"></i>
                    <span>Kapcsolattartó hozzáadása</span>
                </button>
            </div>
            <hr>
            <div class="text-end">
                <button @click="sendingProject" type="button" class="button">Mentés</button>
            </div>
        </pageContainer>
    </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { callApi } from '../common/common'
import { useToast } from "vue-toastification";
import { validateEmail } from '../common/common.js';
import deleteButtonVue from '../partials/deleteButton.vue'
import pageContainer from '../partials/pageContainer.vue';
export default {
    components: { deleteButtonVue, pageContainer },
    setup() {
        const toast = useToast()
        const router = useRouter()

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
            if (contact.value.name.trim().length < 4) return toast.error('A kapcsolat neve legalább 4 karakter legyen!')
            if (!validateEmail(contact.value.email)) return toast.error('Érvényes email címet kell megadni!')

            project.value.contacts.unshift(contact.value)
            contact.value = contactInitialValue()
        }

        const removeContact = (index) => {
            project.value.contacts.splice(index, 1)
        }

        const sendingProject = async () => {

            const res = await callApi('post', '/create_project', project.value)

            if (res.status == 201) {

                addingModal.value = false
                project.value = projectInitialValue()
                toast.success("Projekt sikeresen létrehozva!");
                router.push('/my-projects')
            } else {
                toast.error('Projekt létrehozása sikertelen!');
            }
        }

        //contributorAdding

        const contributorAdding = ref(false)

        return {
            project,
            contact,
            addContact,
            removeContact,
            sendingProject,
            contributorAdding,
        }
    }
}
</script>