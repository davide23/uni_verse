<template>
    <div>
      <label class="typo__label">{{label}}</label>
      <Multiselect
        v-model="modelValue"
        @change="updateInput"
        label="name" 
        valueProp="code"
        track-by="code" 
        :options="options" 
        :searchable="true"
        mode="tags"
      />
  </div>
</template>

<script>
  import Multiselect from '@vueform/multiselect'

  export default {
    components: {
      Multiselect,
    },
    props: ['label','options', 'modelValue'],    
    methods: {
      updateInput(value) {
        this.$emit("update:modelValue",value);
        this.$emit("change");
      }
    }
  }
</script>

<style src="@vueform/multiselect/themes/default.css"></style>