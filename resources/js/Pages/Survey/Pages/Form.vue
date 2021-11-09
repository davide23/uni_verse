<template>
        <div class="w-full h-screen flex flex-col lg:flex-row" >
            <component v-bind:is="currentMode" :currentPerson="currentPerson" v-if="currentPerson" />
            <div class="relative flex flex-col w-full h-2/6 lg:h-screen lg:h-screen bg-gray-100" :class="[mode == 'survey' ? 'lg:w-1/2' : 'h-screen']">
                <div class="flex-auto flex justify-center flex-col md:overflow-auto h-auto z-10">
                    <div class="flex flex-col items-center justify-items-center h-auto px-2 lg:px-10">
                        <h2  class="text-xl lg:text-4xl text-center mb-8 font-semibold text-gray-900">{{ buildQuestion(currentPerson, currentVariable) }}</h2>

                            <SelectDefault v-if="currentVariable.question_type != 'custom_select_multiple'" :key="currentVariable" @clickAnswer='answerQuestion' :config="{options: getAnswerOptions(currentVariable) }"/>
                            <MultiSelect v-if="currentVariable.question_type == 'custom_select_multiple'" :key="currentVariable" @clickAnswer='answerQuestion' :config="{options: getAnswerOptions(currentVariable) }"/>

                    </div>
                </div>
                <slot></slot>
            </div>
        </div>
</template>


<script>
    import SelectDefault from './Components/SelectDefault.vue'
    import MultiSelect from './Components/MultiSelect.vue'

    import SidepanelPerson from './Components/Sidepanel/Person.vue'

    export default {
        props: ['currentPageType', 'currentVariable', 'currentPerson', 'answerValue','mode'],
        components: {
            SelectDefault,
            MultiSelect,
            SidepanelPerson,
        },
        data() {
            return {
                currentMode: 'SidepanelPerson',
            };
        },
        methods: {
            getAnswerOptions: function (variable) {
                if (variable.randomize_options){
                    return this.shuffle(variable.answer_options);
                }
                return variable.answer_options;
            },
            shuffle: function (numbers) {
                var keys = Object.keys(numbers);
                keys.sort(function(a,b) {return Math.random() - 0.5;});
                return keys;
            },
            buildQuestion: function (person, variable) {
                if(this.mode === "survey")
                    return variable.question.replace("<variable>", variable.name).replace("<person>", person.name);
                else
                    return variable.question.replace("<variable>", variable.name).replace("<person>", "");
            },
            answerQuestion: function (value) {
                // check if it's an object where we need to use the keys as value, or just a simple array with the values ready for sending.
                if(typeof JSON.parse(JSON.stringify(this.currentVariable.answer_options)) === 'object' && this.currentVariable.question_type != 'custom_select_multiple') {
                    value = Object.keys(this.currentVariable.answer_options).find(key => this.currentVariable.answer_options[key] === value);
                    this.$emit("update:answerValue",  value);
                } else {
                    this.$emit("update:answerValue", JSON.stringify(value));  // not sure if this is going to hate me, the stringify.. for multiplechoice
                }
                this.$emit("answer-question",);
            },
        }
    }
</script>
