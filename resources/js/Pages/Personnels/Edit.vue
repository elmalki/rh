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

const props = defineProps({personnel:Array,departments: Array, errors: Object})
const situations = ['Célébataire', 'Marié(e)', 'Remarié(e)', 'Divorcé(e)', 'Veuf(ve)']
const form = useForm(props.personnel)
const edit = () => {
    form.put(route('personnels.update',{personnel:form.id}), form)
}
</script>

<template>
    <AppLayout title="Fonctionnaire-Modification">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Fonctinnaires',href:route('personnels.index'),current:false},{name:'Modification',href:route('personnels.edit',{personnel:personnel.id}),current:true}]"></Breadcrumbs>

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
                        <InputText v-model="form.grade" type="text" class="w-full"/>
                        <label>Grade</label>
                        <Message v-if="errors.grade" severity="error" size="small" variant="simple">{{
                                errors.grade
                            }}
                        </Message>
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
                <div class="flex gap-1 mt-3" >
                    <FloatLabel class="w-1/2">
                        <Select class="w-full" v-model="form.sexe" :options="['Homme','Femme']" filter/>
                        <label for="Département">Sexe</label>
                    </FloatLabel>
                    <FloatLabel class="w-1/2">
                        <Select class="w-full" v-model="form.situation" :options="situations" filter/>
                        <label for="Département">Situation familiale</label>
                    </FloatLabel>

                </div>
                <div class="flex gap-1 mt-3" >
                    <FloatLabel class="w-1/2" v-if="form.situation!=='Célébataire'">
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
                <PrimaryButton @click="edit()" class="bg-green-600 hover:bg-green-700">Modifier</PrimaryButton>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
