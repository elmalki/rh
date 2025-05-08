<script setup>

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import {onMounted, ref} from "vue";
const props = defineProps({data:Array,km:Number});
const values = ref([])
onMounted(()=>{
     values.value = props.data.slice()
})

</script>

<template>
    <DataTable :value="values" tableStyle="min-width: 50rem">
        <Column  header="Type de maintenance" sort-field="label" sortable>
            <template #body="slotProps">
                {{slotProps.data.label}}({{slotProps.data.kilometrage}}km)
            </template>
        </Column>
        <Column field="pivot.date" header="Date d'intervention" sortable></Column>
        <Column field="pivot.km" header="Kilémtrage d'intervention" sortable></Column>
        <Column  header="Prochain kilométrage" sortable>
            <template #body="slotProps">
                        <span :class="{'bg-red-500 text-white px-3 py-2':km>=slotProps.data.pivot.next_km,'bg-green-500 text-white px-3 py-2':km<slotProps.data.pivot.next_km}">
                        {{slotProps.data.pivot.next_km}}
                        </span>
            </template>
        </Column>
    </DataTable>
</template>

<style scoped>

</style>
