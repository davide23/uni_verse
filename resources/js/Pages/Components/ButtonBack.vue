<template>
    <button :type="type" class="inline-flex items-center justify-center px-6 py-1.5 bg-gray-200 rounded-lg text-sm font-bold text-center text-white">
            <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.2094 2.19688L4.90625 7.50001L10.2094 12.8031L11.0938 11.9194L6.67375 7.50001L11.0938 3.08063L10.2094 2.19688Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2091 1.4899L11.8008 3.08053L7.38074 7.50001L11.8008 11.9195L10.2091 13.5101L4.19897 7.50001L10.2091 1.4899ZM6.67358 7.50001L11.0936 3.08063L10.2092 2.19688L4.90608 7.50001L10.2092 12.8031L11.0936 11.9194L6.67358 7.50001Z" fill="white"/>
            </svg>
        &nbsp;&nbsp;<slot></slot>
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