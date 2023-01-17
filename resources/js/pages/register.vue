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
import { useToast } from 'vue-toastification';
import { validateEmail } from '../common/common.js';
export default {
    setup() {
        const router = useRouter();
        const toast = useToast();

        const registerData = ref({
            fullName: '',
            email: '',
            password: '',
            password_confirmation: '',
        })

        const register = async () => {

            if (validateEmail(registerData.value.email.trim()) == false) return toast.warning('Érvényes email címet kell megadni!')
            if (registerData.value.fullName.trim().length < 5) return toast.warning('A név legalább 4 karakter legyen!')
            if (registerData.value.password.trim().length < 7) return toast.warning('A jelszó legalább 6 karakter kell legyen!')
            if (registerData.value.password.trim() != registerData.value.password_confirmation.trim()) return toast.warning('A jelszak nem egyeznek')

            const res = await callApi('post', '/register', registerData.value)

            if (res.status == 201) {
                router.push('/login')
                toast.success('Sikeres regisztráció!')
            } else {
                toast.error('A regisztráció sikertelen!')
            }
        }

        return { registerData, register }
    }
}
</script>

<style>

</style>