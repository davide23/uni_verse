<template>
        <div class="w-full h-screen flex flex-col lg:flex-row" >
            <div class="relative flex flex-col w-full h-2/6 lg:h-screen lg:h-screen bg-gray-100 h-screen">
                <div class="flex-auto flex justify-center flex-col md:overflow-auto h-auto z-10">
                    <div class="flex flex-col items-center justify-items-center h-auto px-2 lg:px-10">
                        <h2 v-html="survey.finish_page_title" class="text-xl lg:text-5xl text-center mb-4 font-semibold text-gray-900"></h2>
                        <p v-html="survey.finish_page_body" class="flex text-sm lg:text-xl mb-10 text-gray-800 text-center"></p>
                        <div class="flex flex-wrap space-x-2 items-start justify-center">
                            <a  v-if="respondent.status == 1" :href="'https://www.panelclix.com/nl/research/evaluation.html?pid='+respondent.pid+'&cid='+respondent.cid" class="rounded-2xl mb-2">
                                <div class="flex items-center justify-center flex-1 h-full px-2 lg:px-6 py-3 lg:py-4 bg-white border rounded-3xl border-gray-900 hover:bg-gray-900 text-gray-900 hover:text-white">
                                    <p class="text-sm lg:text-md font-bold tracking-wider leading-none ">GA VERDER</p>
                                </div>
                            </a>
                            <a v-if="respondent.status == 0" :href="'https://www.panelclix.com/nl/research/screenout.html?pid='+respondent.pid+'&cid='+respondent.cid" class="rounded-2xl mb-2">
                                <div class="flex items-center justify-center flex-1 h-full px-2 lg:px-6 py-3 lg:py-4 bg-white border rounded-3xl border-gray-900 hover:bg-gray-900 text-gray-900 hover:text-white">
                                    <p class="text-sm lg:text-md font-bold tracking-wider leading-none ">GA VERDER</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>


<script>
    import ButtonDefault from '../../Components/ButtonDefault'

    export default {
        props: ['currentPage', 'data', 'survey', 'respondent'],
        components: {
            ButtonDefault,
        },
        methods: {
            goNextPage: function() {
                this.$emit("go-next-page", this.currentPage);
            },
        }
    }
</script>

