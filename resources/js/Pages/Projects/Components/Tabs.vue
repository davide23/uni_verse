<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ]
  }
  ```
-->
<template>
  <div>
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Select a tab</label>
      <select id="tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
      </select>
    </div>
    <div class="hidden sm:block">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
          <a v-for="tab in tabs" v-on:click="updateModus(tab)" :key="tab.name" href="#" :class="[tab.current ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab.current ? 'page' : undefined">
            {{ tab.name }}
            <span v-if="tab.count" :class="[tab.current ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-900', 'hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block']">{{ tab.count.value }}</span>
          </a>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, toRef} from 'vue'


export default {
  props: ['total', 'selection'],    
  setup(props) {

    const total  = toRef(props, 'total');
    const selection  = toRef(props, 'selection');

    const tabs = [
        { name: 'Talent', href: '#', count: total, current: true, modus: 'default'},
        { name: 'Shortlist', href: '#', count: selection, current: false, modus: 'selection' },
    ]


    return {
        tabs,total
    }
  },

  methods: {
      updateModus(value) {
            this.tabs.forEach((tab, index) => {
            tab.current = false;
            })
            value.current = true;
            this.$emit("change", value.modus);
        }
   },

}
</script>
