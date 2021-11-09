  <template>

            <div class="max-w-md">
              <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                <div class=" relative flex-1 px-4 sm:px-6">
                    <form>
                        <div class="bg-white">
                          <p class="text-lg mb-2">Project information</p>
                          <div class="grid grid-cols-8 shadow rounded-3px mb-14">
                                <div class="border col-start-1 rounded-3tl col-span-5 p-11px14px">
                                    <label for="formControlInput1" class="formLabel block text-gray600 text-sm font-bold">Project</label>
                                    <input type="text" class="inputField p-0 appearance-none border-0 w-full" id="formControlInput1" placeholder="Enter Title" v-model="form.name">
                                    <div v-if="$page.props.errors.name" class="text-red-500">{{ $page.props.errors.name }}</div>
                                </div>
                                   <div class="border col-start-6 rounded-3tr col-span-3 p-11px14px">
                                    <label for="formControlInput2" class="formLabel block text-gray600 text-sm font-bold">Owner</label>
                                    <select v-model="form.owner_id" class="inputField p-0 appearance-none border-0 w-full">
                                        <option v-for="user in users" :key="user" v-bind:value="user.id">{{user.name}}</option>
                                    </select>
                                    <div v-if="$page.props.errors.owner_id" class="text-red-500">{{ $page.props.errors.owner_id }}</div>
                                </div>
                                 <div class="border col-start-4 col-span-5 p-11px14px">
                                    <label for="formControlInput4" class="formLabel block text-gray600 text-sm font-bold">Client</label>
                                    <input type="text" class="inputField p-0 appearance-none border-0 w-full" id="formControlInput4" v-model="form.meta_data.client" placeholder="Enter venue">
                                    <div v-if="$page.props.errors['meta_data.client']" class="text-red-500">{{ $page.props.errors['meta_data.client'] }}</div>
                                </div>
                                 <div class="border col-start-1 rounded-3bl col-span-4 p-11px14px">
                                    <label for="formControlInput5" class="formLabel block text-gray600 text-sm font-bold">Date</label>
                                    <input type="date" class="inputField p-0 appearance-none border-0 w-full" id="formControlInput5" v-model="form.meta_data.project_date" placeholder="Enter project date">
                                    <div v-if="$page.props.errors['meta_data.project_date']" class="text-red-500">{{ $page.props.errors['meta_data.project_date'] }}</div>
                                </div>
                          </div>          

                        <multiselect label="Influences" v-model:modelValue="form.meta_data.influences" :options="config.influences" @change="update(form)"></multiselect>   
                        <multiselect label="Competences" v-model:modelValue="form.meta_data.competences" :options="config.competences" @change="update(form)"></multiselect>   
                        <multiselect label="Authorities" v-model:modelValue="form.meta_data.authorities" :options="config.authorities" @change="update(form)"></multiselect>   

                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto"></span>


                          
                          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prproject="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                              Save
                            </button>
                          </span>
                          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prproject="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                              Update
                            </button>
                          </span>

                        </div>
                    </form>
                </div>
              </div>
            </div>

</template>

<script>
  import Multiselect from '../Components/Multiselect'
  import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

  
  export default {
    components: {
      Multiselect,
      Dialog,
      DialogOverlay,
      DialogTitle,
      TransitionChild,
      TransitionRoot,      
    },
    props: ['project', 'config', 'users','errors','message', 'user','isOpen','editMode', 'form'],    
    data() {
      return {  
      }
    },
    methods: {
        save: function (data) {
            this.$inertia.post('/projects', data,  {
              onSuccess: () => {
                this.$emit('update:isOpen',false);
                this.$emit('update:editMode',false);   
                this.$emit('close');        
              }
            });
        },
        update: function (data) {
            data._method = 'PUT';
            this.$inertia.post('/projects/' + data.id, data, {
              onSuccess: () => {
                this.$emit('update:form',this.form);                
                this.$emit('update:isOpen',false);
                this.$emit('close');
              }
            });
        },
        closeModal: function (data) {
          this.$emit('update:isOpen',false);
        },      
    },    
              
  }
</script>
