<template>
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Project hozzáadása!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Név:</label>
                            <input v-model="project.name" type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Leírás:</label>
                            <input v-model="project.description" type="text" class="form-control" id="description">
                        </div>
                        <div class="mb-3">
                            <select v-model="project.status" class="form-select">
                                <option selected>Státusz kiválasztása</option>
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
                                hozzáadása
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button>
                        <button @click="sendingProject" type="button" class="btn btn-primary">Project mentése!</button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    
}
</script>