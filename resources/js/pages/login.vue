<template>
    <div class="container bg-dark text-white p-3 rounded">
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="stay-logged-in">
                <label class="form-check-label" for="stay-logged-in">Maradjak bejelentkezve</label>
            </div>
            <button class="btn btn-primary">Bejelentkezés</button>
        </form>
    </div>
</template>

<script>
export default {
    setup() {

    }
}
</script>

<style scoped>

</style>