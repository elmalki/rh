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
import 'moment/dist/locale/fr'; // ✅ Correct path for Vite + ES Modules
moment.locale('fr'); // Import the French locale
const items = ref([])
const props = defineProps({ errors: Object})
const form = useForm({
   date: null
})
const search = () => {

}
const downloadState =()=> {
    form.processing = true
    axios
        .post(
            "monthlyReport",
            { data:moment(form.date).format('MMMM YYYY'),month:moment(form.date).format('M'),year:moment(form.date).format('YYYY') },
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
                "etat_" + moment(form.date).format('MMMM YYYY') + "_.xlsx"
            );
        }).catch((e)=>{
        form.processing=false;
    });
}
</script>

<template>
    <AppLayout title="Etat de synthèse">
        <div class="px-4 sm:px-6 lg:px-5 bg-transparent py-5  max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Maintenances',href:route('maintenances.index'),current:false},{name:'Etat mensuelle',href:route('maintenances.etatmensuelle'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex gap-4">
                <FloatLabel class="w-1/2">
                    <DatePicker class="w-full" v-model="form.date" view="month" dateFormat="MM yy" />
                    <label for="type">Date</label>
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
