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
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'
import Column from "primevue/column";
import DataTable from "primevue/datatable";
const props = defineProps({dotation:Object,budget:Number,cars:Array,personnels:Array,errors: Object})
const form = useForm({...props.dotation})
const car = props.cars.filter(el=>el.id===props.dotation.car_id)[0]
const add = () => {
    form.put(route('dotations.update',{dotation:form.id}), form)
}
</script>

<template>
    <AppLayout title="Ajout de dotation">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Dotations',href:route('dotations.index'),current:false},{name:'Modifier',href:route('dotations.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="border-l-4 border-red-400 bg-red-50 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <ExclamationTriangleIcon class="size-7 text-red-400" aria-hidden="true" />
                    </div>
                    <div class="ml-3">
                        <p class="text-lg text-yellow-700">
                            Le crédit restant du budget est de:
                            {{ ' ' }}
                            <span href="#" class="font-medium text-lg text-red-700 underline hover:text-red-600">{{budget}} dhs</span>
                        </p>
                    </div>
                </div>
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
                        <InputText v-model="form.value" type="number" step="0.01" :max="budget" class="w-full"/>
                        <label>Montant</label>
                        <Message v-if="form.value>budget" severity="error" size="small" variant="simple">
                            Vous avez dépasser le budget ({{budget}})
                        </Message>
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
                        <InputText class="w-full" v-model="form.km" type="number" optionLabel="fullname"
                                   option-value="id" filter/>
                        <label for="personnel">Kilométrage</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.personnel_id" :options="personnels" optionLabel="fullname"
                                option-value="id" filter/>
                        <label for="personnel">Fonctionnaire</label>
                    </FloatLabel>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Modifier</PrimaryButton>
                </div>
            </div>
            <DataTable v-if ="car?.maintenance_types.length" :value="car?.maintenance_types" class="mt-6" tableStyle="min-width: 50rem">
                <Column  header="Type de maintenance" sort-field="label" sortable>
                    <template #body="slotProps">
                        {{slotProps.data.label}}({{slotProps.data.kilometrage}}km)
                    </template>
                </Column>
                <Column field="pivot.date" header="Date d'intervention" sortable></Column>
                <Column field="pivot.km" header="Kilémtrage d'intervention" sortable></Column>
                <Column  header="Prochain kilométrage" sortable>
                    <template #body="slotProps">
                        <span :class="{'bg-red-500 text-white px-3 py-2':form.km>=slotProps.data.pivot.next_km,'bg-green-500 text-white px-3 py-2':form.km<slotProps.data.pivot.next_km}">
                        {{slotProps.data.pivot.next_km}}
                        </span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </AppLayout>
</template>

<style scoped>
</style>
