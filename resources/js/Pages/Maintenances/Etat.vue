<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Select from "primevue/select";
import FloatLabel from "primevue/floatlabel";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import {useForm} from "@inertiajs/vue3";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import {saveAs} from 'file-saver';
import moment from 'moment';
import 'moment/dist/locale/fr'; // ✅ Correct path for Vite + ES Modules
moment.locale('fr'); // Import the French locale
const items = ref([])
const props = defineProps({maintenance_types: Array, errors: Object})
const form = useForm({
    maintenance_type_id: null
})
const search = () => {
    axios
        .post('etat', form)
        .then(response => {
            items.value = response.data
        })
}
const downloadState =()=> {
    form.processing = true;
    axios
        .post(
            "etatPdf",
            { date:moment().format('dddd DD MMMM Y'),maintenance_type_id:form.maintenance_type_id },
            {
                responseType: "blob",
                headers: {
                    Accept: "application/pdf"
                }
            }
        )
        .then(response => {
            form.processing=false;
            var blob = new Blob([response.data], { type: "application/pdf" });
            saveAs(
                blob,
                "etat_" + moment().format("d_M_Y") + "_.pdf"
            );
        });
}
</script>

<template>
    <AppLayout title="Etat de synthèse">
        <div class="px-4 sm:px-6 lg:px-5 bg-transparent py-5  max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Maintenances',href:route('maintenances.index'),current:false},{name:'Etat',href:route('maintenances.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex gap-4">
                <FloatLabel class="w-1/2">
                    <Select class="w-full" v-model="form.maintenance_type_id" :options="maintenance_types"
                            optionLabel="label"
                            option-value="id" filter/>
                    <label for="type">Type de maintenance</label>
                </FloatLabel>
                <div class="flex justify-end">
                    <PrimaryButton @click="search()" class="bg-green-600 hover:bg-green-700"
                                   :disabled="!form.maintenance_type_id">Chercher
                    </PrimaryButton>
                </div>
                <PrimaryButton v-if="items.length" @click="downloadState()" :disabled="form.processing" class="bg-orange-600 hover:bg-orange-700"
                >Télécharger {{form.processing?'En cours...':'Téléchargement'}}
                </PrimaryButton>
            </div>
        </div>

        <div v-if="items.length" class="py-10 px-3">

            <h1 class="text-3xl font-light text-center py-2">Etat {{ items[0].maintenance_types[0].label }} véhicule commune Massa</h1>
            <h1 class="text-3xl font-light text-center py-2 capitalize">{{moment().format('dddd DD MMMM Y')}}</h1>

            <DataTable  :value="items" showGridlines tableStyle="min-width: 50rem">
                <Column header="N°" headerStyle="width:3rem">
                    <template #body="slotProps">
                        {{ slotProps.index + 1 }}
                    </template>
                </Column>
                <Column header="Véhicule">
                    <template #body="slotProps">
                        {{ slotProps.data.car_type.label }} {{ slotProps.data.car_brand.label }}
                        {{ slotProps.data.model }}
                    </template>
                </Column>
                <Column field="plate" header="Immatriculation"></Column>
                <Column header="Ancien Kilométrage">
                    <template #body="slotProps">
                        {{ slotProps.data.maintenance_types[0].pivot.km }}
                    </template>
                </Column>
                <Column header="Date">
                    <template #body="slotProps">
                        {{ slotProps.data.maintenance_types[0].pivot.date }}
                    </template>
                </Column>
                <Column field="kilometrage" header="Index compteur actuel"></Column>
                <Column header="Restant en Km">
                    <template #body="slotProps">
                        {{ slotProps.data.maintenance_types[0].pivot.next_km - slotProps.data.kilometrage }}
                    </template>
                </Column>
                <Column header="Observations" style="min-width: 200px">
                    <template #body="slotProps">
                        <span v-html="slotProps.data.maintenance_types[0].pivot.observation"></span>
                    </template>
                </Column>

            </DataTable>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
