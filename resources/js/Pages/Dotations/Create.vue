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

const props = defineProps({cars:Array,personnels:Array,errors: Object})
const form = useForm({
    value: null,
    label: null,
    car_id:null,
    personnel_id:null
})
const add = () => {
    form.post(route('dotations.store'), form)
}
</script>

<template>
    <AppLayout title="Ajout de dotation">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Dotations',href:route('dotations.index'),current:false},{name:'Ajout',href:route('dotations.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.label" type="text" class="w-full"/>
                        <label>Libellé</label>
                        <Message v-if="errors.label" severity="error" size="small" variant="simple">{{
                                errors.label
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.value" type="number" step="0.01" class="w-full"/>
                        <label>Montant</label>
                        <Message v-if="errors.value" severity="error" size="small" variant="simple">{{
                                errors.value
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.car_id" :options="cars" optionLabel="plate"
                                option-value="id" filter/>
                        <label for="car">Véhicule</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.personnel_id" :options="personnels" optionLabel="fullname"
                                option-value="id" filter/>
                        <label for="personnel">Fonctionnaire</label>
                    </FloatLabel>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
                </div>
            </div>

        </div>
    </AppLayout>
</template>

<style scoped>
</style>
