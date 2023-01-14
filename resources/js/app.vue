<template>
    <!-- NAV  -->
    <nav class="navbar bg-dark">
        <div class="container text-white">
            <router-link to="/" class="navbar-brand text-white mx-auto">
                Projektkezelő!
            </router-link>
            <div v-if="user">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ user.fullName }}
                    </button>
                    <ul class="dropdown-menu m-0">
                        <li @click="logout"><a class="dropdown-item" href="#">Kijelentkezés</a></li>
                    </ul>
                </div>
            </div>
            <div v-else>
                <router-link to="/login" class="navbar-brand text-white mx-auto">
                    Bejelentkezés
                </router-link>
                <router-link to="/register" class="navbar-brand text-white mx-auto">
                    Regisztráció
                </router-link>
            </div>
        </div>
    </nav>
    <!-- NAV -->
    <!-- ROUTER -->
    <div class="my-3">
        <router-view> </router-view>
    </div>
    <!-- ROUTER -->
</template>

<script>
import { ref } from 'vue'
import { callApi } from './common/common'
export default {
    props: ['user'],
    setup(props) {

        const logout = async () => {
            const res = await callApi('get', '/logout')

            if (res.status == 200) {
                window.location = '/';
            } else {
                console.log('Logout failed!')
            }
        }
        return { logout }
    }
}
</script>

<style>
body {
    background-color: #372948;
    font-family: cursive;
    min-height: 100vh;
}

.project {
    border-left: 10px solid #FED766;
}

.auth .container {
    background-color: whitesmoke;
    border: 2px solid black;
}

.auth h1 {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 5px dashed #372948;
}

.button {
    background-color: #372948;
    color: whitesmoke;
    padding: 0.5rem;
}

.button:hover {
    background-color: #674f85
}

.button.secondary {
    background-color: grey;
}

.button.secondary:hover {
    background-color: whitesmoke;
    color: grey;
}
</style>