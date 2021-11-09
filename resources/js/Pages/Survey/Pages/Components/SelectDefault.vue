<template>
    <div class="flex flex-wrap space-x-2 items-start justify-center">
          <a href="#" v-for="(option, index) in config.options" :key="index" @click.prevent="updateInput(option)" class="rounded-2xl mb-2">
            <div class="flex items-center justify-center flex-1 h-full px-2 lg:px-6 py-3 lg:py-4 bg-white border rounded-3xl border-gray-900 hover:bg-gray-900 text-gray-900 hover:text-white">
            <p class="text-sm lg:text-md font-bold tracking-wider leading-none">
            {{ option }}
            </p>
            </div>
          </a>
    </div>
</template>

<script>

export default {
  components: {
  },
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
  data() {
    return {
      selected: this.config.default
        ? this.config.default
        : this.config.options.length > 0
        ? this.config.options[0]
        : null,
      open: false,
    };
  },
  mounted() {
    this.$emit("input", this.selected);
  },
    methods: {
    updateInput(value) {
        this.$emit("clickAnswer", value);
    },
  }
};
</script>