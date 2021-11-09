<template>
    <div class="w-full">
        <label v-if="config.label" :for="config.id" class="opacity-30 border-b pb-3 mb-2 border-color-green-900 w-full flex text-xs tracking-wide leading-tight text-green-900">
            {{ config.label }}
        </label>
        <div class="flex flex-row">
            <input
            :id="config.id"
            type="text"
            :value="modelValue"
            @input="updateInput"
            :placeholder="config.placeholder"
            class="border-0 p-0 w-full text-base font-bold tracking-wide text-gray-700 focus:ring-0"
        />
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.91999 20.579C4.63948 20.5785 4.37206 20.4602 4.18299 20.253C3.99044 20.0475 3.89476 19.7695 3.91999 19.489L4.16499 16.795L15.483 5.481L19.02 9.017L7.70499 20.33L5.01099 20.575C4.97999 20.578 4.94899 20.579 4.91999 20.579ZM19.726 8.31L16.19 4.774L18.311 2.653C18.4986 2.46522 18.7531 2.35971 19.0185 2.35971C19.2839 2.35971 19.5384 2.46522 19.726 2.653L21.847 4.774C22.0348 4.96157 22.1403 5.21609 22.1403 5.4815C22.1403 5.74691 22.0348 6.00143 21.847 6.189L19.727 8.309L19.726 8.31Z" fill="#005D30"/>
            </svg>
        </div>
    </div>
</template>

<script>
export default {
  name: "InputString",
  props: {
    config: {
      type: Object,
      default: "",
    },
    modelValue: {
      type: [String, Number],
      default: "",
    },
  },
  methods: {
    updateInput(event) {
      this.$emit("update:modelValue", event.target.value);
    }
  }
};
</script>