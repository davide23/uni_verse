<template>
    <div class="flex flex-col min-h-screen">
        <MenuSurvey class="flex-grow-0 z-20" :mode="mode"></MenuSurvey>
        <main class="flex flex-col flex-grow">
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import MenuSurvey from './Components/MenuSurvey'

    export default {
        props: ['mode'],

        components: {
            MenuSurvey
        },

        data() {
            return {
                test: false,
            }
        },

        methods: {
            testFunction() {
               return test
            },
        }
    }
</script>
