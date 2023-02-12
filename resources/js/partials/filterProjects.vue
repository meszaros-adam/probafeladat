<template>
    <div class="d-flex align-items-center">
        <div class="text-white me-3">Szűrés: </div>
        <div>
            <select v-model="modelValue" @change="updateValue" class="form-select">
                <option value="null">Nincs</option>
                <option value="waiting-for-development">Fejlesztésre vár</option>
                <option value="in-progress">Folyamatban</option>
                <option value="ready">Kész</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    props: ['modelValue'],
    emits: ['update:modelValue'],
    setup(props, context) {

        const updateValue = (event) => {
            context.emit('update:modelValue', event.target.value)
        }

        return {
            updateValue
        }

    }
}
</script>