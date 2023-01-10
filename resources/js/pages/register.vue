<template>
    <div class="container bg-dark text-white p-3 rounded">
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Teljes név</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="password-confirmation" class="form-label">Jelszó Megerősítés</label>
                <input type="password" class="form-control" id="password-confirmation">
            </div>
            <button class="btn btn-primary">Regisztráció</button>
        </form>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>