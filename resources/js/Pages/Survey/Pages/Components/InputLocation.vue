<template>
  <div class="w-full">
    <label class="opacity-30 pb-3 w-full flex text-xs tracking-wide leading-tight text-green-900">
    Locatie van je plan
    </label>
    <input
        type="text"
        ref="inputField"
        :value="modelValue"
        @input="updateInput"
        placeholder="Vul hier het adres in..."
        class="border-0 p-0 w-full font-bold text-base tracking-widest text-gray-700 focus:ring-0"
    />
  </div>
</template>

<script>
export default {
  name: "InputLocation",
  props: {
    config: {
      type: [String, Object],
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