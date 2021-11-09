<template>
        <input class="search-input py-3 pl-16 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 placeholder-gray-400 w-48" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

<style lang="scss">
.search-input {
    background-image: url(/icons/search.svg);
    background-position: 12% center;
    background-repeat: no-repeat;
    border: 0;
}
</style>

