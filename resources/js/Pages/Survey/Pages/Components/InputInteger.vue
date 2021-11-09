<template>
  <div class="w-full">
    <label v-if="config.label" :for="config.id" class="opacity-30 border-b pb-3 mb-2 border-color-green-900 w-full flex text-xs tracking-wide leading-tight text-green-900">
      {{ config.label }}
    </label>
    <div class="flex">
      <span class="font-bold tracking-wide text-gray-700">
        &euro;
      </span>
      <input
        :id="config.id"
        type="number"
        :value="modelValue"
        :min="config.min" 
        :max="config.max" 
        @change="updateInput"
        :placeholder="config.placeholder"
        class="border-0 p-0 w-full text-base ml-1 font-bold tracking-wide text-gray-700 focus:ring-0"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "InputInteger",
  props: {
    config: {
      type: Object,
      default: "",
    },
    modelValue: {
      type: [Number],
      default: 100,
    },
  },
  methods: {
    updateInput(event) {
      // little delay on validation
      
        if(event.target.value != ""){
            if(parseInt(event.target.value) < parseInt(event.target.min)){
              event.target.value = event.target.min;
            }
          if(parseInt(event.target.value) > parseInt(event.target.max)){
            event.target.value = event.target.max;
          }
        }
        this.$emit("update:modelValue", parseInt(event.target.value));
      
    }
  }
};
</script>