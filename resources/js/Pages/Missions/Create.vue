<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Equipe from '@/Pages/Missions/Equipe.vue'
import FloatLabel from "primevue/floatlabel";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import {useForm} from "@inertiajs/vue3";
import DatePicker from 'primevue/datepicker';
import InputText from "primevue/inputtext";
import Message from "primevue/message";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Select from "primevue/select";


const props = defineProps({cars: Array, personnels: Array, errors: Object,destinations:Array})
const form = useForm({
    mission: null,
    depart_date: null,
    return_date: null,
    destination_id: null,
    equipes: [],
    cars: [],
    personnels: []
})
let id = -1000;
const addEquipe = () => {
    id++;
    form.equipes.push({id: id})
}
const removeEquipe = (index) => {
    form.equipes.splice(index, 1)
}
const add = () => {
    form.post(route('missions.store'), form)
}
</script>

<template>
    <AppLayout title="Mission-Ajout">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Missions',href:route('missions.index'),current:false},{name:'Ajout',href:route('missions.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                        <FloatLabel >
                            <InputText v-model="form.mission" type="text" class="w-full"/>
                            <label>Objet</label>
                        </FloatLabel>
                        <Message v-if="errors.mission" severity="error" size="small" variant="simple">{{
                                errors.mission
                            }}
                        </Message>
                    </div>

                </div>
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                        <FloatLabel>
                            <Select class="w-full items-center text-center" as="div" v-model="form.destination_id" :options="destinations" optionLabel="label"
                                    option-value="id" filter/>
                            <label for="destination">Destination</label>
                        </FloatLabel>
                        <Message v-if="errors.destination_id" severity="error" size="small" variant="simple">{{
                                errors.destination_id
                            }}
                        </Message>
                    </div>
                    <div class="w-full">
                        <FloatLabel>
                            <DatePicker v-model="form.depart_date" lang="" date-format="yy-mm-dd" class="w-full"/>
                            <label for="date">Date de départ</label>
                        </FloatLabel>
                        <Message v-if="errors.depart_date" severity="error" size="small" variant="simple">{{
                                errors.depart_date
                            }}
                        </Message>
                    </div>
                    <div class="w-full">
                    <FloatLabel class="ml-1">
                        <DatePicker v-model="form.return_date" lang="" date-format="yy-mm-dd" class="w-full"/>
                        <label for="date">Date de retour</label>
                    </FloatLabel>
                        <Message v-if="errors.return_date" severity="error" size="small" variant="simple">{{
                                errors.return_date
                            }}
                        </Message>
                    </div>
                </div>
                <div>
                    <button @click="addEquipe()"
                            class="bg-blue-600  px-2 py-2 rounded-lg items-center text-white  justify-center hover:bg-blue-700">
                        Ajouter une équipe
                    </button>
                </div>
                <div v-for="(equipe,i) in form.equipes" class="w-full" :key="equipe.id">
                    <div class="flex gap-1 w-full mt-2">
                        <button @click="removeEquipe(i)"
                                class=" bg-red-600  rounded-lg size-20 items-center text-white  justify-center hover:bg-red-700">
                            x
                        </button>
                        <Equipe class="w-full" :cars="cars" :personnels="personnels"
                                @uploaded="value=>form.equipes[i]={...form.equipes[i],...value}"></Equipe>
                    </div>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="add()" class=" text-2xl bg-green-600 hover:bg-green-700">Ajouter
                    </PrimaryButton>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
</style>
