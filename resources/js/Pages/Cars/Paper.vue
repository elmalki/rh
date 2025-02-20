<script setup>
import {ref, useTemplateRef, watch} from 'vue'
import {useForm} from "@inertiajs/vue3";
import PdfApp from "vue3-pdf-app";
import Select from 'primevue/select';
import "vue3-pdf-app/dist/icons/main.css";
import FloatLabel from "primevue/floatlabel";
import DatePicker from 'primevue/datepicker';
const props = defineProps({papers:Array,paper:Object})

const choose = useTemplateRef('choose')
const pdfName = ref(props.paper?.file)
const emits = defineEmits(['uploaded'])

function pickFile() {
    choose.value.click();
}

const form = useForm({id:props.paper?.paper_id,file: null,date:props.paper?.date})

watch(form,async (newval, old) => {
    emits('uploaded',{paper_id:newval.id,file:newval.file,date:newval.date})
})
function onFilePicked(e) {
    const file = e.target.files[0];
    if (file !== undefined) {
        const fr = new FileReader();
        pdfName.value = file.name;
        fr.readAsDataURL(file);
        fr.addEventListener("load", () => {
            form.file = fr.result;
            // this is an pdf file that can be sent to server...
            // console.log(el);
        });
    } else {
        //this.pdfsNames = [];
        //this.pdfsUrls = [];
    }
}

</script>

<template>
    <div>
        <div class="flex gap-1">
            <FloatLabel class="w-1/4">
                <Select class="w-full" v-model="form.id" :options="papers" optionLabel="label"
                        option-value="id"/>
                <label for="part_types">Type de pièce</label>
            </FloatLabel>
            <FloatLabel class="w-1/5 mx-2">
                <DatePicker v-model="form.date" lang="" date-format="yy-mm-dd" class="w-full"/>
                <label for="date">Date de fin de validité</label>
            </FloatLabel>
            <input type="text" placeholder="Choisir le PDF" @click="pickFile" v-model="pdfName"
                   class="block py-2.5 px-0 w-3/5 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
            <input type="file" style="display: none" ref="choose" @change="onFilePicked">
        </div>

        <div v-if="false" class="my-10 border border-black mx-auto" :style="{ width: '900px', height: '700px'}">
            <PdfApp :pdf="form.file"></PdfApp>
        </div>
    </div>
</template>
<style scoped>

</style>
