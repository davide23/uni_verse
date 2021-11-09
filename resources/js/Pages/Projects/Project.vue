<template>
  <app-layout>

      <edit :users="users"  @close="getResults" :config="config" v-model:isOpen="editIsOpen" v-model:form="form" :editMode="true"></edit>
    
      <TransitionRoot as="template" :show="isOpen">
          <Dialog as="section" static class="fixed inset-0 overflow-hidden" @close="isOpen = false" :open="isOpen">
            <div class="absolute inset-0 overflow-hidden">
              <DialogOverlay class="absolute inset-0" />

              <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16">
                <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                  <div class="w-screen max-w-2xl">
                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                      <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                          <DialogTitle class="text-lg font-medium text-gray-900">
                            Talent Details
                          </DialogTitle>
  
                          <div class="ml-3 h-7 flex items-center">
                            <button class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="isOpen = false">
                              <span class="sr-only">Close panel</span>
                              <XIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                          </div>
                        </div>
                      </div>
                      
                      <div class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                        <div class="flex items-center space-x-5">
                          <div class="flex-shrink-0">
                            <div class="relative">
                              <img v-for="image in candidate.images" :key="image.url" class="h-16 w-16 rounded-full" :src="image.url"/>
                              <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true" />
                            </div>
                          </div>
                          <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{candidate.name}}</h1>
                            <p class="text-sm font-medium text-gray-500">Applied for <a href="#" class="text-gray-900">Front End Developer</a> on <time datetime="2020-08-25">August 25, 2020</time></p>
                          </div>
                        </div>
                        <div class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                          <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                            Add to favorites
                          </button>
                          <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                            Add to project
                          </button>
                        </div>
                      </div>
                      
                      <div class="mt-10 pb-12 bg-white sm:pb-16">
                        <div class="relative">
                          <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="max-w-4xl mx-auto">
                              <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-3">
                                <div v-for="competence in candidate.competences.data" class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                                  <dt class="order-2 mt-2 text-lg leading-3 font-medium text-gray-500">
                                    {{competence.type}}
                                  </dt>
                                  <dd class="order-1 text-3xl font-extrabold text-indigo-600">
                                    {{competence.value}}
                                  </dd>
                                </div>
                              </dl>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="mt-10 pb-12 bg-white sm:pb-16">
                        <div class="relative">
                          <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="max-w-4xl mx-auto">
                              <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-3">
                                <div v-for="influence in candidate.influences.data" class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                                  <dt class="order-2 mt-2 text-lg leading-3 font-medium text-gray-500">
                                    {{influence.type}}
                                  </dt>
                                  <dd class="order-1 text-3xl font-extrabold text-indigo-600">
                                    {{influence.value}}
                                  </dd>
                                </div>
                              </dl>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="mt-10 pb-12 bg-white sm:pb-16">
                        <div class="relative">
                          <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="max-w-4xl mx-auto">
                              <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-3">
                                <div v-for="authority in candidate.authorities.data" class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                                  <dt class="order-2 mt-2 text-lg leading-3 font-medium text-gray-500">
                                    {{authority.type}}
                                  </dt>
                                  <dd class="order-1 text-3xl font-extrabold text-indigo-600">
                                    {{authority.value}}
                                  </dd>
                                </div>
                              </dl>
                            </div>
                          </div>
                        </div>
                      </div>
                      

                      
                      <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <inertia-link :href="`/person/`+ candidate.id" as="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                    View details
                            </inertia-link>


                      </div>
                    </div>
                  </div>
                </TransitionChild>
              </div>
            </div>
          </Dialog>
        </TransitionRoot>
      
      
