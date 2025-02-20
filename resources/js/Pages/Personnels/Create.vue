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

const props = defineProps({departments: Array, errors: Object})
const situations = ['Célébataire', 'Marié(e)', 'Remarié(e)', 'Divorcé(e)', 'Veuf(ve)']
const form = useForm({
    ppr: null,
    cnie: null,
    firstname: null,
    lastname: null,
    recruitment_date: null,
    birthday: null,
    driving_license: null,
    is_driver: false,
    is_married: false,
    children: 0,
    situation: 'Célébataire',
    department_id: null
})
const add = () => {
    form.post(route('personnels.store'), form)
}
</script>

<template>
    <AppLayout title="Ajout de maintenance">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Fonctinnaires',href:route('personnels.index'),current:false},{name:'Ajout de fonctionnaire',href:route('personnels.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.ppr" type="text" class="w-full"/>
                        <label>PPR</label>
                        <Message v-if="errors.ppr" severity="error" size="small" variant="simple">{{
                                errors.ppr
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.cnie" type="text" class="w-full"/>
                        <label>CNIE</label>
                        <Message v-if="errors.cnie" severity="error" size="small" variant="simple">{{
                                errors.cnie
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.firstname" type="text" class="w-full"/>
                        <label>Prénom</label>
                        <Message v-if="errors.firstname" severity="error" size="small" variant="simple">{{
                                errors.firstname
                            }}
                        </Message>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <InputText v-model="form.lastname" type="text" class="w-full"/>
                        <label>Nom</label>
                        <Message v-if="errors.lastname" severity="error" size="small" variant="simple">{{
                                errors.lastname
                            }}
                        </Message>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.department_id" :options="departments" optionLabel="label"
                                option-value="id" filter/>
                        <label for="Département">Département</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <Select class="w-full" v-model="form.situation" :options="situations" filter/>
                        <label for="Département">Situation familiale</label>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3">
                    <FloatLabel class="w-full">
                        <DatePicker class="w-full" v-model="form.birthdate" date-format="yy-mm-dd"/>
                        <label for="birthdate">Date de Naissance</label>
                    </FloatLabel>
                    <FloatLabel class="w-full">
                        <DatePicker class="w-full" v-model="form.recruitment_date" date-format="yy-mm-dd"/>
                        <label for="recruitment_date">Date de recrutement</label>
                    </FloatLabel>
                </div>
                <div class="flex gap-1 mt-3" v-if="form.situation!=='Célébataire'">
                    <FloatLabel class="w-1/2">
                        <InputText v-model="form.children" type="number" class="w-full"/>
                        <label>Nombre d'enfant</label>
                        <Message v-if="errors.children" severity="error" size="small" variant="simple">{{
                                errors.children
                            }}
                        </Message>
                    </FloatLabel>
                </div>
            </div>
            <div class="flex justify-end">
                <PrimaryButton @click="add()" class="bg-green-600 hover:bg-green-700">Ajouter</PrimaryButton>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
