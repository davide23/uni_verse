<template>
  <div>
    <app-layout>

        <!-- edit :users="users" :config="config" v-model:isOpen="isOpen" v-model:form="form" v-model:editMode="editMode"></edit> -->
      
        <TransitionRoot as="template" :show="isOpenPopup">
            <div class="fixed w-452px z-10 mr-20 mt-64 right-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" @close="isOpenPopup = false" :open="isOpenPopup">
                <div class="flex items-end justify-center pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-transparent transition-opacity" aria-hidden="true"></div>
                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle " aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom border-4 border-lightRed bg-veryLightRed rounded-3px px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-sm leading-6 font-medium text-black" id="modal-title">
                                Remove project
                            </h3>
                            <div class="flex items-center">
                                <img class="bg-contain bg-no-repeat mr-2" :src="'/images/warning.svg'">
                                <p class="text-lightRed text-2xl">Warning</p>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm text-black">
                                Are you sure you want to remove the project “{{form.name}}”?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:ml-4 sm:flex">
                        <button type="button" @click="deleteRow(form)" class="inline-flex justify-center w-full rounded-full border border-transparent shadow-sm px-4 py-1 bg-white text-base font-medium text-black hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                            Remove
                        </button>
                        <button type="button" @click="closeModalDelete()" class="mt-3 w-full inline-flex justify-center rounded-full border border-transparent px-4 py-1 bg-white text-base font-medium text-black shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </TransitionRoot>

        <div v-if="projects.length === 0" class="flex flex-col pt-40 md:pt-64 w-full items-center">
            <h1 class="text-blue-700 font-extrabold text-6xl text-center">You currently have<br>
            no projects!</h1>
            <button @click="openModal()" class="mt-10 bg-yellow-400 text-center rounded-3xl text-white font-bold px-8 py-3">Start a project</button>
        </div>

        <div v-if="projects.length > 0" class="flex-1 overflow-auto bg-white">

            <div class="mx-auto">
                <div class="bg-white overflow-hidden px-4 py-4">

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                        <div class="flex">
                            <div>
                            <p class="text-sm">{{ $page.props.flash.message }}</p>
                            </div>
                        </div>
                    </div>

                    <table class="table-fixed w-full projects-table">
                        <thead>
                            <tr class="">
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold w-1/6"><span class="flex cursor-pointer">Client &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>                              
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold w-1/6"><span class="flex cursor-pointer">Brand &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold w-1/6"><span class="flex cursor-pointer">Project name &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold"><span class="flex cursor-pointer">Start date &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold"><span class="flex cursor-pointer">Last modified &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>
                                <th class="text-blue-700 text text-left px-4 py-2 font-bold"><span class="flex cursor-pointer">Status &nbsp;<img src="/icons/arrowsupdown.svg"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in projects" :key="row.id" class="cursor-pointer text-blue-700" @click="edit(row)">
                                <td class="px-4 py-6 w-1/6">{{ row.meta_data.client }}</td>
                                <td class="px-4 py-6 w-1/6">{{ row.user.name }}</td>
                                <td class="px-4 py-6 w-1/6">{{ row.name }}</td>
                                <td class="px-4 py-6">{{ row.meta_data.project_date }}</td>
                                <td class="px-4 py-6">{{ row.updated_at }}</td>
                                <td class="px-4 py-6 capitalize" :class="[ row.status === 'draft' ? 'text-yellow-400' : '' ]"><span class="flex cursor-pointer">{{ row.status }} &nbsp;<img src="/icons/arrowdown.svg"></span></td>
                                <td class="px-4 py-6"><button class="bg-blue-700 text-xs p-2 text-white rounded-2xl"><span class="flex">Open &nbsp;&nbsp;<img src="/icons/openicon.svg"></span></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
  </div>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout'

    import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
    import { XIcon } from '@heroicons/vue/outline'
    import { usePage } from '@inertiajs/inertia-vue3'
  
    import Edit from './Section/Edit'
  
    import Multiselect from './Components/Multiselect'

    export default {
        components: {
            AppLayout,
            Edit,          
            Dialog,
            DialogOverlay,
            DialogTitle,
            TransitionChild,
            TransitionRoot,
            XIcon,
        },
        props: ['projects','config','users','errors','message','user'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                isOpenPopup: false,
                form: {
                    name: null,
                    status: 'draft',
                    slug: null,
                    emails: [],
                    people: [],
                    meta_data: {
                        registrations: 'open',
                        country: 'United States',
                        brand: 'VICE',
                        client: null,
                        project_date: null,
                        venue: null,
                        influences: [],
                        authorities: [],
                        competences: [],
                        personas: [],
                    },
                    owner_id: this.user.id,
                }
            }
        },
        methods: {
            openModal: function () {
                this.reset();
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            openModalDelete: function () {
                this.isOpenPopup = true;
            },
            closeModalDelete: function () {
                this.isOpenPopup = false;
            },
            reset: function () {
                this.form = {
                    name: null,
                    status: 'draft',
                    slug: null,
                    emails: [],
                    people: [],
                    meta_data: {
                        registrations: 'open',
                        country: 'United States',
                        brand: 'VICE',
                        client: null,
                        project_date: null,
                        venue: null,
                        influences: [],
                        authorities: [],
                        competences: [],
                        personas: [],
                    },
                    owner_id: this.user.id,
                }
            },
          
            edit: function (data) {

                this.$inertia.visit('/projects/'+ data.id)

                /*
                this.openModal();              
                this.form = Object.assign({}, data);
                this.editMode = true;
                */
            },          
            deleteRow: function (data) {
                data._method = 'DELETE';
                this.$inertia.post('/projects/' + data.id, data);
                this.reset();
                this.closeModal();
                this.closeModalDelete();
            }
        }
    }
</script>

<style lang="scss">
.projects-table {
    // thead th:not(:last-child) {
    //     background-image: url(/icons/arrowsupdown.svg);
    //     background-position: center;
    //     background-repeat: no-repeat;
    // }

    tbody tr:nth-child(even) {
        background-color: rgba(204, 204, 204, 0.1);
    }
}
</style>