<!-- Page Content -->
    <!--
    <div class="hidden lg:flex lg:flex-shrink-0">
      <div class="flex flex-col w-64">
       <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 pb-4 bg-white relative">
          <div class="mt-0 p-4 flex-grow flex flex-col sticky top-0">

     
            <div class="max-w-lg mb-2 w-full lg:max-w-xs">
              <label for="search" class="sr-only">Search</label>
              <div class="relative text-gray-400 focus-within:text-gray-500">
                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                  <SearchIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <input id="search" v-on:keyup="handleSearch" v-model="keyword" class="block w-full bg-white py-2 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search" />
              </div>
  </div>
            
            <nav class="flex-1 px-2 space-y-1 bg-white" aria-label="Sidebar">
              <template v-for="(facet_values, facet) in facets" :key="facet">
                <div v-if="!facet_values">
                  <a href="#" class='group w-full flex items-center pl-7 pr-2 py-2 text-sm font-medium rounded-md'>
                    {{facet}}
                  </a>
                </div>
                <Disclosure as="div" v-else class="space-y-1" v-slot="{ open }">
                  <DisclosureButton class='group w-full flex items-center pr-2 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500'>
                    <svg :class="[open ? 'text-gray-400 rotate-90' : 'text-gray-300', 'mr-2 h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150']" viewBox="0 0 20 20" aria-hidden="true">
                      <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                    </svg>
                    {{facet}}
                  </DisclosureButton>
                  <DisclosurePanel class="space-y-1">
                    <a href="#" v-for="(facet_value, facet_key) in facet_values" :key="facet_key" @click.prevent="handleFilter({type: 'keyword', value: facet_key, category : 'meta'})" class="group w-full flex items-center pl-10 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                      {{ facet_key }}
                      <span class="inline-flex items-center px-2.5 py-0.5 ml-2 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      {{facet_value}}
                      </span>                      
                    </a>
                  </DisclosurePanel>
                </Disclosure>
              </template>
            </nav>              

          </div>
        </div>
      </div>
    </div>
      
-->
      
    <div class="flex-1 relative">
      <!-- Navbar -->
      
      
      <div class="mx-auto px-4 sm:px-6 lg:px-8 xl:flex  p-4 bg-white sticky top-0 " v-if="filters.length > 0">
          <button v-for="filter in filters" type="button"  @click.prevent="removeFilter(filter)" class="inline-flex items-center mr-2 px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              {{filter.value}}

              <XCircleIcon class="ml-3 h-4 w-4 text-black-100 group-hover:text-gray-500" aria-hidden="true" />


          </button>
      </div>   
      


      
      <main class="">
        <div class=" mx-auto sm:px-6 lg:px-8 p-4 bg-white">

          <tabs v-model:total="total" v-model:selection="project.people.length" @change="setModus"></tabs>

          <!-- Stacked list -->
          <ul class="mt-5 border-t divide-y divide-gray-200 sm:mt-0 sm:border-t-0" role="list">
            <li v-for="candidate in results" :key="candidate.title" >
                
                <div class="flex items-center py-5 px-4 sm:py-6 sm:px-0">

                  <div class="">
                    <div class="py-1" v-if="!selection.includes(candidate.id)">
                      <a href="#" v-on:click="addToProject(candidate)">
                        Add
                      </a>
                    </div>
                    <div class="py-1" v-if="selection.includes(candidate.id)">
                      <a href="#" v-on:click="removeFromProject(candidate)">
                        Remove
                      </a>
                    </div>
                  </div>
                  <div class="min-w-0 flex-1 flex items-center">
                    <div class="flex-shrink-0">
                      <img v-for="image in candidate.images" :key="image.url" class="inline-block h-12 w-12 rounded-full ring-2 ring-white" :src="image.url"/>
                    </div>
                    <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                      <div class="cursor-pointer" @click="show(candidate)">
                        <p class="text-sm font-medium text-purple-600 truncate">{{ candidate.name }}</p>
                        <p class="mt-2 flex items-center text-sm text-gray-500">
                          <LocationMarkerIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                          <span class="truncate">{{ candidate.city }}</span>
                        </p>
                      </div>
                      <div class="hidden md:block">
                        <div>
                          <p class="text-sm text-gray-900">
                            Added on
                            {{ ' ' }}
                            <time :datetime="candidate.appliedDatetime">{{ candidate.published_at }}</time>
                          </p>
                          <p class="mt-2 flex items-center text-sm text-gray-500">
                            <CheckCircleIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" aria-hidden="true" v-if="candidate.margin_of_error < 100"/>
                            <ExclamationCircleIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-red-400" aria-hidden="true" v-if="candidate.margin_of_error == 100"/>
                            {{ candidate.margin_of_error }}% margin of error
                          </p>
                        </div>
                       
                        
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-row">
                    <score-group v-for="group in candidate.scores" :data="group"></score-group>
                  </div>
                </div>
            </li>
          </ul>

          <!-- Pagination -->
          <nav class="border-t border-gray-200 px-4 flex items-center justify-between sm:px-0" aria-label="Pagination">
            <div class="-mt-px w-0 flex-1 flex">
              <a href="#" v-if="pagination.links.prev" v-on:click="handleSearchUrl(pagination.links.prev)" class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-200">
                <ArrowNarrowLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                Previous
              </a>
            </div>
            <div class="hidden md:-mt-px md:flex">
              <a href="#" v-on:click="gotoPage(page_number)" v-for="page_number in (Math.ceil(pagination.meta.total/pagination.meta.per_page))" :key="page_number" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium"  v-bind:class="[pagination.meta.current_page === page_number ? 'border-indigo-500 text-indigo-600 border-t-2' : '']">
                {{page_number}}
              </a>
            </div>
            <div class="-mt-px w-0 flex-1 flex justify-end">
              <a href="#"  v-if="pagination.links.next" v-on:click="handleSearchUrl(pagination.links.next)" class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-200">
                Next
                <ArrowNarrowRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true" />
              </a>
            </div>
          </nav>
        </div>
      </main>
    </div>
  </app-layout>
