<template>
    <div class="flex flex-col w-full h-full items-center justify-items-center">
        <div class="flex flex-col justify-items-center items-center h-80 w-full">
        <!-- <p class="font-bold mb-2 text-sm">{{config.label}}</p> -->
            <div v-bind="getRootProps()"  class="flex flex-col justify-center w-full h-full rounded-3px mb-2 cursor-pointer">
                <input v-bind="getInputProps()" accept="image/jpg, image/jpeg, image/png, image/PNG, image/JPG">
                <div class="flex justify-items-center items-center w-full flex-row"  v-if="busy">
                  <div class="flex flex-col items-center justify-items-center w-full">
                    <div class="lds-ring" v-if="busy"><div></div><div></div><div></div><div></div></div>
                  </div>
                </div>

                <div class="flex justify-items-center items-center w-full flex-row"  v-if="!busy">
                    <!-- <button class="uppercase bg-black text-white font-bold text-xs rounded-3px mb-3"  @click.stop.prevent="open">{{config.button}}</button> -->
                    <div class="mt-16 flex flex-col items-center justify-items-center w-full">
                        <div class="w-64 h-32 rounded flex flex-col text-center items-center">
                            <svg width="46" height="47" viewBox="0 0 46 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.7136 17.3884C21.2897 17.3884 20.1355 16.1914 20.1355 14.7148C20.1355 13.2382 21.2897 12.0412 22.7136 12.0412C24.1374 12.0412 25.2917 13.2382 25.2917 14.7148C25.2917 16.1914 24.1374 17.3884 22.7136 17.3884Z" fill="#005D30"/>
                            <path d="M39.0417 28.0829H18.4167L23.573 20.9532L25.2917 22.7356L30.448 15.606L39.0417 28.0829Z" fill="#005D30"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M41.3334 37.2495H13.8334C11.3021 37.2495 9.25004 35.1975 9.25004 32.6662V5.16619C9.25004 2.63488 11.3021 0.582855 13.8334 0.582855H41.3334C43.8647 0.582855 45.9167 2.63488 45.9167 5.16619V32.6662C45.9167 35.1975 43.8647 37.2495 41.3334 37.2495ZM13.8334 5.16619V32.6662H41.3334V5.16619H13.8334Z" fill="#005D30"/>
                            <path d="M4.66671 14.3329H0.083374V41.8329C0.083374 44.3642 2.1354 46.4162 4.66671 46.4162H32.1667V41.8329H4.66671V14.3329Z" fill="#005D30"/>
                            </svg>
                            <span class="mt-6 font-bold text-green-900">{{config.title}}</span>
                            <span class="text-green-900 opacity-75">{{config.label}}</span>
                        </div>

                        <a class="mt-16 text-sm text-green-900 underline opacity-50 cursor-pointer">of selecteer een foto</a>
                    </div>
                </div>

            </div>
        <!-- <p class="text-xs mb-4">{{config.recommendation}}</p> -->
        </div>

        <div v-if="data.images.length > 0" class="flex-col justify-items-center items-center w-full mt-4 grid grid-cols-5 gap-4">
            <div v-for="(image, index) in data.images" :key="index" class="block select-icons box-border h-full w-full rounded-lg overflow-hidden">
                <img :src="image.thumb.src" @click.prevent="removeFile(image.id)" class="object-cover h-16 w-full">
            </div>
        </div>

        <div class="flex-col items-center justify-items-center hidden">
            <span class="text sm text-green-900 mt-8 opacity-75">Of</span>
            <div class="flex flex-row items-center justify-items-center mt-8"> 
                <ButtonDefault>ik heb nog geen foto</ButtonDefault>
            </div>
        </div>
    </div>
</template>

<script>
import { useDropzone } from 'vue3-dropzone'
import axios from "axios";

import ButtonDefault from '../../../Components/ButtonDefault.vue';
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'


export default {

    name: 'UploadImage',
    components: {
        ButtonDefault,
    },
    props: {
    config: {
        type: Object,
        default: "",
        },
    data: {
        type: Object,
        default: "",
        },
    modelValue: {
        type: [String, Number],
        default: "",
        },
    },
    setup(props, { emit }) {

    const data = props.data;
    const busy = ref(0)

    const saveFiles = (files) => {
      const formData = new FormData(); // pass data as a form
      
      for (var x = 0; x < files.length; x++) {
        // append files as array to the form, feel free to change the array name
        formData.append("file[]", files[x]);
      }

      // post the formData to your backend where storage is processed. In the backend, you will need to loop through the array and save each file through the loop.

        formData._method = 'POST';
        busy.value = true;
        Inertia.post('/projects/' + data.id + '/image/upload' , formData, {
        onSuccess: () => {
            busy.value = false;
            console.log("saved");
        }
        });
    }

    function onDrop(acceptFiles, rejectReasons) {
      
      saveFiles(acceptFiles); // saveFiles as callback
      //console.log(rejectReasons);
    }

    function removeFile(file) {
        busy.value = true;
        const formData = new FormData();
        formData.append("id", file);
        formData._method = 'POST';
        Inertia.post('/projects/' + data.id + '/image/remove' , formData, {
        onSuccess: () => {
          busy.value = false;
            console.log("image deleted");
        }
        });
    }

    const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop })

    return {
      busy,
      removeFile,
      getRootProps,
      getInputProps,
      ...rest
    }
  },
}
</script>

<style scoped>

    .lds-ring {
      display: inline-block;
      position: relative;
      width: 80px;
      height: 80px;
    }
    .lds-ring div {
      box-sizing: border-box;
      display: block;
      position: absolute;
      width: 64px;
      height: 64px;
      margin: 8px;
      border: 8px solid #005D30;
      border-radius: 50%;
      animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
      border-color: #005D30 transparent transparent transparent;
    }
    .lds-ring div:nth-child(1) {
      animation-delay: -0.45s;
    }
    .lds-ring div:nth-child(2) {
      animation-delay: -0.3s;
    }
    .lds-ring div:nth-child(3) {
      animation-delay: -0.15s;
    }
    @keyframes lds-ring {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

</style>