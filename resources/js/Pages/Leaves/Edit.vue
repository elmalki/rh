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
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'
const props = defineProps({leave:Object,leaveTypes:Array,personnels:Array,errors: Object})
const form = useForm(props.leave)
const add = () => {
    form.put(route('leaves.update',{leave:form.id}), form)
}
</script>

<template>
    <AppLayout title="Ajout de dotation">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs class="mb-4"
                             :pages="[{name:'Congés',href:route('leaves.index'),current:false},{name:'Modifier',href:route('leaves.create'),current:true}]"></Breadcrumbs>

            </div>
            <div class="mx-auto mt-5 max-w-5xl flex flex-col gap-4">
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                        <FloatLabel class="w-full">
                            <Select class="w-full" v-model="form.leave_type_id" :options="leaveTypes" optionLabel="label"
                                    option-value="id" filter/>
                            <label for="car">Type de congé</label>
                        </FloatLabel>
                        <Message v-if="errors.leave_type_id" severity="error" size="small" variant="simple">{{
                                errors.leave_type_id
                            }}
                        </Message>
                    </div>
                    <div class="w-full">
                        <FloatLabel class="w-full">
                            <Select class="w-full" v-model="form.personnel_id" :options="personnels" optionLabel="fullname"
                                    option-value="id" filter/>
                            <label for="personnel">Fonctionnaire</label>
                        </FloatLabel>
                        <Message v-if="errors.personnel_id" severity="error" size="small" variant="simple">{{
                                errors.personnel_id
                            }}
                        </Message>
                    </div>
                </div>
                <div class="flex gap-1 mt-3">
                    <div class="w-full">
                        <FloatLabel>
                            <DatePicker v-model="form.start_date" lang="" date-format="yy-mm-dd" class="w-full"/>
                            <label for="date">Date de départ</label>
                        </FloatLabel>
                        <Message v-if="errors.start_date" severity="error" size="small" variant="simple">{{
                                errors.start_date
                            }}
                        </Message>
                    </div>
                    <div class="w-full">
                        <FloatLabel class="ml-1">
                            <DatePicker v-model="form.end_date" lang="" date-format="yy-mm-dd" class="w-full"/>
                            <label for="date">Date de retour</label>
                        </FloatLabel>
                        <Message v-if="errors.end_date" severity="error" size="small" variant="simple">{{
                                errors.end_date
                            }}
                        </Message>
                    </div>
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
