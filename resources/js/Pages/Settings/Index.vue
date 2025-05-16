<template>
    <AppLayout title="Utilisateurs">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-7xl mx-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">Paramétrage</h1>
                        <p class="mt-2 text-sm text-gray-700">
                           Paramétres de votre application: Définition des responsables institutionnels </p>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                        Qualité
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Nom
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                     Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="setting in items" :key="setting.id">
                                    <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">{{ setting.key }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                        <span
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-md font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                                            >{{ setting.value }}</span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <Link :href="route('settings.edit',{setting:setting.id})" class="text-green-600 hover:text-indigo-900"
                                        >Modifier</Link
                                        >
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {router, Link} from '@inertiajs/vue3';

const props = defineProps({items: Array, permissions: Array});



</script>
<style scoped>

</style>
