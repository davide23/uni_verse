<template>
  <div>
    <input type="text" v-model="location">
    <ul>
      <li v-for="(result, i) in searchResults" :key="i">
        {{ result }} // list of all places
      </li>
    </ul>
  </div>
</template>


<script>
  export default {
    data: () => ({
      location: '',
      searchResults: [],
      service: null,
    }),
    watch: {
      location (newValue) {
        if (newValue) {
          this.service.getPlacePredictions({
            input: this.location,
            types: ['(cities)']
          }, this.displaySuggestions)
        }
      }
    },
    methods: {
        
      MapsInit () {
          console.log("dafsdfsd");
        this.service = new window.google.maps.places.AutocompleteService()
      },
      displaySuggestions (predictions, status) {
        if (status !== window.google.maps.places.PlacesServiceStatus.OK) {
          this.searchResults = []
          return
        }
        this.searchResults = predictions.map(prediction => prediction.description) 
      },


      
    }

  }
</script>