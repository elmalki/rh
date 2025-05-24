<template>
    <div  v-if="items.length" class="bg-white overflow-hidden  mt-4">
        <div class="border-x-8  flex justify-center border-red-500 bg-red-100 border border-red-400 text-red-700 py-4 text-center text-3xl uppercase font-thin">
            <ExclamationTriangleIcon class="size-10 text-red-600" aria-hidden="true" />
            Liste des maintenances en retard </div>
    <div class="card">
        <DataTable :value="items" dataKey="id" tableStyle="min-width: 60rem">
            <Column field="car.name" header="Vihécule"></Column>
            <Column field="maintenance_type.label" header="Libéllé" sortable></Column>
            <Column field="date" header="Date" sortable></Column>
            <Column field="km" header="Ancien d'intervention" sortable></Column>
            <Column field="next_km" header="Kilométrage d'intervention" sortable></Column>
            <Column field="car.kilometrage" header="Kilomatrage Acutelle"></Column>
            <Column header="Différence en km">
                <template #body="slotProps">
                    {{slotProps.data.car.kilometrage-slotProps.data.next_km}} km
                </template>
            </Column>
        </DataTable>
    </div>
    </div>
</template>

<script setup>
import DataTable from "primevue/datatable";
import Column from 'primevue/column'
import {ExclamationTriangleIcon} from "@heroicons/vue/20/solid/index.js";
const props = defineProps({items: Array})

</script>
