<template>
    <div class="auth">
        <div class="container p-3">
            <h1>Regisztráció</h1>
            <div class="mb-3">
                <label for="name" class="form-label">Teljes név</label>
                <input v-model="registerData.fullName" type="text" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input v-model="registerData.email" type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input v-model="registerData.password" type="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="password-confirmation" class="form-label">Jelszó Megerősítés</label>
                <input v-model="registerData.password_confirmation" type="password" class="form-control"
                    id="password-confirmation">
            </div>
            <button @click="register" class="button">Regisztráció</button>
        </div>
    </div>
</template>

<script>
import { ref } from '@vue/reactivity'
import { callApi } from '../common/common.js'
import { useRouter } from 'vue-router';
export default {
    setup() {
        const router = useRouter();

        const registerData = ref({
            fullName: '',
            email: '',
            password: '',
            password_confirmation: '',
        })

        const register = async () => {
            const res = await callApi('post', '/register', registerData.value)

            if (res.status == 201) {
                router.push('/login')
            } else {
                console.log(res.data)
            }
        }

        return { registerData, register }
    }
}
</script>

<style>

</style>