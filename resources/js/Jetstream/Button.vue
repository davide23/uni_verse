<template>
    <button :type="type" class="text-center inline-flex items-center justify-center px-4 py-3 bg-blue-400 border border-transparent font-extrabold text-white tracking-widest hover:opacity-90 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
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
