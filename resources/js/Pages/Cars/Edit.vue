<template>
    <AppLayout title="Vihécule-Modification">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs  class="mb-4"
                              :pages="[{name:'Véhicule',href:route('cars.index'),current:false},{name:'Modifier le véhicule',href:route('cars.update',{car:car.id}),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.fuel_id" :options="fuels" optionLabel="label"
                                option-value="id"/>
                        <label for="Marque">Caburant</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.car_brand_id" :options="brands" optionLabel="label"
                                option-value="id" filter/>
                        <label for="Marque">Marque</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select v-model="form.car_type_id" display="chip" :options="types" option-value="id"
                                optionLabel="label" filter
                                class="w-full"/>
                        <label for="Type">Type véhicule</label>
                    </FloatLabel>
                </div>

                <div class="flex  gap-1 mt-1">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.model" type="text" class="w-full"/>
                        <label>Modèle</label>
                        <Message v-if="errors.model" severity="error" size="small" variant="simple">{{
                                errors.model
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.plate" type="text" class="w-full"/>
                        <label>Immatricule</label>
                        <Message v-if="errors.plate" severity="error" size="small" variant="simple">{{
                                errors.plate
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.n_chassis" type="text" class="w-full"/>
                        <label>N° Chassis</label>
                        <Message v-if="errors.n_chassis" severity="error" size="small" variant="simple">{{
                                errors.n_chassis
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div class="flex  gap-1 mt-1">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.kilometrage" type="number" class="w-full" disabled/>
                        <label>Kilométrage</label>
                        <Message v-if="errors.kilometrage" severity="error" size="small" variant="simple">{{
                                errors.kilometrage
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.motor" type="text" class="w-full"/>
                        <label>Moteur</label>
                        <Message v-if="errors.motor" severity="error" size="small" variant="simple">{{
                                errors.motor
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.tank_capacity" type="number" class="w-full"/>
                        <label>Capacité réservoir</label>
                        <Message v-if="errors.model" severity="error" size="small" variant="simple">{{
                                errors.model
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div>
                    <button @click="addPaper()" class="bg-blue-600  px-2 py-2 rounded-lg items-center text-white  justify-center hover:bg-blue-700"> Ajouter des pièces</button>
                </div>
                <div v-for="(paper,i) in items" class="w-full" :key="paper.id">
                    <div class="flex gap-1 w-full mt-2">
                        <button @click="removePaper(i)"  class=" bg-red-600  rounded-lg size-10 items-center text-white  justify-center hover:bg-red-700">x</button>
                        <Paper class="w-full" :papers="papers" :paper="paper?.pivot"  @uploaded="value=>form.papers[i]={...form.papers[i],...value}"></Paper>
                    </div>
                </div>

                <div class="flex justify-end">
                    <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Modifier</PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Select from 'primevue/select';
import FloatLabel from 'primevue/floatlabel';
import { ref, nextTick,computed} from 'vue'
import AppLayout from "@/Layouts/AppLayout.vue";
import {useForm} from "@inertiajs/vue3";
import PdfApp from "vue3-pdf-app";
import "vue3-pdf-app/dist/icons/main.css";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Paper from "@/Pages/Cars/Paper.vue";
let id = 100;
const props = defineProps({fuels:Array,brands: Array,types:Array, errors: Object,car:Object,papers:Array});
const form = useForm({papers:[],...props.car})

const items = computed(() => {
    return form.papers
})
const add = () => {
    form.put(route('cars.update',{car:form.id}), form)
}
const addPaper = ()=>{
    id++;
    form.papers.push({id:id})
}
const removePaper = (index)=>{
    form.papers.splice(index,1)
}
</script>


