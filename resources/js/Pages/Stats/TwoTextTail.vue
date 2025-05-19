<script setup>
const props = defineProps({item1:Object,item2:Object})
</script>

<template>
    <div class="grid grid-cols-3 justify-center items-center h-full col-span-2"><!-- Title Column -->
        <div
            class="flex flex-col bg-teal-600 text-white justify-center text-center items-center p-8 text-2xl font-bold h-full">
            <span class="text-3xl">{{item2.value+item1.value}} DHs</span>
            <component :is="item2.icon" class="size-6 text-white" aria-hidden="true" />
            <span>Budget</span>
        </div>
        <div
            class="flex flex-col border-r-1 border-slate-900 bg-teal-500 text-white justify-center text-center items-center p-8 text-2xl font-bold h-full">
            <span class="text-3xl">{{item1.value}} DHs</span>
            <component :is="item1.icon" class="size-6 text-white" aria-hidden="true" />
            <span>{{ item1.title }}</span>
        </div><!-- Info Column -->
        <div
            class="flex flex-col bg-teal-400 text-white justify-center text-center items-center p-8 text-2xl font-bold h-full">
            <span class="text-3xl">{{item2.value}} DHs</span>
            <component :is="item2.icon" class="size-6 text-white" aria-hidden="true" />
            <span>{{ item2.title }}</span>
        </div>
    </div>
</template>

<style scoped>

</style>
