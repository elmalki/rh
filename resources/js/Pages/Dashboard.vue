<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from './Table.vue'
import Tail from './Stats/Tail.vue'
import TwoTextTail from './Stats/TwoTextTail.vue'
import {BanknotesIcon, CursorArrowRaysIcon, FireIcon, TruckIcon, UsersIcon} from '@heroicons/vue/24/outline'
import {onMounted, ref} from "vue";
import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    items: Array,
    nbre_de_fonctionnaire: Object,
    nbre_de_vihecules: Number,
    nbre_de_conge: Number,
    budget: Array,
    marques: Array,
    carburants: Array,
    types: Array
})

const stats = [


    {
        id: 1,
        name: 'Nombre de fonctionnaires',
        stat: props.nbre_de_fonctionnaire,
        icon: UsersIcon,
        change: `Disponible ${props.nbre_de_fonctionnaire - props.nbre_de_conge}`,
        changeType: 'increase'
    },
    {
        id: 2,
        name: 'Nombre de vihécules',
        stat: props.nbre_de_vihecules,
        icon: TruckIcon,
        change: '5.4%',
        changeType: 'increase'
    },
    { id: 3, name: 'Avg. Click Rate', stat: '24.57%', icon: CursorArrowRaysIcon, change: '3.2%', changeType: 'decrease' },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tableau de bord
            </h2>
        </template>

        <div class="py-12 bg-gray-50 h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-4 items-stretch">
                    <Tail :icon="FireIcon" :item="carburants" :title="'Carburants'"></Tail>
                    <Tail :icon="TruckIcon" :item="types" :title="'Types Vihécules'" color="amber"></Tail>
                    <Tail :item="marques" :title="'Marques'"></Tail>
                    <Tail :icon="UsersIcon"
                          :item="{'Disponible':props.nbre_de_fonctionnaire.Homme+props.nbre_de_fonctionnaire.Femme-props.nbre_de_conge,'En congé':nbre_de_conge,'Hommes':nbre_de_fonctionnaire.Homme,'Femme':nbre_de_fonctionnaire.Femme}"
                          :title="'Fonctionnaires'"></Tail>
                    <TwoTextTail   :item1="{icon:BanknotesIcon,title:'Restant',value:budget.restant}"  :item2="{icon:BanknotesIcon,title:'Consommé',value:budget.consomme}"></TwoTextTail>
                </div>

                <div  v-if="items.length" class="bg-white overflow-hidden  mt-4">
                    <div class="border-x-8  flex justify-center border-red-500 bg-red-100 border border-red-400 text-red-700 py-4 text-center text-3xl uppercase font-thin">
                        <ExclamationTriangleIcon class="size-10 text-red-600" aria-hidden="true" />
                        Liste des maintenances en retard </div>
                    <Table :items="items" ></Table>
                    <!--div class="max-w-7xl mx-auto sm:px-6 mt-8 lg:px-8">
                        <Calendar />
                    </div-->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
