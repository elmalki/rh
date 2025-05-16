<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DatePicker from "primevue/datepicker";
import FloatLabel from "primevue/floatlabel";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import {saveAs} from 'file-saver';
import moment from 'moment';
import 'moment/dist/locale/fr';
import Select from "primevue/select"; // ✅ Correct path for Vite + ES Modules
moment.locale('fr'); // Import the French locale
const items = ref([])
const props = defineProps({ cars:Array,errors: Object})
const form = useForm({
    date: null,
    car_id:null
})
const search = () => {

}
const downloadState =()=> {
    /*
    axios
        .post(
            "carnetDeBordReport",
            { car_id:form.car_id,data:moment(form.date).format('MMMM YYYY'),month:moment(form.date).format('M'),year:moment(form.date).format('YYYY') }
        ).then(response => {
            form.processing = false;
        });
    return;
    *
     */
    form.processing = true
    axios
        .post(
            "carnetDeBordReport",
            { car_id:form.car_id,data:moment(form.date).format('MMMM YYYY'),month:moment(form.date).format('M'),year:moment(form.date).format('YYYY') },
            {
                responseType: "blob",
                headers: {
                    "Content-Type": "application/msword"
                }
            }
        )
        .then(response => {
            form.processing = false;
            var blob = new Blob([response.data]);
            saveAs(
                blob,
                "carnet_de_bord_" + moment(form.date).format('MMMM YYYY') + "_.xlsx"
            );
        });
}
</script>

<template>
    <AppLayout title="Etat de synthèse">
        <div class="px-4 sm:px-6 lg:px-5 bg-transparent py-5  max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Déplacements',href:route('deplacements.index'),current:false},{name:'Etat',href:route('deplacements.carnetDeBord'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex gap-4">
                <FloatLabel class="w-1/2">
                    <DatePicker class="w-full" v-model="form.date" view="month" dateFormat="MM yy" />
                    <label for="type">Date</label>
                </FloatLabel>
                <FloatLabel class="w-1/2">
                    <Select class="w-full" v-model="form.car_id" :options="cars" :optionLabel="el=>el.car_type.label+' ' +el.car_brand.label+' '+el.model+' '+el.plate"
                            option-value="id" filter/>
                    <label for="Véhicule">Véhicule</label>
                </FloatLabel>
                <PrimaryButton :disabled="!form.date||form.processing" @click="downloadState()" class="bg-orange-600 hover:bg-orange-700"
                >{{form.processing?'En cours...':'Télécharger'}}
                </PrimaryButton>
            </div>
        </div>


    </AppLayout>
</template>

<style scoped>

</style>
