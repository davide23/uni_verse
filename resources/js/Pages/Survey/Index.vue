<template>
    <survey-layout :mode="mode">
        <component
            :is="currentPageType"
            :currentPageType="currentPageType"

            v-model:currentVariable="currentVariable"
            v-model:currentPerson="currentPerson"
            v-model:answerValue="answerValue"
            v-model:survey="survey"
            :mode="mode"
            :respondent="respondent"

            @answer-question="update"

            :id="currentVariable.type"
            @go-next-question='update'
            @go-prev-question='update'
        >
            <div class="bg-white sticky bottom-0 md:relative md:bottom-auto z-10">
                <div class="progresbar flex row">
                    <button v-for="(page, index) in variables"  @click="update()" :key="index" class="flex-auto items-center h-1.5 opacity-30"  :class="'opacity-100 ml-1 mr-1'" />
                </div>
            </div>
        </component>
    </survey-layout>
</template>

<script>

    import Start from './Pages/Start.vue'
    import Finish from './Pages/Finish.vue'
    import Form from './Pages/Form.vue'
    import Location from './Pages/Location.vue'
    import SurveyLayout from '@/Layouts/SurveyLayout'
    import ButtonDefault from '../Components/ButtonDefault'
    import ButtonBack from '../Components/ButtonBack'

    export default {
        props: ['variables', 'people_variables', 'people', 'respondent_variables', 'respondent', 'survey', 'cid', 'pid'],
        components: {
            Start,
            Finish,
            Form,
            Location,
            SurveyLayout,
            ButtonDefault,
            ButtonBack
        },
        mounted() {
            if (this.people.length <= 0) {                     // did we pass all persons? Move on to finish..
                this.gotoFinish();
            }  else if(this.respondent_variables.length <= 0) {     // onboarding is already done, move on to survey
                this.gotoSurvey();
            } else {
                // Onboarding
                this.currentPageType = "form";
                this.currentVariable = this.respondent_variables[0];
            }
        },
        data() {
            return {
                mode: 'onboarding',
                currentVariable: false,
                currentPerson: false,
                currentPageType: false,
                form: {},
                answerValue: false,
            };
        },
        methods: {
            getCurrentPerson: function () {
                // If we answered all the questions for this person move to the next one.
                // The backend removes "finished" people, and shuffle the array if necessary.
                // Therefore this.people[0] is the right one to go.
                let currentPerson = this.currentPerson;
                if (!this.currentPerson || !this.people_variables[this.currentPerson.id].length > 0) {
                    currentPerson = this.people[0];
                }
                return currentPerson;
            },
            getCurrentVariable: function () {
                let variables = this.people_variables[this.currentPerson.id];
                if (variables.length === 0) {
                    this.gotoFinish();
                }
                return variables[0];
            },
            gotoSurvey: function() {
                this.mode = "survey";
                this.currentPageType = 'form';
                this.currentPerson = this.getCurrentPerson();
                this.currentVariable = this.getCurrentVariable();
            },
            gotoFinish: function() {
                this.mode = "finish";
                this.currentPageType = "finish";
            },
            update: function() {
                this.form._method = 'POST';
                this.form.mode = this.mode;
                this.form.value = this.answerValue;
                this.form.person_id = this.currentPerson.id;
                this.form.variable_name = this.currentVariable.name;
                this.$inertia.post('/survey/' + this.survey.slug , this.form, {
                    onSuccess: (page) => {
                        // check if there's any people left to curate
                        if (this.people.length <= 0)
                            this.gotoFinish();

                        else if(this.mode === "survey") {
                            this.currentPerson = this.getCurrentPerson();
                            this.currentVariable = this.getCurrentVariable();
                        }

                        else if (this.mode === "onboarding") {
                            if(this.respondent_variables.length <= 0) {
                                this.gotoSurvey();
                            } else {
                                this.currentVariable = this.respondent_variables[0];
                            }
                        }
                    },
                    onError: (errors) => {
                        console.log(errors);
                    },
                });
            },
        }
    }

</script>
