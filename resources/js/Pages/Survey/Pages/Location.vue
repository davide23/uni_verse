<template>
    <div class="w-full flex flex-col lg:flex-row">
        <div class="w-full h-auto lg:w-1/2 lg:h-screen bg-gray-200">    
            <GoogleMap
                ref="mapRef"
                class="map flex justify-center items-center h-full w-full"
                api-key="AIzaSyAS1kOUPqeQk-ukarTC9ePe9sD7HFiFqcw"
                :center="center"
                :zoom="14"
                :mapTypeControl='false'
                >
                
                <Marker :onDragend="setLocation" :options="{ draggable: true, position: center }" />
            </GoogleMap>
        </div>

        <div class="flex flex-col lg:w-1/2 h-screen bg-white">

            <div class="relative flex-auto flex justify-center overflow-auto">

                <ImageBackgroundWizardFormMobile class="absolute bottom-0 w-full left-0 md:hidden z-0"/>   

                <div class="w-5/6 md:w-2/3 m-auto flex flex-wrap h-auto z-10">
                    <div class="my-1 w-full">
                        <h3 class="text-5xl font-bold leading-10 text-center text-gray-700 mb-10">
                            {{currentPage.copy.title}}
                        </h3>
                    </div>
                    <div class="text-base leading-relaxed text-center text-gray-400">
                        <p>
                            {{currentPage.copy.intro}}
                        </p>
                    </div>
                    <div :class="[$page.props.errors.hasOwnProperty('location') ? 'border-red-500' : 'border-green-900']" class="mt-12 flex w-full m-auto px-5 pt-4 pb-5 mb-4 bg-white border rounded-lg">

                    <div class="flex flex-col w-full">
                        <InputLocation
                            ref="inputRef"
                            v-model="location"
                        />
                        <ul>
                            <li v-for="(result, i) in searchResults" :key="i">
                                <a @click.prevent="setLocationByPlaceId(result.place_id)">{{ result.description }}</a>
                            </li>
                        </ul>
                    </div>

                        <span class="ml-auto hidden xs:block">
                            <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23 2.45343C27.1035 2.45343 31.1149 3.67026 34.5268 5.95005C37.9388 8.22984 40.5981 11.4702 42.1684 15.2613C43.7387 19.0525 44.1496 23.2242 43.3491 27.2488C42.5485 31.2735 40.5725 34.9704 37.6709 37.872C34.7692 40.7736 31.0724 42.7497 27.0477 43.5502C23.023 44.3508 18.8513 43.9399 15.0602 42.3695C11.269 40.7992 8.02869 38.1399 5.7489 34.728C3.46911 31.316 2.25228 27.3047 2.25228 23.2012C2.2583 17.7004 4.44614 12.4266 8.33579 8.53694C12.2254 4.64729 17.4992 2.45944 23 2.45343ZM23 0.701157C18.5499 0.701157 14.1998 2.02076 10.4997 4.49309C6.79957 6.96542 3.91569 10.4794 2.21272 14.5908C0.509749 18.7021 0.0641739 23.2261 0.932341 27.5907C1.80051 31.9553 3.94343 35.9644 7.09011 39.1111C10.2368 42.2577 14.2459 44.4007 18.6105 45.2688C22.975 46.137 27.499 45.6914 31.6104 43.9884C35.7217 42.2855 39.2357 39.4016 41.7081 35.7015C44.1804 32.0014 45.5 27.6512 45.5 23.2012C45.4934 17.2358 43.1207 11.5167 38.9026 7.29856C34.6845 3.08043 28.9653 0.707774 23 0.701157Z" fill="#005D30"/>
                            <path d="M22.998 11.0313C21.9147 11.0311 20.8419 11.2453 19.841 11.6616C18.8401 12.0779 17.9306 12.6882 17.1645 13.4576C16.3984 14.227 15.7907 15.1405 15.3761 16.1458C14.9614 17.1511 14.748 18.2286 14.748 19.3168C14.748 24.4247 19.9627 30.8809 22.1 33.3116C22.2124 33.4396 22.3506 33.5421 22.5054 33.6123C22.6602 33.6825 22.8282 33.7188 22.998 33.7188C23.1679 33.7188 23.3359 33.6825 23.4907 33.6123C23.6455 33.5421 23.7837 33.4396 23.8961 33.3116C26.0334 30.8809 31.248 24.4247 31.248 19.3168C31.248 18.2286 31.0346 17.1511 30.62 16.1458C30.2054 15.1405 29.5977 14.227 28.8316 13.4576C28.0655 12.6882 27.156 12.0779 26.1551 11.6616C25.1542 11.2453 24.0814 11.0311 22.998 11.0313ZM22.998 22.4932C22.3799 22.4934 21.7756 22.3095 21.2615 21.9647C20.7474 21.6199 20.3466 21.1298 20.1099 20.5562C19.8732 19.9826 19.8111 19.3514 19.9316 18.7424C20.052 18.1334 20.3496 17.574 20.7866 17.1348C21.2236 16.6957 21.7805 16.3966 22.3867 16.2754C22.993 16.1542 23.6214 16.2163 24.1925 16.4538C24.7636 16.6914 25.2518 17.0937 25.5953 17.61C25.9387 18.1262 26.122 18.7332 26.122 19.3541C26.1225 19.7665 26.0421 20.175 25.8853 20.5562C25.7285 20.9374 25.4985 21.2838 25.2084 21.5756C24.9183 21.8675 24.5737 22.0991 24.1945 22.2571C23.8152 22.4152 23.4087 22.4966 22.998 22.4968V22.4932Z" fill="#005D30"/>
                            </svg>
                        </span>
                    </div>
                
                    
                </div>

            </div>   

            <slot></slot>
                
        </div>
    </div>
