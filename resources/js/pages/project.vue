<template>
    <pageContainer>
        <h1>{{ project }}</h1>
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
        const project = ref('')

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