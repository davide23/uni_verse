<template>
    <div class="flex flex-col w-full">
        <label class="opacity-30 border-b pb-3 mb-2 border-color-green-900 w-full flex text-sm md:text-xs tracking-wide leading-tight text-green-900">
            {{config.label}}
        </label>
        <div class="w-full flex flex-wrap justify-center">
          <a href="#"  v-for="(option, index) in config.options" :key="index" @click="updateInput(option)"  class="flex w-28 justify-center items-center flex-col text-center select-icons box-border p-4 m-2 rounded-md border-green-900" :class="[modelValue == option ? 'border-4' : 'border']">
            <icon-base class="flex mb-2"><component :is="config.icons[option]" v-if="config.icons" /></icon-base>
            <p class="flex text-xs text-center text-green-900">
            {{ option }}
            </p>
          </a>
        </div>
    </div>
</template>

<script>

import IconGreen from './Icons/IconGreen.vue'
import IconClosed from './Icons/IconClosed.vue'
import IconHome from './Icons/IconHome.vue'
import IconIndoor from './Icons/IconIndoor.vue'
import IconMeet from './Icons/IconMeet.vue'
import IconOutdoor from './Icons/IconOutdoor.vue'
import IconPublic from './Icons/IconPublic.vue'

import IconKids from './Icons/IconKids.vue'
import IconYouth from './Icons/IconYouth.vue'
import IconAdults from './Icons/IconAdults.vue'
import IconSeniors from './Icons/IconSeniors.vue'
import IconAnimals from './Icons/IconAnimals.vue'

import IconCompanies from './Icons/IconCompanies.vue'
import IconExperts from './Icons/IconExperts.vue'
import IconFriends from './Icons/IconFriends.vue'
import IconNeighbours from './Icons/IconNeighbours.vue'
import IconParteon from './Icons/IconParteon.vue'
import IconShops from './Icons/IconShops.vue'

import IconFinish from './Icons/IconFinish.vue'
import IconForever from './Icons/IconForever.vue'

import IconBase from './IconBase.vue'

export default {
  components: {
    IconGreen,
    IconClosed,
    IconHome,
    IconIndoor,
    IconMeet,
    IconOutdoor,
    IconPublic,

    IconKids,
    IconYouth,
    IconAdults,
    IconSeniors,
    IconAnimals,

    IconCompanies,
    IconExperts,
    IconFriends,
    IconNeighbours,
    IconParteon,
    IconShops,

    IconFinish,
    IconForever,

    IconBase
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
      this.$emit("update:modelValue", value);
    },
  }
};
</script>

