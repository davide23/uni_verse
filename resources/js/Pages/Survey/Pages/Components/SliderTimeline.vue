<template>
  <div class="w-full">
    <label v-if="config.label" :for="config.id" class="opacity-30 border-b pb-3 mb-2 border-green-900 w-full flex text-xs tracking-wide leading-tight text-green-900">
      {{ config.label }}
    </label>
    <div class="relative mt-6">
      <vue3-slider 
        @change="updateInput" 
        disabled="disabled" 
        v-model="value" 
        :tooltip="true" 
        :min="config.min" 
        :max="config.max" 
        class="pt-5"
        :class="[disabled ? 'handle-disabled' : '']"
      />
      <div class="vertical-slide"/>   
      <div class="w-full flex flex-row justify-between mt-5">
        <div class="flex text-xs tracking-wide leading-tight text-green-900">{{ config.label_min }}</div>
        <div class="flex text-xs tracking-wide leading-tight text-green-900">{{ config.label_max }}</div>
      </div>
      <div class="w-full flex flex-row justify-between mt-4">
            <input
              type="checkbox"
              :value="value"
              @change="updateInputToZero"
              class="border-1 border-green-900 p-0 focus:ring-0 checked:ring-0 rounded-sm text-green-900 checked:bg-green-900"
          />
            <label :for="config.id" class="ml-2 w-full flex text-xs tracking-wide leading-tight text-green-900">
            Dit weet ik niet precies
          </label>
      </div>
    </div>
  </div>
</template>

<script>

import slider from "vue3-slider"


export default {
  name: "InputString",
  props: {
    config: {
      type: Object,
      default: "",
    },
    modelValue: {
      type: [String, Number],
      default: 1,
    },
  },
  components: {
    "vue3-slider": slider,
  },
  data() {
      return {
          value: 1,
          disabled: false,
      };
  },
  mounted() {
      this.value = this.modelValue;
  },
  methods: {
    updateInput(value) {
      if(this.disabled == true)
        this.$emit("update:modelValue", 0);
      else
        this.$emit("update:modelValue", value);
    },
    updateInputToZero(event) {
      if(event.target.checked == true) {
        this.disabled = true;
        this.$emit("update:modelValue", 0);
      } else {
        this.disabled = false;
        this.$emit("update:modelValue", this.value);
      }{}
    }
  }
};

</script>

<style lang="scss">

  .vue3-slider .handle, .vue3-slider .handle:hover, .vue3-slider .handle.hover {
    background: #005D30;
    transform: scale(1);
    height: 25px;
    width: 25px;
    border-radius: 100%;
    top: 10px;
    z-index: 10;
  }

  .handle-disabled .handle, .handle-disabled .tooltip {
    display: none !important;
  }

  .vue3-slider .track {
    height: 8px;
    background: linear-gradient(270deg, #E6E6E6 0.92%, rgba(230, 230, 230, 0) 116.62%);
  }
  .vue3-slider .track-filled {
    background: transparent;
  }

  .vue3-slider .tooltip {
    left: 8px;
    // background: transparent;
  }

  .vertical-slide {
        
    position: absolute;
    width: 0px;
    height: 44px;
    left: 50%;
    top: 0px;
    background: #E6E6E6;
    border: 3px solid #E6E6E6;
    border-radius: 4px;

  }

</style>
