<template>

<div class="relative lg:flex w-full lg:w-1/2 lg:flex-col items-center justify-center bg-gray-900 h-4/6 lg:h-screen">
    <div class="relative flex flex-col z-10 h-full">
        <div  v-if="currentPerson" class="object-cover flex-grow overflow-hidden h-full w-full">
            <img  v-if="currentPerson" :src="currentPerson.image" class="object-contain	 h-full w-full ">
        </div>
        <div class="flex flex-col justify-start w-full bg-gray-900 p-4 lg:p-10	box-border	">
            <p class="text-sm lg:text-5xl font-bold leading-10 text-white lg:pb-10"  v-if="currentPerson">{{currentPerson.name}}</p>
            <p class="text-sm md:text-xl font-semibold text-white" v-if="currentPerson">{{currentPerson.bio}}</p>
        </div>
    </div>
</div>
</template>

<script>
export default { 
    name: 'SidepanelPerson',
    props: ['currentPerson'],
    components: {

    }
}
</script>
