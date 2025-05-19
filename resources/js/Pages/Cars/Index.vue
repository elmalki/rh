<template>
    <AppLayout title="Vihécules-Liste">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-8xl mx-auto">
            <div class="sm:flex sm:items-center  max-w-7xl mx-auto mb-10">
                <div class="sm:flex-auto">
                    <Breadcrumbs class="mb-4"
                                 :pages="[{name:'Véhicules',href:route('cars.index'),current:true}]"></Breadcrumbs>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link v-if="can('Ajouter bordereau') " :href="route('cars.create')"
                          class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Nouveau véhicule
                    </Link>
                </div>
            </div>
            <div class=" bg-transparent pb-10 h-screen  mx-auto">
                <DataTable :value="items.data" tableStyle="min-width: 50rem"
                           @update:sort-order="value => loadPage(value)"
                           @update:sort-field="value => field = value"
                           :sort-field="sort_fields.field"
                           :sortOrder="sort_fields.order">
                    <template #empty>
                        <div class="w-full flex text-lg justify-center items-center text-red-500 font-bold">Aucun
                            véhicule trouvé
                        </div>
                    </template>
                    <Column field="plate" header="Matricule" sortable></Column>
                    <Column field="car_type.label" header="Type"></Column>
                    <Column field="car_brand.label" header="Marque" sortable></Column>
                    <Column field="model" header="Modèle" sortable></Column>
                    <Column field="fuel.label" header="Carburant"></Column>
                    <Column field="n_chassis" header="N° Chassis" sortable></Column>
                    <Column field="motor" header="Moteur" sortable></Column>
                    <Column field="kilometrage" header="Kilométrage" sortable></Column>
                    <Column field="tank_capacity" header="Capacité" sortable></Column>
                    <Column header="Actions">
                        <template #body="slotProps">
                            <div class="flex gap-1">
                                <PencilIcon v-if="can('Modifier bordereau')"
                                            class="h-6 text-teal-500  hover:text-teal-600 focus:text-teal-600"
                                            @click="router.get(route('cars.edit',{car:slotProps.data.id}))"></PencilIcon>
                                <!--TrashIcon class=" h-6 text-red-500 hover:text-red-600 focus:text-red-600"></TrashIcon-->
                            </div>
                        </template>
                    </Column>
                </DataTable>
                <div class="card">
                    <Paginator :rows="items.per_page" v-model:first="page" :totalRecords="items.total"
                               @page="event=>router.get(route('cars.index'),{page:1+event.page})">
                        <template #start="slotProps">
                        </template>
                        <template #end>
                            <Button type="button" icon="pi pi-search"/>
                        </template>
                    </Paginator>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import "vue3-pdf-app/dist/icons/main.css";
import {DocumentArrowDownIcon, InformationCircleIcon, PencilIcon} from '@heroicons/vue/20/solid'
import DataTable from 'primevue/datatable';
import Paginator from 'primevue/paginator';
import Column from 'primevue/column';
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import {Link, router} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

const props = defineProps({items: [], sort_fields: Object})
const field = ref(null);
const page = ref((props.items.current_page - 1) * 10)

function can(permission) {
    return true;
    // return page_.props.auth.user.roles[0].name==='Administrateur'||page_.props.auth.user.roles[0].permissions.some(el=>el.name===permission);
}

const loadPage = (v) => {
    router.get(route('cars.index'), {field: field._value, order: v})
}

</script>
