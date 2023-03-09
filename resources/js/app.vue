<template>
    <!-- NAV  -->
    <nav class="navbar">
        <div class="container d-flex justify-content-center text-white">
            <Transition name="bounce" appear>
                <router-link to="/" class="navbar-brand text-white mx-auto">
                    Projektkezelő!
                </router-link>
            </Transition>
            <div v-if="user">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ user.fullName }}
                    </button>
                    <ul class="dropdown-menu m-0">
                        <li><router-link to="/my-projects" class="dropdown-item">Projektjeim</router-link></li>
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
        <router-view v-slot="{ Component }">
            <transition name="fade" mode="out-in">
                <component :is="Component" />
            </transition>
        </router-view>
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
@import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap');

:root {
    --primaryColor: #372948;
}

body {
    background-color: #0f1108;
    font-family: 'Roboto Mono', monospace;
    font-weight: 900;
    min-height: 100vh;
}

.navbar {
    background-color: var(--primaryColor);
    border-bottom: 2px solid black;
}

.project {
    border-left: 10px solid var(--primaryColor);
    background-color: #212529;
    padding: 1rem;
    margin: 3rem 0rem;
    color: whitesmoke;
    animation: slide 2s ease-in-out 1s 1;
}

.auth .container {
    background-color: whitesmoke;
    border: 2px solid black;
}

.auth h1 {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 5px dashed var(--primaryColor);
}

.button {
    background-color: var(--primaryColor);
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

.active>.page-link {
    background-color: var(--primaryColor);
    border-color: black;
}

.btn {
    border-radius: 0;
}

.modal-content {
    background-color: whitesmoke;
    border-radius: 0;
}

.form-select,
.form-select option {
    border-radius: 0;
    font-weight: 900;
}

.form-control {
    border-radius: 0;
}

.btn,
.modal-title,
.dropdown-item,
.form-control {
    font-weight: 900;
}

/* Animated contacts list */
.contact-move,
.contact-enter-active,
.contact-leave-active {
    transition: all 0.5s ease;
}

.contact-enter-from,
.contact-leave-to {
    transform: translateX(-50px);
    opacity: 0;
}

.contact-leave-active {
    position: absolute;
}

/* Animated contacts list */

/* Animated projects list */
.project-move,
.project-enter-active,
.project-leave-active {
    transition: all 1s ease;
}

.project-enter-from {
    transform: translateX(-50px);
    opacity: 0;
}

.project-leave-to {
    transform: translateX(+50px);
    opacity: 0;
}

.project-leave-active {
    position: absolute;
}

/* Animated projects list */

/* bounce animation */
.bounce-enter-active {
    animation: bounce-in 1s;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.25);
    }

    100% {
        transform: scale(1);
    }
}

/* bounce animation */

/* fade animation */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease-out;
}

/* fade animation */

/* it styles router link */
a,
a :hover {
    color: whitesmoke;
    text-decoration: none;
}

.project:hover {
    transform: scale(1.1);
    transition: all 0.5s ease-out;
}

/* it styles router link */
</style>