<template>
    <AppLayout title="Missions-Liste">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-8xl mx-auto">
            <div class="sm:flex sm:items-center  max-w-7xl mx-auto mb-10">
                <div class="sm:flex-auto">
                    <Breadcrumbs class="mb-4"
                                 :pages="[{name:'Missions',href:route('missions.index'),current:true}]"></Breadcrumbs>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link v-if="can('Ajouter bordereau') " :href="route('missions.create')"
                          class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Nouvelle mission
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
                            mission trouvée
                        </div>
                    </template>
                    <Column field="mission" header="Objet" sortable></Column>
                    <Column field="depart_date" header="Date Départ"></Column>
                    <Column field="return_date" header="Date Retour"></Column>
                    <Column field="destination.label" header="Destination" sortable></Column>
                    <Column header="Equipes">
                        <template #body="slotProps">
                            <div v-for="(e,i) in slotProps.data.equipes" class="mb-2">
                                <span class="bg-pink-500 px-2 py-1 text-white">Equipe{{ i + 1 }}</span>
                                <span class="bg-blue-500 px-2 py-1 text-white mx-1">{{ e.driver.fullname }}</span>
                                <span class="bg-teal-500 px-2 py-1 text-white mr-1" v-for="p in e.personnels">
                                {{ p.fullname }}
                                </span>
                            </div>
                        </template>
                    </Column>

                    <Column header="Véhicules">
                        <template #body="slotProps">
                            <div class="mb-2" v-for="e in slotProps.data.equipes">
                                <span class="bg-teal-700 px-2 py-1 text-white ">
                                   {{ e.car.car_brand?.label }} {{ e.car.plate }}
                                </span>
                            </div>
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="slotProps">
                            <div class="flex gap-1">
                                <div class="flex px-2 py-1 bg-teal-500 hover:bg-teal-600 text-white uppercase text-sm"  @click="router.get(route('missions.edit',{mission:slotProps.data.id}))">
                                <PencilIcon class="h-4" ></PencilIcon>
                                <span>Modifier</span>
                                </div>

                                <a :href="route('missions.ordre-de-mission',{mission:slotProps.data.id})" class="flex px-2 py-1 bg-orange-500 hover:bg-orange-600 text-white text-sm" target="_blank">
                                    <DocumentArrowDownIcon class="h-4"></DocumentArrowDownIcon>
                                    <span class="uppercase">Order de mission</span>
                                </a>
                                <!--TrashIcon class=" h-6 text-red-500 hover:text-red-600 focus:text-red-600"></TrashIcon-->
                            </div>
                        </template>
                    </Column>
                </DataTable>
                <div class="missiond">
                    <Paginator :rows="items.per_page" v-model:first="page" :totalRecords="items.total"
                               @page="event=>router.get(route('missions.index'),{page:1+event.page})">
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
import {PencilIcon, DocumentArrowDownIcon} from '@heroicons/vue/20/solid'
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
    router.get(route('missions.index'), {field: field._value, order: v})
}

</script>
