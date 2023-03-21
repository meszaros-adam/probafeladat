<template >
    <pageContainer v-if="project">
        <div class="d-flex justify-content-between mb-5">
            <div>Tulajdonos: {{ project.owner.fullName }}</div>
            <div class="d-flex flex-column">
                <div>Létrehozva: {{ project.created_at }}</div>
                <div>Módosítva: {{ project.updated_at }}</div>
            </div>
        </div>
        <transition name="project-name" appear>
            <h1 class="mb-5 project-name">{{ project.name }}</h1>
        </transition>
        <hr>
        <p>Leírás: {{ project.description }}</p>
        <div>Státusz: {{ project.status }}</div>
        <button class="btn btn-primary my-3" type="button" data-bs-toggle="collapse" data-bs-target="#contacts">
            Kapcsolatok
        </button>
        <div class="collapse" id="contacts">
            <div class="card card-body text-dark my-3">
                <div v-for="contact in project.contacts" :key="contact.id">
                    <div>Name: {{ contact.name }}</div>
                    <div>Email: {{ contact.email }}</div>
                    <hr>
                </div>
            </div>
        </div>
    </pageContainer>
</template>

<script>
import { ref } from 'vue';
import { callApi } from '../common/common';
import { useRoute } from 'vue-router'
import { useToast } from "vue-toastification";
import pageContainer from '../partials/pageContainer.vue';
export default {
    components: { pageContainer },
    setup() {
        const route = useRoute()
        const toast = useToast()

        //load project
        const project = ref(null)

        const getProject = async () => {
            const res = await callApi('get', `/get_single_project?id=${route.params.projectId}`)

            if (res.status == 200) {
                project.value = res.data
            } else {
                toast.error('Projekt betöltése sikertelen!')
            }
        }

        getProject()

        return { project }
    }
}
</script>

<style scoped>
.project-name-enter-active {
    transition: all 0.5s ease-out;
}

.container {
    background-color: var(--containerBackground);
}

.project-name-enter-from {
    transform: translateX(-50%);
    opacity: 0;
}
</style>