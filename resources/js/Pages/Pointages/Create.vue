<template>
    <AppLayout title="Pointage-Ajout">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Pointages',href:route('pointages.index'),current:false},{name:'Ajout de pointage',href:route('pointages.create'),current:true}]"></Breadcrumbs>

            </div>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 w-full text-center  decoration-indigo-400 underline underline-offset-1">Pointage journalier des ouvriers</h2>
            <div class="w-full">
                <FloatLabel class="w-full ">
                    <InputNumber required v-model="form.wage" step="0.01" inputId="currency-morocco" mode="currency" currency="MAD" currencyDisplay="code" locale="fr-FR" fluid />
                    <label>Salaire journalier</label>
                </FloatLabel>
                <Message v-if="errors.wage" severity="error" size="small" variant="simple">{{
                        errors.wage
                    }}
                </Message>
            </div>
            <div class="mx-auto mt-5 max-w-7xl grid grid-cols-4 gap-4 items-stretch">
                <dv class="">
                    <DatePicker
                        v-model="form.date"
                        inline
                        format="d-m-y"
                        class="w-1/3 sm:w-[30rem]"
                    />
                </dv>
                <div class="col-span-3 h-full">
                    <FloatLabel class="h-full">
                        <MultiSelect id="over_label" v-model="form.workers" :options="workers"
                                     option-label="nom_complet" filter display="chip" class="w-full h-full">
                            <template #chip="{value}">
                            <span class="bg-amber-400 text-sm px-2 py-1 text-black justify-center items-center">{{ value.nom_complet }}
                            <button
                                @click.stop="removeChip(value)"
                                class="ml-1 text-black text-md run dev  "
                            >X
                            </button>
                                </span>
                            </template>
                        </MultiSelect>
                        <label for="over_label">Ouvriers</label>
                    </FloatLabel>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
            </div>

        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import DatePicker from "primevue/datepicker";
import MultiSelect from "primevue/multiselect";
import FloatLabel from "primevue/floatlabel"
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import moment from "moment";
import InputNumber from "primevue/inputnumber";
import Message from "primevue/message";
import {XCircleIcon} from "@heroicons/vue/24/outline";

const props = defineProps({wage:Number,workers: Array,errors:Object})
const form = useForm({
    wage:props.wage,
    workers: [],
    date:new Date(),
})
const removeChip = (item) => {
    form.pointages = form.pointages.filter(el => el.id != item.id)
}
const add = ()=>{
    form.post(route('pointages.store'),form)
}
</script>
