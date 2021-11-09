<template>
    <div class="flex flex-col w-full h-full items-center justify-items-center">
        <div class="flex flex-col justify-items-center items-center h-80 w-full">
        <!-- <p class="font-bold mb-2 text-sm">{{config.label}}</p> -->
            <div v-bind="getRootProps()" class="flex flex-col justify-center w-full h-full rounded-3px mb-2">
                <input v-bind="getInputProps()" >
                <div class="flex justify-items-center items-center w-full flex-row"  v-if="busy">
                  <div class="flex flex-col items-center justify-items-center w-full">
                    <div class="lds-ring" v-if="busy"><div></div><div></div><div></div><div></div></div>
                  </div>
                </div>

                <div class="flex justify-items-center items-center w-full flex-row"  v-if="!busy">
                    <!-- <button class="uppercase bg-black text-white font-bold text-xs rounded-3px mb-3"  @click.stop.prevent="open">{{config.button}}</button> -->
                    <div class="mt-16 flex flex-col items-center justify-items-center w-full">
                        <div class="w-64 h-32 rounded flex flex-col text-center items-center">

                            <svg width="45" height="42" viewBox="0 0 45 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M44.4091 41.2498H42.7035C42.3954 41.2498 42.1533 40.9973 42.1533 40.676C42.1533 40.3546 42.3954 40.1021 42.7035 40.1021H43.8589V38.8971C43.8589 38.5758 44.101 38.3233 44.4091 38.3233C44.7172 38.3233 44.9593 38.5758 44.9593 38.8971V40.676C44.9593 40.9973 44.7062 41.2498 44.4091 41.2498Z" fill="#005D30"/>
                            <path d="M39.0283 41.2486H35.3529C35.0448 41.2486 34.8027 40.9961 34.8027 40.6747C34.8027 40.3534 35.0448 40.1009 35.3529 40.1009H39.0283C39.3364 40.1009 39.5784 40.3534 39.5784 40.6747C39.5784 40.9961 39.3364 41.2486 39.0283 41.2486ZM31.6776 41.2486H28.0023C27.6942 41.2486 27.4521 40.9961 27.4521 40.6747C27.4521 40.3534 27.6942 40.1009 28.0023 40.1009H31.6776C31.9857 40.1009 32.2278 40.3534 32.2278 40.6747C32.2278 40.9961 31.9857 41.2486 31.6776 41.2486ZM24.338 41.2486H20.6626C20.3545 41.2486 20.1124 40.9961 20.1124 40.6747C20.1124 40.3534 20.3545 40.1009 20.6626 40.1009H24.338C24.6461 40.1009 24.8882 40.3534 24.8882 40.6747C24.8882 40.9961 24.6351 41.2486 24.338 41.2486ZM16.9873 41.2486H13.312C13.0039 41.2486 12.7618 40.9961 12.7618 40.6747C12.7618 40.3534 13.0039 40.1009 13.312 40.1009H16.9873C17.2954 40.1009 17.5375 40.3534 17.5375 40.6747C17.5375 40.9961 17.2844 41.2486 16.9873 41.2486ZM9.63666 41.2486H5.96133C5.65322 41.2486 5.41113 40.9961 5.41113 40.6747C5.41113 40.3534 5.65322 40.1009 5.96133 40.1009H9.63666C9.94477 40.1009 10.1869 40.3534 10.1869 40.6747C10.1869 40.9961 9.94477 41.2486 9.63666 41.2486Z" fill="#005D30"/>
                            <path d="M2.29683 41.2498H0.591214C0.283103 41.2498 0.0410156 40.9973 0.0410156 40.676V38.8971C0.0410156 38.5758 0.283103 38.3233 0.591214 38.3233C0.899325 38.3233 1.14141 38.5758 1.14141 38.8971V40.1021H2.29683C2.60494 40.1021 2.84703 40.3546 2.84703 40.676C2.84703 40.9973 2.59394 41.2498 2.29683 41.2498Z" fill="#005D30"/>
                            <path d="M0.591214 35.6031C0.283103 35.6031 0.0410156 35.3506 0.0410156 35.0292V31.1502C0.0410156 30.8289 0.283103 30.5764 0.591214 30.5764C0.899325 30.5764 1.14141 30.8289 1.14141 31.1502V35.0292C1.14141 35.3391 0.888321 35.6031 0.591214 35.6031ZM0.591214 27.845C0.283103 27.845 0.0410156 27.5925 0.0410156 27.2712V23.3921C0.0410156 23.0708 0.283103 22.8183 0.591214 22.8183C0.899325 22.8183 1.14141 23.0708 1.14141 23.3921V27.2712C1.14141 27.5925 0.888321 27.845 0.591214 27.845ZM0.591214 20.0869C0.283103 20.0869 0.0410156 19.8344 0.0410156 19.5131V15.6341C0.0410156 15.3127 0.283103 15.0602 0.591214 15.0602C0.899325 15.0602 1.14141 15.3127 1.14141 15.6341V19.5131C1.14141 19.8344 0.888321 20.0869 0.591214 20.0869Z" fill="#005D30"/>
                            <path d="M0.591214 12.3406C0.283103 12.3406 0.0410156 12.0881 0.0410156 11.7668V9.98793C0.0410156 9.66659 0.283103 9.41411 0.591214 9.41411H2.29683C2.60494 9.41411 2.84703 9.66659 2.84703 9.98793C2.84703 10.3093 2.60494 10.5618 2.29683 10.5618H1.14141V11.7668C1.14141 12.0766 0.888321 12.3406 0.591214 12.3406Z" fill="#005D30"/>
                            <path d="M31.6767 9.41354H28.0014C27.6933 9.41354 27.4512 9.66603 27.4512 9.98737C27.4512 10.3087 27.6933 10.5612 28.0014 10.5612H31.6767C31.9848 10.5612 32.2269 10.3087 32.2269 9.98737C32.2269 9.66603 31.9848 9.41354 31.6767 9.41354Z" fill="#005D30"/>
                            <path d="M9.63666 9.41383H5.96133C5.65322 9.41383 5.41113 9.66632 5.41113 9.98766C5.41113 10.309 5.65322 10.5615 5.96133 10.5615H9.63666C9.94477 10.5615 10.1869 10.309 10.1869 9.98766C10.1869 9.66632 9.94477 9.41383 9.63666 9.41383Z" fill="#005D30"/>
                            <path d="M39.0287 9.41354H35.3534C35.0453 9.41354 34.8032 9.66603 34.8032 9.98737C34.8032 10.3087 35.0453 10.5612 35.3534 10.5612H39.0287C39.3369 10.5612 39.5789 10.3087 39.5789 9.98737C39.5789 9.66603 39.3369 9.41354 39.0287 9.41354Z" fill="#005D30"/>
                            <path d="M44.4091 12.3403C44.101 12.3403 43.8589 12.0878 43.8589 11.7665V10.5615H42.7035C42.3954 10.5615 42.1533 10.309 42.1533 9.98766C42.1533 9.66632 42.3954 9.41383 42.7035 9.41383H44.4091C44.7172 9.41383 44.9593 9.66632 44.9593 9.98766V11.7665C44.9593 12.0764 44.7062 12.3403 44.4091 12.3403Z" fill="#005D30"/>
                            <path d="M44.4086 35.6031C44.1005 35.6031 43.8584 35.3506 43.8584 35.0292V31.1502C43.8584 30.8289 44.1005 30.5764 44.4086 30.5764C44.7167 30.5764 44.9588 30.8289 44.9588 31.1502V35.0292C44.9588 35.3391 44.7057 35.6031 44.4086 35.6031ZM44.4086 27.845C44.1005 27.845 43.8584 27.5925 43.8584 27.2712V23.3921C43.8584 23.0708 44.1005 22.8183 44.4086 22.8183C44.7167 22.8183 44.9588 23.0708 44.9588 23.3921V27.2712C44.9588 27.5925 44.7057 27.845 44.4086 27.845ZM44.4086 20.0869C44.1005 20.0869 43.8584 19.8344 43.8584 19.5131V15.6341C43.8584 15.3127 44.1005 15.0602 44.4086 15.0602C44.7167 15.0602 44.9588 15.3127 44.9588 15.6341V19.5131C44.9588 19.8344 44.7057 20.0869 44.4086 20.0869Z" fill="#005D30"/>
                            <path d="M30.1365 6.89428C30.1365 6.8683 30.1365 6.8683 24.3173 1.07507C24.1744 0.932186 23.8367 0.750336 23.447 0.750336H10.4577C9.79526 0.750336 9.2627 1.2829 9.2627 1.94535V26.4042C9.2627 27.0926 9.79526 27.6252 10.4577 27.6252H29.2792C29.9417 27.6252 30.4742 27.0926 30.4742 26.4042V7.76456C30.4612 7.37488 30.2794 7.07613 30.1365 6.89428ZM11.7047 3.16635H22.252V7.73858C22.252 8.40103 22.8235 8.9336 23.447 8.9336H28.0452V25.1572H11.7047V3.16635Z" fill="#005D30"/>
                            <path d="M19.8619 19.1943C19.4982 19.1943 19.2124 18.9086 19.2124 18.5449V12.0502C19.2124 11.6865 19.4982 11.4008 19.8619 11.4008C20.2256 11.4008 20.5113 11.6865 20.5113 12.0502V18.5449C20.5113 18.9086 20.2126 19.1943 19.8619 19.1943Z" fill="#005D30"/>
                            <path d="M23.0187 15.9472H16.6929C16.3292 15.9472 16.0435 15.6614 16.0435 15.2977C16.0435 14.934 16.3292 14.6482 16.6929 14.6482H23.0187C23.3824 14.6482 23.6682 14.934 23.6682 15.2977C23.6682 15.6614 23.3824 15.9472 23.0187 15.9472Z" fill="#005D30"/>
                            <path d="M26.9673 20.4943L31.4226 32.7562L33.41 29.0283L38.6966 34.0551L40.9438 31.8859L35.8 26.7811L39.476 24.521L26.9673 20.0267V20.4943Z" fill="#005D30"/>
                            <path d="M41.3722 31.4832L36.722 26.833L40.1772 25.1574C40.411 25.0405 40.5539 24.7937 40.5409 24.5339C40.5279 24.2741 40.359 24.0403 40.1122 23.9623L34.4878 22.0269V22.001C34.0592 21.91 33.6306 21.8711 33.1889 21.5723V21.5853L27.3048 19.559C27.058 19.468 26.7852 19.559 26.6163 19.7408C26.4345 19.9097 26.3695 20.1695 26.4475 20.4163L28.1231 25.3132H28.0452C28.24 25.6899 28.4868 26.1445 28.5128 26.6122H28.5517L30.8379 33.2367C30.9288 33.4835 31.1496 33.6524 31.4094 33.6654C31.6692 33.6783 31.916 33.5355 32.0329 33.3017L33.7085 29.8465L38.3587 34.4967C38.4756 34.6136 38.6444 34.6785 38.8133 34.6785C38.8393 34.6785 38.8782 34.6785 38.9172 34.6655C38.9302 34.6655 38.9562 34.6655 38.9692 34.6525C38.9951 34.6525 39.0081 34.6396 39.0341 34.6396H39.0471C39.125 34.6136 39.19 34.5616 39.2549 34.4967L41.3592 32.3924C41.4761 32.2755 41.554 32.1066 41.554 31.9378C41.554 31.7819 41.4891 31.613 41.3722 31.4832ZM38.8133 33.1328L33.9813 28.3008C33.8384 28.1579 33.6176 28.0929 33.4097 28.1189C33.2019 28.1579 33.033 28.2878 32.9291 28.4696L31.5393 31.3273L29.6298 25.7679C29.6298 25.7419 29.6169 25.7289 29.6039 25.7029L28.0581 21.1956L38.1898 24.6768L35.3322 26.0666C35.1373 26.1575 35.0074 26.3394 34.9814 26.5472C34.9425 26.755 35.0074 26.9629 35.1633 27.1187L39.9953 31.9508L38.8133 33.1328Z" fill="#005D30"/>
                            <path d="M39.2674 34.509C39.2025 34.5739 39.1375 34.6129 39.0596 34.6519C39.1375 34.6129 39.2025 34.5609 39.2674 34.509Z" fill="#005D30"/>
                            </svg>

                            <span class="mt-6 font-bold text-green-900">{{config.title}}</span>
                            <span class="text-green-900 opacity-75">{{config.label}}</span>
                        </div>

                        <a class="mt-16 text-sm text-green-900 underline opacity-50 cursor-pointer">{{config.label_select}}</a>
                    </div>
                </div>

            </div>
        <!-- <p class="text-xs mb-4">{{config.recommendation}}</p> -->
        </div>

        <div v-if="data.files.length > 0" class="flex flex-col justify-items-center items-center w-full mt-4  grid grid-cols-5 gap-4">
            <div v-for="(file, index) in data.files" :key="index" class="block select-icons box-border h-full w-full rounded-lg overflow-hidden">
                <a href="#" @click.prevent="removeFile(file.id)" class="flex flex-col justify-items-center items-center">
                  <svg width="22" height="28" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21.1365 6.89428C21.1365 6.8683 21.1365 6.8683 15.3173 1.07507C15.1744 0.932186 14.8367 0.750336 14.447 0.750336H1.45771C0.795258 0.750336 0.262695 1.2829 0.262695 1.94535V26.4042C0.262695 27.0926 0.795258 27.6252 1.45771 27.6252H20.2792C20.9417 27.6252 21.4742 27.0926 21.4742 26.4042V7.76456C21.4612 7.37488 21.2794 7.07613 21.1365 6.89428ZM2.70468 3.16635H13.252V7.73858C13.252 8.40103 13.8235 8.9336 14.447 8.9336H19.0452V25.1572H2.70468V3.16635Z" fill="#005D30"/>
                  </svg>
                  <p class="text-sm text-center text-green-900 underline opacity-50 cursor-pointer">
                    {{file.file_name}}
                  </p>
                </a>
            </div>
        </div>

        <div class="flex flex-col items-center justify-items-center hidden">
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
        Inertia.post('/projects/' + data.id + '/file/upload' , formData, {
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
        Inertia.post('/projects/' + data.id + '/file/remove' , formData, {
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