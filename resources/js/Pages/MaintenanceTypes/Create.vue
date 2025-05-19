<template>
        <AppLayout title="Type de maintenance-Ajout">
            <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
                <div class="sm:flex sm:items-center">
                    <Breadcrumbs  class="mb-4"
                                  :pages="[{name:'Type de Maintenance',href:route('maintenancetypes.index'),current:false},{name:'Ajouter',href:route('maintenancetypes.create'),current:true}]"></Breadcrumbs>

                </div>
                <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4"   @keydown.enter="createOrEditItem()">
                            <div class="mt-4" >
                                <TextInput
                                    ref="label"
                                    v-model="form.label"
                                    type="text"
                                    class="mt-1 block w-3/4 border"
                                    placeholder="Libellé"
                                    autocomplete="Libellé"
                                />
                                <Message v-if="errors.label" severity="error" size="small" variant="simple">
                                    {{errors.label}}
                                </Message>
                            </div>
                            <div class="mt-4" >
                                <TextInput
                                    ref="label"
                                    v-model="form.kilometrage"
                                    type="number"
                                    class="mt-1 block w-3/4 border"
                                    placeholder="Kilométrage"
                                    autocomplete="Kilométrage"
                                />
                                <Message v-if="errors.kilometrage" severity="error" size="small" variant="simple">
                                    {{ errors.kilometrage }}
                                </Message>

                            </div>
                            <div class="mt-4" >
                                <Select placeholder="Catégorie" :options="categories" option-label="label" option-value="id" filter v-model="form.maintenance_category_id" class="mt-1 block w-3/4 border border-xl"></Select>

                                <Message v-if="errors.kilometrage" severity="error" size="small" variant="simple">
                                    {{ errors.kilometrage }}
                                </Message>

                            </div>
                    <div class="flex justify-end">
                        <PrimaryButton @click="createOrEditItem()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
                    </div>
                </div>
            </div>
        </AppLayout>
</template>
<script setup lang="ts">
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Message from "primevue/message";
import Select from "primevue/select";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useForm} from "@inertiajs/vue3";
const props = defineProps({categories:Array, errors: Object});
const form = useForm({
    label: '',
    kilometrage: null,
    maintenance_category_id:null,
    processing: false,
    errors: []
});
const createOrEditItem = ()=>{
    form.post(route('maintenancetypes.store',form))
}
</script>
