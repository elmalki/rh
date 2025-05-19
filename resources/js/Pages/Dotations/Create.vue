<script setup>
import Maintenances from "@/Pages/Cars/Maintenances.vue"
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
import {computed} from "vue";
const props = defineProps({budget:Number,cars:Array,personnels:Array,errors: Object})
const form = useForm({
    value: null,
    label: null,
    n_bon: null,
    car_id:null,
    km:null,
    price:0,
    personnel_id:null
})
const car = computed(()=>{
    const car = form.car_id?props.cars.filter(el=>el.id===form.car_id)[0]:null;
    console.log(car?.kilometrage)
    form.km = car?.kilometrage
    return car
})
const add = () => {
    form.post(route('dotations.store'), form)
}
</script>

<template>
    <AppLayout title="Dotation-Ajout">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Dotations',href:route('dotations.index'),current:false},{name:'Ajout',href:route('dotations.create'),current:true}]"></Breadcrumbs>

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
                        <InputText v-model="form.n_bon" type="text" class="w-full"/>
                        <label>N°Bon</label>
                        <Message v-if="errors.n_bon" severity="error" size="small" variant="simple">{{
                                errors.n_bon
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
                    <FloatLabel class="w-full">
                        <InputText v-model="form.price" type="number" step="0.01" min="0" class="w-full"/>
                        <label>Prix de litre</label>
                        <Message v-if="errors.price" severity="error" size="small" variant="simple">{{
                                errors.price
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
                    <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
                </div>
            </div>
            <Maintenances v-if ="car?.maintenance_types.length" :data="car?.maintenance_types" :km="form.km"></Maintenances>
        </div>
    </AppLayout>
</template>

<style scoped>
</style>
