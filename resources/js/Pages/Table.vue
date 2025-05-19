<template>
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
        <Toast/>
    </div>
</template>

<script setup>
import DataTable from "primevue/datatable";
import Column from 'primevue/column'
import Button from 'primevue/button'
import {ref} from 'vue';
const props = defineProps({items: Array})

</script>
