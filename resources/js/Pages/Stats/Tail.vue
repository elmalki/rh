<script setup>
const props = defineProps({title:String,item:Array,icon:Object})
const sum = a => eval(a.join('+'));
</script>

<template>
    <div class="grid grid-cols-2 justify-center items-center h-full">
        <!-- Title Column -->
        <div class="flex flex-col bg-teal-600 text-white justify-center text-center items-center p-8 text-2xl font-bold h-full">
            <span class="text-5xl">{{sum(Object.values(item))}}</span>
            <component :is="icon" class="size-6 text-white" aria-hidden="true" />
            <span v-text="title"></span>
        </div>
        <!-- Info Column -->
        <div class=" bg-teal-400 p-3 text-white text-lg justify-center items-center  h-full">
            <div v-for="key in Object.keys(item)"  class="flex justify-between border-b pb-2">
                <span class="font-thin">{{key}}</span>
                <span class=" font-bold text-xl">{{item[key]}}</span>
            </div>
        </div>
</div>
</template>

<style scoped>

</style>
