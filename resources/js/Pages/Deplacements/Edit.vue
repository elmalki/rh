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
import {computed} from "vue";
const props = defineProps({deplacement:Object,cars:Array,personnels:Array,errors: Object})
const form = useForm({
    ...props.deplacement
})
const car = computed(()=>{
    const car = form.car_id?props.cars.filter(el=>el.id===form.car_id)[0]:null;
    form.km_depart = car.kilometrage
    return car
})

const add = () => {
    form.put(route('deplacements.update',{deplacement:form.id}), form)
}

</script>

<template>
    <AppLayout title="Déplacement-Modification">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs  class="mb-4"
                              :pages="[{name:'Déplacements',href:route('deplacements.index'),current:false},{name:'Modification de deplacement',href:route('deplacements.edit',{deplacement:deplacement.id}),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.motif" type="text" class="w-full"/>
                        <label>Motif</label>

                    </FloatLabel>
                    <Message v-if="errors.motif" severity="error" size="small" variant="simple">{{
                            errors.motif
                        }}
                    </Message>
                    </div>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.car_id" :options="cars" :optionLabel="el=>el.car_type.label+' ' +el.car_brand.label+' '+el.model+' '+el.plate"
                                option-value="id" filter/>
                        <label for="Véhicule">Véhicule</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.personnel_id" :options="personnels" optionLabel="fullname"
                                option-value="id" filter/>
                        <label for="conducteur">Conducteur</label>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <div class="flex-col w-full">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.km_depart" type="number"  class="w-full" min="0"/>
                            <label>Kilométrage de départ</label>
                        </FloatLabel>
                        <Message v-if="errors.km_depart" severity="error" size="small" variant="simple">{{
                                errors.km_depart
                            }}
                        </Message>
                    </div>
                    <div class="flex-col w-full">
                        <FloatLabel class="w-full">
                            <InputText v-model="form.km_arrivee" type="number"  class="w-full" min="0"/>
                            <label>Kilométrage d'arrivée</label>
                        </FloatLabel>
                        <Message v-if="errors.km_arrivee" severity="error" size="small" variant="simple">{{
                                errors.km_arrivee
                            }}
                        </Message>
                    </div>
                    <FloatLabel class="w-full">
                        <DatePicker v-model="form.date" dateFormat="dd/mm/yy"  class="w-full"/>
                        <label for="milage">Date</label>
                    </FloatLabel>
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