</template>


<script>
    import SelectDefault from './Components/SelectDefault.vue'
    import TextAreaString from './Components/TextAreaString.vue'
    import Places from '../../Components/Places.vue'
    import InputLocation from './Components/InputLocation.vue'

    import ImageBackgroundWizardFormMobile from './Components/Images/ImageBackgroundWizardFormMobile.vue'

    import { GoogleMap, Marker } from 'vue3-google-map'
    import { defineComponent, ref, computed, watch } from 'vue'

    export default {
        props: ['currentPage','data'],
        components: {
            InputLocation,
            SelectDefault,
            TextAreaString,
            GoogleMap, 
            Marker,
            Places,
            ImageBackgroundWizardFormMobile,
        },
        mounted() {
            if(this.data.location)
                if(this.data.location.formatted_address) {
                    this.location = this.data.location.formatted_address;
                    this.center = { lat: this.data.location.latitude, lng: this.data.location.longitude };
                }
        },
        data() {
            return {
                center: { lat: 52.5034775, lng: 4.7571696 },
                location: '',
                service: null,
                searchResults: [],
            }
        },
        watch: {
        location (newValue) {

            if (this.$refs.mapRef.ready && this.service == null) {
                const options = {
                    fields: ["formatted_address", "geometry", 'address_components'],
                    strictBounds: true,
                };
                this.service = new this.$refs.mapRef.api.places.Autocomplete(this.$refs.inputRef.$refs.inputField, options);
                this.service.addListener("place_changed", () => {

                    //marker.setVisible(false);

                    const place = this.service.getPlace();
                    // save
                    this.data['location'] = this.format(place);

                    if (!place.geometry || !place.geometry.location) {
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        this.$refs.mapRef.map.fitBounds(place.geometry.viewport);
                         this.center = place.geometry.location;
                    } else {
                        this.center = place.geometry.location;
                        this.$refs.mapRef.map.setCenter(place.geometry.location);
                        this.$refs.mapRef.map.setZoom(17);
                    }

                });
            }


            /*
            if (this.$refs.mapRef.ready && this.service == null) {
                this.service = new this.$refs.mapRef.api.places.AutocompleteService()
            }
            
            if (newValue) {
                this.service.getPlacePredictions({
                    input: this.location
                }, this.displaySuggestions)
            }
            */
            
        }
        },
        methods: {
            goNextPage: function() {
                this.$emit("go-next-page", this.currentPage);
            },
            goPrevPage: function() {
                this.$emit("go-prev-page", this.currentPage);
            },
            setLocation: function(e) {
                this.center = { lat: e.latLng.lat(), lng: e.latLng.lng() };
            },  
            format: function(place) {
                return {
                    street_name: this.extract(place.address_components, 'route'),
                    street_number: this.extract(place.address_components, 'street_number'),
                    postal_code: this.extract(place.address_components, 'postal_code'),
                    city: this.extract(place.address_components, 'locality'),
                    country: this.extract(place.address_components, 'country'),
                    formatted_address: place.formatted_address,
                    latitude: place.geometry.location.lat(),
                    longitude: place.geometry.location.lng(),
                    address_components: place.address_components,
                }
            },
            extract: function(components, type, format = 'long_name') {
                let result = null;
                components.forEach((component) => {
                    if (component.types.includes(type)) {
                        result = component[format]
                    }
                })
                return result;
            }
        }
    }
</script>

<style>
    .bg-navy{
        background-color:#00052F;
    }
    .bg-gray{
        background-color:#F0F0F0;
    }
    .text-pink{
        color:#FF7864;
    }
</style>