<template>
    <!-- NAV  -->
    <nav class="navbar bg-dark">
        <div class="container">
            <router-link to="/" class="navbar-brand text-white mx-auto">
                Projektkezelő!
            </router-link>
            <router-link to="/login" class="navbar-brand text-white mx-auto">
                Bejelentkezés
            </router-link>
            <router-link to="/register" class="navbar-brand text-white mx-auto">
                Regisztráció
            </router-link>
        </div>
    </nav>
    <!-- NAV -->
    <!-- ROUTER -->
    <div class="my-3">
        <router-view> </router-view>
    </div>
    <!-- ROUTER -->
</template>

<style>

</style>