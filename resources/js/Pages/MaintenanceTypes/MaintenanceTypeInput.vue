<script setup>
import {ref, useTemplateRef, watch} from 'vue'
import {useForm} from "@inertiajs/vue3";
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import "vue3-pdf-app/dist/icons/main.css";
import FloatLabel from "primevue/floatlabel";
const props = defineProps({data:Object,maintenance_types:Array})

const emits = defineEmits(['uploaded'])


const form = useForm({maintenance_type_id:props.data?.maintenance_type_id,montant:props.data?.montant,observation:props.data?.observation})
watch(form,async (newval, old) => {
    emits('uploaded',{maintenance_type_id:newval.maintenance_type_id,montant:newval.montant,observation:newval.observation})
})

</script>

<template>
    <div>
        <div class="flex gap-1">
            <FloatLabel class="w-1/4">
                <Select class="w-full items-center text-center" as="div" v-model="form.maintenance_type_id" :options="maintenance_types" :optionLabel="item=>item.label+ (item.kilometrage?' ( '+item.kilometrage+' Km )':'')"
                        option-value="id"/>
                <label for="cars">Type de maintenance</label>
            </FloatLabel>
                <FloatLabel >
                    <InputText v-model="form.montant" type="number" step="0.01" class="w-full"/>
                    <label>Montant</label>
                </FloatLabel>
            <FloatLabel >
                <InputText v-model="form.observation" type="text" class="w-full"/>
                <label>Observation</label>
            </FloatLabel>
        </div>

    </div>
</template>
