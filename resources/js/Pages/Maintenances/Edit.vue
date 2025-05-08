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
import Editor from "primevue/editor";
import MaintenanceTypeInput from "@/Pages/MaintenanceTypes/MaintenanceTypeInput.vue";
const props = defineProps({maintenance:Object,cars:Array,maintenance_types:Array,errors: Object})
const form = useForm(props.maintenance)
let id = -1000;
const add = () => {
    form.put(route('maintenances.update',{maintenance:form.id}), form)
}
const addMaintenanceType  =()=>{
    id++;
    form.maintenance_types.push({id: id})
}
const removeMaintenanceType = (index) => {
    form.maintenance_types.splice(index, 1)
}
</script>

<template>
    <AppLayout title="Ajout de maintenance">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs  class="mb-4"
                              :pages="[{name:'Maintenances',href:route('maintenances.index'),current:false},{name:'Modifier de maintenance',href:route('maintenances.edit',{maintenance:maintenance.id}),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.n_bon" type="text" class="w-full"/>
                            <label>N° Bon</label>

                        </FloatLabel>
                        <Message v-if="errors.n_bon" severity="error" size="small" variant="simple">{{
                                errors.n_bon
                            }}
                        </Message>
                    </div>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.car_id" :options="cars" :optionLabel="el=>el.car_type.label+' ' +el.car_brand.label+' '+el.model+' '+el.plate"
                                option-value="id" filter/>
                        <label for="Véhicule">Véhicule</label>
                    </FloatLabel>
                    <div class="flex-col w-full">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.montant" type="number" step="0.01" class="w-full" min="0"/>
                            <label>Montant</label>

                        </FloatLabel>
                        <Message v-if="errors.montant" severity="error" size="small" variant="simple">{{
                                errors.montant
                            }}
                        </Message>
                    </div>
                </div>
                <div class="flex gap-1 mt-3">
                    <div class="flex-col w-full">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.kilometrage" type="number" class="w-full" :min="car?car.kilometrage:0"/>
                            <label>Kilométrage</label>

                        </FloatLabel>
                        <Message v-if="errors.kilometrage" severity="error" size="small" variant="simple">{{
                                errors.plate
                            }}
                        </Message>
                    </div>
                    <FloatLabel class="w-full">
                        <DatePicker v-model="form.date" lang="" date-format="yy-mm-dd" class="w-full"/>
                        <label for="milage">Date d'intervention</label>
                    </FloatLabel>
                </div>
                <FloatLabel class="w-full mt-3">
                    <Editor v-model="form.observation" placeholder="Observations" editorStyle="height: 200px" />
                </FloatLabel>
                <div>
                    <button @click="addMaintenanceType()"
                            class="bg-blue-600  px-2 py-2 rounded-lg items-center text-white  justify-center hover:bg-blue-700">
                        Ajouter
                    </button>
                </div>
                <div v-for="(item,i) in form.maintenance_types" class="w-full" :key="item.id">
                    <div class="flex gap-1 w-full mt-2">
                        <button @click="removeMaintenanceType(i)"
                                class=" bg-red-600  rounded-lg size-10 items-center text-white  justify-center hover:bg-red-700">
                            x
                        </button>
                        <MaintenanceTypeInput class="w-full" :maintenance_types="maintenance_types" :data="item.pivot"
                                              @uploaded="value=>form.maintenance_types[i]={...form.maintenance_types[i],...value}"></MaintenanceTypeInput>
                    </div>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Modifier</PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
