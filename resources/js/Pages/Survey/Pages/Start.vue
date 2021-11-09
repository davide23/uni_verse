<template>
        <div class="flex flex-auto flex-row items-center justify-center">

            <div class="">
                <ImageBackgroundWizardStart class="absolute bottom-0 w-full left-0"/>
                <div class="w-full max-w-xl mx-auto text-center py-12 px-4 sm:px-6 lg:py-16 lg:px-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <h2 class="text-5xl font-bold text-center text-gray-700 mb-10 w-2/3 md:w-full m-auto">
                        {{currentPage.copy.title}}
                    </h2>
                    <h3 class="text-base font-bold tracking-wide text-center text-gray-700 mb-10">
                        {{currentPage.copy.sub_title}}
                    </h3>
                    <p class="text-xs tracking-wide text-center text-gray-700">
                        {{currentPage.copy.intro}} <br>
                        <span>Wij zijn benieuwd!</span>
                    </p>
                    <div class="mt-8 flex justify-center">
                        <ButtonDefault href="#" @click="goNextPage()">
                        {{currentPage.copy.button}}
                        </ButtonDefault>
                    </div>
                </div>
            </div>
        </div>
</template>


<script>
    import ButtonDefault from '../../Components/ButtonDefault'
    import ImageBackgroundWizardStart from './Components/Images/ImageBackgroundWizardStart.vue'

    export default {
        props: ['currentPage','data'],
        components: {
            ButtonDefault,
            ImageBackgroundWizardStart
        },
        methods: {
            goNextPage: function() {
                this.$emit("go-next-page", this.currentPage);
            },
        }
    }
</script>