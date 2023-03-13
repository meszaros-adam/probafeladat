<template>
    <div class="auth container py-3 text-dark">
        <slot />
    </div>
</template>

<style>
.auth {
    background-color: whitesmoke;
    border: 2px solid black;
}

.auth h1 {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 5px dashed var(--primaryColor);
}
</style>