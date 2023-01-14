<template>
    <div class="auth">
        <div class="container p-3">
            <h1>Bejelentkezés</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input v-model="loginData.email" type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input v-model="loginData.password" type="password" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
                <input v-model="loginData.remember" type="checkbox" class="form-check-input" id="stay-logged-in">
                <label class="form-check-label" for="stay-logged-in">Maradjak bejelentkezve</label>
            </div>
            <button @click="login" class="button">Bejelentkezés</button>
        </div>
    </div>
</template>

<script>
import { ref } from '@vue/reactivity';
import { callApi } from '../common/common';
export default {
    setup() {
        const loginData = ref({
            email: '',
            password: '',
            remember: false,
        })
        const login = async () => {
            const res = await callApi('post', '/login', loginData.value)

            if (res.status == 200) {
                window.location = '/';
            } else {
                console.log('login failed')
            }
        }

        return { loginData, login }
    }
}
</script>

<style scoped>

</style>