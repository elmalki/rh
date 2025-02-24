<script setup>

import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PdfApp from "vue3-pdf-app";

const props = defineProps({item: Object, visible: {type: Boolean, default: false}})
const emit = defineEmits(['close'])
const close = () => {
    emit('close')
}
</script>

<template>
    <DialogModal max-width="w-5/6" :show="visible" @close="close()">
        <template #content>
            <div class="bg-surface-0 p-10 md:p-20">
                <div class="bg-surface-0">
                    <div class="font-medium text-3xl text-surface-900 mb-4">
                        {{ item.mission }}
                    </div>
                    <ul class="list-none p-0 m-0">
                        <li class="flex items-center py-4 px-2 border-t border-surface flex-wrap">
                            <div
                                class="text-surface-500  w-6/12 md:w-4/12 font-medium">
                                Destination
                            </div>
                            <div
                                class="text-surface-900 w-full md:w-8/12 md:order-none order-1">
                               <span v-if="item.destination"> {{ item.destination.label }}       ({{ item.destination.trip_km }}km)</span>
                            </div>
                        </li>
                        <li class="flex items-center py-4 px-2 border-t border-surface flex-wrap">
                            <div
                                class="text-surface-500  w-6/12 md:w-4/12 font-medium">
                                Date départ
                            </div>
                            <div
                                class="text-surface-900 w-full md:w-8/12 md:order-none order-1">
                                {{ item.depart_date }}
                            </div>
                        </li>
                        <li class="flex items-center py-4 px-2 border-y border-surface flex-wrap">
                            <div
                                class="text-surface-500  w-6/12 md:w-4/12 font-medium">
                                Date retour
                            </div>
                            <div
                                class="text-surface-900 w-full md:w-8/12 md:order-none order-1">
                                {{ item.return_date }}
                            </div>
                        </li>
                        <span v-for="(equipe,i) in item.equipes">
                        <li class="flex items-center py-4 px-2 border-b border-surface flex-wrap">
                            <div
                                class="text-surface-500  w-6/12 md:w-4/12 font-medium">
                                Equipe {{ i + 1 }}
                            </div>
                            <div
                                class="text-surface-900 w-full md:w-8/12 md:order-none order-1">
                               Véhicule: <span class="bg-pink-500 text-white px-2 py-1">{{ equipe.car.plate }} </span>
                               Chauffeur: <span class="bg-blue-500 text-white px-2 py-1">{{
                                    equipe.driver.fullname
                                }} </span>
                                <span v-if="equipe.personnels.length">
                                Fonctionnaires <span v-for="p in equipe.personnels"
                                                    class="bg-teal-500 text-white px-2 py-1">{{ p.fullname }} </span>
                                </span>
                            </div>
                        </li>
                            </span>
                    </ul>
                </div>
            </div>
            <div v-if="item?.file" class="my-10 border border-black mx-auto"
                 :style="{ width: '900px', height: '700px'}">
                <PdfApp :pdf="item.file"></PdfApp>
            </div>
        </template>
        <template #footer>
            <PrimaryButton @click="close()">Fermer</PrimaryButton>
        </template>
    </DialogModal>
</template>

<style scoped>

</style>
