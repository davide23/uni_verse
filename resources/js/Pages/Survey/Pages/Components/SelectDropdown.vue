<template>
    <div class="px-15px mb-14px">
        <label class="font-bold text-sm">
            {{config.label}}
        </label>
        <div class="custom-select relative text-left w-full outline-none " :tabindex="config.tabindex" @blur="open = false">
            <div :id="config.id" :value="modelValue" @input="updateInput" class="selected h-9 leading-9 bg-white text-black rounded-3px border border-gray300 select-none cursor-pointer pl-2 text-xs" :class="{ open: open }" @click="open = !open">
            {{ selected }}
            </div>
            <div class="items" :class="{ selectHide: !open }">
            <div
                v-for="option in config.options"
                :key="option"
                @click="
                selected = option;
                open = false;
                $emit('input', option);
                "
            >
                {{ option }}
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    config: {
      type: Object,
      default: "",
    },
    modelValue: {
      type: [String, Number],
      default: "Center",
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
    updateInput(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  }
};
</script>

<style scoped>

.custom-select .selected.open {
  border: 1px solid #CCCCCC;
  border-radius: 3px 3px 0px 0px;
}

.custom-select .selected:after {
    background-image: url("/images/icons/arrow-gray.svg");
    background-repeat: no-repeat;
    position: absolute;
    content: "";
    top: 14px;
    right: 15px;
    width: 12px;
    height: 6px;
}

.custom-select .items {
    font-size: 12px;
    color: #000;
    border-radius: 0px 0px 3px 3px;
    overflow: hidden;
    border-right: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    border-bottom: 1px solid #CCCCCC;
    position: absolute;
    background-color: #fff;
    left: 0;
    right: 0;
    z-index: 1;
}

.custom-select .items div:nth-child(odd) {
  background-color: rgba(204, 204, 204, 0.1);
}

.custom-select .items div {
    padding: 8px 0;
    color: #000;
    padding-left: 8px;
    cursor: pointer;
    user-select: none;
}

.custom-select .items div:hover {
  background-color: #CCCCCC;
}

.selectHide {
  display: none;
}
</style>