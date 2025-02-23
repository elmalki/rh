<script setup>
import {ref, useTemplateRef, watch} from 'vue'
import {useForm} from "@inertiajs/vue3";
import Select from 'primevue/select';
import MultiSelect from 'primevue/multiselect';
import "vue3-pdf-app/dist/icons/main.css";
import FloatLabel from "primevue/floatlabel";
const props = defineProps({equipe:Object,cars:Array,personnels:Object})

const emits = defineEmits(['uploaded'])


const form = useForm({car_id:props.equipe?.car?.id,driver_id:props.equipe?.driver?.id,personnels_ids:props.equipe?.personnels?.map(el=>el.id)||[]})
watch(form,async (newval, old) => {
    emits('uploaded',{car_id:newval.car_id,driver_id:newval.driver_id,personnels_ids:newval.personnels_ids})
})

</script>

<template>
    <div>
        <div class="flex gap-1">
            <FloatLabel class="w-1/4">
                <Select class="w-full h-20 items-center text-center" as="div" v-model="form.car_id" :options="cars" optionLabel="plate"
                        option-value="id"/>
                <label for="cars">Véhicule</label>
            </FloatLabel>
            <FloatLabel class="w-1/4">
                <Select class="w-full h-20 items-center text-center" as="div" v-model="form.driver_id" :options="personnels" optionLabel="fullname"
                        option-value="id" filter/>
                <label for="driver">Chauffeur</label>
            </FloatLabel>
            <FloatLabel class="w-full">
                <MultiSelect class="w-full h-20 items-center" v-model="form.personnels_ids" :options="personnels" optionLabel="fullname"
                        option-value="id"  filter display="chip">
                </MultiSelect>
                <label for="personnels">Fonctionnaire</label>
            </FloatLabel>
        </div>

    </div>
</template>
