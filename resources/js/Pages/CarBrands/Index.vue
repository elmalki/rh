<template>
    <AppLayout title="Marque véhicule">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <Breadcrumbs class="mb-4" :pages="[{name:'Marque de véhicule',href:route('carbrands.index'),current:true}]"></Breadcrumbs>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button type="button" @click="createOrUpdateModal()"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Nouvelle marque
                    </button>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div>
                            <div class="relative mt-2 md:w-1/4 xs:w-1/2 sm:w-1/2">
                                <input type="text" name="name" id="name" v-model="search"
                                       class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm/6"
                                       placeholder="Recherche"/>
                                <div
                                    class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2 peer-focus:border-indigo-600"
                                    aria-hidden="true"/>
                                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                    <kbd
                                        class="inline-flex items-center rounded border border-gray-200 px-1 font-sans text-xs text-gray-400">⌘K</kbd>
                                </div>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-0">
                                    Libellé
                                </th>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-0">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="item in filtered" :key="item.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                    {{ item.label }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <button @click="item_id=item.id,form.label=item.label,createOrUpdateModal()" href="#"
                                            class="text-green-600 px-3 hover:text-green-700"
                                    >Modifier<span class="sr-only">, {{ item.label }}</span></button
                                    >
                                    <button @click="deleteModal=true,item_id=item.id"
                                            class="text-red-600  hover:text-red-7r00"
                                    >Supprimer<span class="sr-only">, {{ item.label }}</span></button
                                    >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <DialogModal :show="addModal" @close="closeAddModal()">
            <template #title>
                {{ title }}
            </template>
            <template #content>
                <div class="mt-4" @keydown.enter="createOrEditItem()">
                    <TextInput
                        ref="label"
                        v-model="form.label"
                        type="text"
                        class="mt-1 block w-3/4 border"
                        placeholder="Libellé"
                        autocomplete="Libellé de la catégorie"
                    />
                    <span v-for="error in form.errors">
                        <InputError :message="error" class="mt-2"/>
                    </span>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="closeAddModal()">
                    Annuler
                </SecondaryButton>
                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="createOrEditItem()"
                >
                    {{button_name}}
                </PrimaryButton>
            </template>
        </DialogModal>
        <ConfirmationModal :show="deleteModal" @close="deleteModal=false">
            <template #title>
                Supprimer le marque
            </template>
            <template #content>
                Voulez-vous vraiment supprimer ce marque?
            </template>
            <template #footer>
                <SecondaryButton @click="deleteModal = false">
                    Annuler
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    @click="deleteCategory()"
                >
                    Supprimer
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {router,useForm} from '@inertiajs/vue3';
import {computed, nextTick, ref} from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

const props = defineProps({items: Array});
const deleteModal = ref(false)
const addModal = ref(false)
const item_id = ref(null)
const search = ref(null)
const title = ref('')
const button_name  = ref('')
let filtered = computed(() => props.items.filter(item =>
    !search.value || item.label.toLowerCase().includes(search.value.toLowerCase())
));
const form = useForm({
    label: '',
    processing: false,
    errors: []
});
const createOrUpdateModal = ()=>{
    title.value = item_id.value?'Modifier le marque':'Ajouter une nouvelle marque';
    button_name.value = item_id.value?'Modifier':'Ajouter';
    addModal.value = true
}
function deleteCategory() {
    deleteModal.value = false;
    router.delete(`/carbrands/${item_id.value}`);
}

const createOrEditItem = () => {
    form.processing = true;
    if (!item_id.value) {
        axios.post(route('carbrands.store'), {
            label: form.label,
        }).then((response) => {
            form.processing = false;
            props.items.push(response.data)
            closeAddModal();
            nextTick().then(() => {
            });

        }).catch(error => {
            form.processing = false;
            form.errors = error.response?.data.errors.label;
        });
    } else {
        axios.put(route('carbrands.update', {carbrand: item_id.value}), {
            label: form.label,
        }).then((response) => {
            form.processing = false;
            const item = props.items.find(el => response.data.id === el.id)
            item.label = response.data.label
            closeAddModal();
            nextTick().then(() => {
            });

        }).catch(error => {
            form.processing = false;
            form.errors = error.response?.data.errors.label;
        });

    }

};
const closeAddModal = () => {
    item_id.value = null;
    form.reset()
    addModal.value = false;
}
</script>
<style scoped>

</style>
