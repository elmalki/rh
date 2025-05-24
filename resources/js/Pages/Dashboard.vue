<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Table from './Table.vue'
import Tail from './Stats/Tail.vue'
import ConsommationCarburant from "@/Pages/Stats/ConsommationCarburant.vue";
import Pie from "@/Pages/Stats/Pie.vue";
import TwoTextTail from './Stats/TwoTextTail.vue'
import {BanknotesIcon, FireIcon, TruckIcon, UsersIcon} from '@heroicons/vue/24/outline'
import {PresentationChartLineIcon, ExclamationTriangleIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    items: Array,
    nbre_de_fonctionnaire: Object,
    nbre_de_vihecules: Number,
    nbre_de_conge: Number,
    budget: Array,
    marques: Array,
    carburants: Array,
    types: Array,
    dotations:Object,
    budgets:Object
})

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tableau de bord
            </h2>
        </template>

        <div class="py-8 bg-gray-50 h-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="border-x-8 my-4 flex justify-center border-emerald-500 bg-emerald-100 border border-emerald-400 text-emerald-700 py-4 text-center text-3xl uppercase font-thin">
                    <PresentationChartLineIcon class="size-10 text-emerald-600" aria-hidden="true" />
                   Statistiques </div>
                <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4 items-stretch">
                    <TwoTextTail class="" :item1="{icon:BanknotesIcon,title:'Restant',value:budget.restant}"
                                 :item2="{icon:BanknotesIcon,title:'Consommé',value:budget.consomme}"></TwoTextTail>
                    <Tail :icon="UsersIcon"
                          :item="{'Disponible':props.nbre_de_fonctionnaire.Homme+props.nbre_de_fonctionnaire.Femme-props.nbre_de_conge,'En congé':nbre_de_conge,'Hommes':nbre_de_fonctionnaire.Homme,'Femme':nbre_de_fonctionnaire.Femme}"
                          :title="'Fonctionnaires'"></Tail>
                    <Tail :icon="FireIcon" :item="carburants" :title="'Carburants'"></Tail>
                    <Tail :icon="TruckIcon" :item="types" :title="'Types Vihécules'" color="amber"></Tail>
                    <Tail :item="marques" :title="'Marques'"></Tail>
                </div>
                    <ConsommationCarburant :dotations="dotations" :budgets="budgets" class=""></ConsommationCarburant>
                    <Table :items="items" ></Table>
                    <!--div class="max-w-7xl mx-auto sm:px-6 mt-8 lg:px-8">
                        <Calendar />
                    </div-->
            </div>
        </div>
    </AppLayout>
</template>