</template>

<script>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout'   
    
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  Dialog, 
  DialogOverlay, 
  DialogTitle,
  TransitionChild, 
  TransitionRoot,
} from '@headlessui/vue'
    
import {
  ArrowNarrowLeftIcon,
  ArrowNarrowRightIcon,
  BriefcaseIcon,
  CalendarIcon,
  CheckCircleIcon,
  ExclamationCircleIcon,
  CheckIcon,
  ChevronDownIcon,
  ChevronRightIcon,
  CurrencyDollarIcon,
  LinkIcon,
  LocationMarkerIcon,
  DotsVerticalIcon,
  PencilAltIcon,
  DuplicateIcon,
  UserAddIcon,
  TrashIcon,
  MailIcon,
  PencilIcon,
  SearchIcon,
  XCircleIcon,
  SortAscendingIcon
} from '@heroicons/vue/solid'
  
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'

import Edit from './Section/Edit'
import ScoreGroup from './Components/ScoreGroup'
import Tabs from './Components/Tabs'


const publishingOptions = [
  { name: 'Published', description: 'This job posting can be viewed by anyone who has the link.', current: true },
  { name: 'Draft', description: 'This job posting will no longer be publicly accessible.', current: false },
]

export default {
  props: ['project','selection','config','users','errors','message','user'],
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    ArrowNarrowLeftIcon,
    ArrowNarrowRightIcon,
    BellIcon,
    BriefcaseIcon,
    CalendarIcon,
    CheckCircleIcon,
    ExclamationCircleIcon,
    CheckIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    CurrencyDollarIcon,
    LinkIcon,
    LocationMarkerIcon,
    MailIcon,
    MenuIcon,
    PencilIcon,
    SearchIcon,
    XCircleIcon,
    DotsVerticalIcon,
    PencilAltIcon,
    DuplicateIcon,
    UserAddIcon,
    SortAscendingIcon,
    XIcon,
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    AppLayout,
    Edit,
    ScoreGroup,
    Tabs,
  },
  setup() {
    const open = ref(false)
    const selected = ref(publishingOptions[0])

    return {
      publishingOptions,
      open,
      selected,
    }
  },
  
  data() {
    return {
      navigation: false,
      open: false,      
      isOpen: false, 
      candidate: false,
      total: 0, 
      modus: 'default',
      searchbar: false,
      per_page: 10,
      keyword: "",
      loadmore: true,
      loading: false,
      pagination: {
          meta: 0,
          links: 10,
      },
      results: [],
      filters: [],
      facets: [],
      sorting: "",
      /* Edit form */
      editIsOpen: false,      
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
  
  mounted () {
     this.loading = true;  
     this.modus = "default";
     this.getResults();

    this.form = this.project;
    this.editIsOpen = true;     
  },  

  methods: {
    
    addToProject(data) {
      data._method = 'POST';
      this.$inertia.post('/projects/' + this.project.id + '/person', data, {
        onSuccess: () => {
          this.getResults()
        }
      });   
    },   

    removeFromProject(data) {
      data._method = 'DELETE';
      this.$inertia.post('/projects/' + this.project.id + '/person', data, {
        onSuccess: () => {
          this.getResults()
        }
      });   
    },   


    setModus(modus) {            
        this.modus = modus;
        this.pagination.meta.current_page = 0;
        this.getResults()
    },


    edit() {
        this.form = this.project;
        this.editIsOpen = true;       
    },   
      
    show(data) {           
        this.isOpen = true;       
        this.candidate = data;        
    },      
      
    handleSearchUrl(url) {            
        axios.post(url,{
            search : this.keyword,
            filters : this.filters,
            categories : this.categories,                
            modus : this.modus,
            per_page : this.per_page
        })
       .then( (response) => {
            this.keyword = ""; 
            this.total = response.data.paginate.meta.total;
            this.pagination = response.data.paginate;
            this.facets = response.data.facets;
            this.results = response.data.paginate.data
            window.scrollTo(0, this.scroll_height);
            this.loading = false;
        })
       .catch( (error) => {
            console.log(error);
        }); 

    },
    
    gotoPage(page) {            
        this.pagination.meta.current_page = page;
        this.getResults()
    },
    
    getResults() {            
        axios.post("/api/search/?page=" + this.pagination.meta.current_page,{
            project_id : this.project.id,
            search : this.keyword,
            filters : this.filters,
            sorting : this.sorting,
            categories : this.categories,                
            modus : this.modus,
            per_page : this.per_page
        })
       .then( (response) => {
            this.keyword = ""; 
            this.total = response.data.paginate.meta.total;
            this.pagination.meta = response.data.paginate.meta;
            this.pagination.links = response.data.paginate.links;
            this.facets = response.data.facets;
            this.results = response.data.paginate.data;
            this.loading = false;
          
        })
       .catch( (error) => {
            console.log(error);
        }); 

    },

    handleSearch(e) {
        if (e.keyCode === 13) {
          if(this.modus != "search") {
            this.loading = true;
            this.filters = [];
            this.categories = [];                  
          }

          this.per_page = 16;
          this.modus = "search";
          this.handleFilter({ type: 'keyword', value : this.keyword, category : this.keyword});
          window.scrollTo(0,0);  
          return;
        }
    }, 
    
    sortBy(value) {
      this.sorting = value;
      this.getResults(); 
    },
    
    handleFilter(filters) {

        // close mobile menu
        this.pagination.current_page = 1;
        // check if multifilter?
        if(filters.hasOwnProperty("filters")) {
            $.each(filters.filters, function(key, value) {
               app.filter(value.type, value.value, value.category);
            });                
        } else {
            this.filter(filters.type, filters.value, filters.category);
        }
      
      // perform filtering
      this.getResults();             

    },     
    
    filter(type, value, category) {

      // check if filter exists
      if(this.filters.filter(item => item.value === value).length > 0)
        // remove filter
        this.filters = this.filters.filter(item => item.value !== value)
      else {
        // add filter
        this.filters.push({ type: type, value : value, category : category});
      }          

    },
    
    removeFilter(filter) {
      this.pagination.meta.current_page = 1;
      this.filters = this.filters.filter(item => item !== filter)
      this.getResults();       
    },   
  },
}
</script>