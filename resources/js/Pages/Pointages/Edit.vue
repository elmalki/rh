<template>
    <AppLayout title="Pointage-Modifications">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Pointages',href:route('pointages.index'),current:false},{name:'Ajout de pointage',href:route('pointages.create'),current:true}]"></Breadcrumbs>

            </div>
            <h2 class="text-2xl font-bold mb-4 text-gray-800 w-full text-center  decoration-indigo-400 underline underline-offset-1">Pointage journalier des ouvriers {{moment(props.item.date, "YYYY-MM-DD").format("DD/MM/YYYY")}}</h2>
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
                        date-format="yy-mm-dd"
                        inline
                        class="w-1/3 sm:w-[30rem]"
                    />
                </dv>
                <div class="col-span-3 h-full">
                    <FloatLabel class="h-full">
                        <MultiSelect id="over_label" v-model="form.workers" :options="workers"
                                     option-label="nom_complet" filter display="chip"
                                     class="grid grid-cols-4 w-full h-full">
                            <template #value="slotProps">
                                <div class="grid grid-cols-5 gap-2 p-2">
                            <span
                                v-for="(option, index) in slotProps.value"
                                :key="index"
                                class="bg-amber-400 text-sm px-2 py-1 text-black justify-center items-center rounded-full flex justify-between"
                            >
                              {{ option.nom_complet }}
                                 <button
                                     @click.stop="removeChip(option)"
                                     class="ml-3 text-black text-md run dev  "
                                 >X
                                                </button>
                            </span>
                                </div>
                            </template>
                        </MultiSelect>
                        <label for="over_label">Ouvriers</label>
                    </FloatLabel>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Modifier</PrimaryButton>
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
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import moment from "moment";
import InputNumber from "primevue/inputnumber";
import Message from "primevue/message";

const props = defineProps({item: Object, workers: Array, errors: Object})
const form = useForm({
    ...props.item,
    ids:[],
})
const removeChip = (item) => {
    form.workers = form.workers.filter(el => el.id != item.id)
}
const add = ()=>{
    form.ids = form.workers.map(el=>el.id)
    form.put(route('pointages.update',{pointage:form.id}),form)
}
</script>
