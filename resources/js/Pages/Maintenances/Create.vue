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
const props = defineProps({cars:Array,maintenance_types:Array,errors: Object})
const form = useForm({
    date:null,
    kilometrage:null,
    car_id:null,
    maintenance_type_id:null
})
const add = () => {
    form.post(route('maintenances.store'), form)
}
</script>

<template>
    <AppLayout title="Ajout de maintenance">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs  class="mb-4"
                              :pages="[{name:'Maintenances',href:route('maintenances.index'),current:false},{name:'Ajout de maintenance',href:route('maintenances.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.car_id" :options="cars" optionLabel="plate"
                                option-value="id" filter/>
                        <label for="Véhicule">Véhicule</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.maintenance_type_id" :options="maintenance_types" optionLabel="label"
                                option-value="id" filter/>
                        <label for="type">Type de maintenance</label>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.kilometrage" type="number" class="w-full"/>
                        <label>Kilométrage</label>
                        <Message v-if="errors.plate" severity="error" size="small" variant="simple">{{
                                errors.plate
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <DatePicker v-model="form.date" lang="" date-format="yy-mm-dd" class="w-full"/>
                        <label for="milage">Date d'intervention</label>
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
