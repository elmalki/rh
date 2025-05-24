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
            "WorkersPayment",
            { data:moment(form.date).format('MMMM YYYY'),month:moment(form.date).format('M'),year:moment(form.date).format('YYYY') },
            {
                responseType: "blob",
                headers: {
                    Accept: "application/pdf"
                }
            }
        )
        .then(response => {
            form.processing = false;
            var blob = new Blob([response.data]);
            saveAs(
                blob,
                "paiement_" + moment(form.date).format('MMMM YYYY') +  "_.pdf"
            );
        }).catch((e)=>{
            console.table(e)
            alert(e.message)
        form.processing=false;
    });
}
</script>

<template>
    <AppLayout title="Etat de synthèse">
        <div class="px-4 sm:px-6 lg:px-5 bg-transparent py-5  max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Pointages',href:route('pointages.index'),current:false},{name:'Etat mensuelle',href:route('pointages.payment'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex gap-4">
                <FloatLabel class="w-1/2">
                    <DatePicker class="w-full" v-model="form.date" view="month" dateFormat="MM yy" :max-date="new Date()" />
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
