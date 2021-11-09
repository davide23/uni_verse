<template>
    <button :type="type" class="inline-flex items-center justify-center px-6 py-1.5 bg-yellow-400 rounded-lg text-sm font-bold text-center text-white">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>