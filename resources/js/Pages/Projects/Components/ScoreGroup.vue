<template>
  <dl class="flex flex-col mr-4" v-if="data.scores.length > 0">
     {{data.title}}
     <div class="flex flex-row">
        <div class=" mr-4 px-2 py-3 bg-white shadow rounded-lg overflow-hidden sm:p-2" v-for="score in data.scores">
          <dt class="text-sm font-medium text-gray-500 truncat text-center">
            {{score.title}}
          </dt>
          <dd class="mt-1 text-2xl font-semibold text-green-600 text-center">
          {{score.score}}
          </dd>
        </div>
      </div>
  </dl>
</template>

<script>

  export default {
    components: {
    },
    props: ['data'],    
  }
</script>