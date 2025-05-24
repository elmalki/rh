<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Select from "primevue/select";
import FloatLabel from "primevue/floatlabel";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import {useForm} from "@inertiajs/vue3";
import DatePicker from 'primevue/datepicker';
import InputText from "primevue/inputtext";
import Message from "primevue/message";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({errors: Object})
const form = useForm({
    cnie: null,
    nom: null,
    prenom: null,
    sexe:'Homme',
})
const add = () => {
    form.post(route('dailyworkers.store'), form)
}
</script>

<template>
    <AppLayout title="Ouvrier-Ajout">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Ouvriers',href:route('dailyworkers.index'),current:false},{name:'Ajout de ouvrier',href:route('dailyworkers.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.prenom" type="text" class="w-full"/>
                        <label>Prénom</label>
                        <Message v-if="errors.prenom" severity="error" size="small" variant="simple">{{
                                errors.prenom
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.nom" type="text" class="w-full"/>
                        <label>Nom</label>
                        <Message v-if="errors.nom" severity="error" size="small" variant="simple">{{
                                errors.nom
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3" >
                    <FloatLabel class="w-full">
                        <InputText v-model="form.cnie" type="text" class="w-full"/>
                        <label>CNIE</label>
                        <Message v-if="errors.cnie" severity="error" size="small" variant="simple">{{
                                errors.cnie
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.sexe" :options="['Homme','Femme']" filter/>
                        <label for="Genre">Sexe</label>
                    </FloatLabel>
                </div>
            </div>
            <div class="flex justify-end">
                <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
