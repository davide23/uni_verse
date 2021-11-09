<template>
    <div class="flex flex-wrap space-x-2 items-start justify-center">
          <a href="#" v-for="(option, index) in config.options" :key="index" @click.prevent="updateInput(option)" class="rounded-2xl mb-2">
            <div class="flex items-center justify-center flex-1 h-full px-2 lg:px-6 py-3 lg:py-4 bg-white border rounded-3xl border-gray-900  text-gray-900" :class="[this.selected.includes(option) ? 'bg-gray-900' : ' hover:bg-gray-900 hover:text-white']">
              <p class="text-sm lg:text-md font-bold tracking-wider leading-none" :class="[this.selected.includes(option) ? 'text-white' : '']">
              {{ option }}
              </p>
            </div>
          </a>
    </div>
    <div class="flex flex-wrap space-x-2 items-start justify-center mt-4">
          <a href="#" @click.prevent='$emit("clickAnswer", this.selected); this.selected = [];' class="rounded-2xl mb-2">
            <div class="flex items-center justify-center flex-1 h-full px-2 lg:px-6 py-3 lg:py-4 bg-white border rounded-3xl border-gray-900  text-gray-900 hover:bg-gray-900 hover:text-white">
              <p class="text-sm lg:text-md font-bold tracking-wider leading-none">
                Volgende vraag
              </p>
            </div>
          </a>
    </div>
</template>

<script>


export default {
  components: {
  },
  emits: ["clickAnswer"],
  props: {
    config: {
      type: Object,
      default: "",
    },
    modelValue: {
      type: [Array, String],
      default: [],
    },
  },
  data() {
    return {
      selected: [],
      open: false,
    };
  },
  mounted() {
    /*
    // this.$emit("input", this.selected);
    if (typeof this.modelValue === 'string' || this.modelValue instanceof String)
      this.selected.push(this.modelValue);
    else if (this.modelValue != null)
      this.selected = this.modelValue;
      */
  },
    methods: {
    updateInput(value) {
      if(this.selected.includes(value))
      {
         this.selected = this.selected.filter(function(filter){ 
              return value != filter; 
          });
      }
      else 
        this.selected.push(value);

      // this.$emit("update:modelValue", this.selected);
    },
  }
};
</script>

