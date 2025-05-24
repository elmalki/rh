<script setup>
import {ref, useTemplateRef} from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {BellIcon} from '@heroicons/vue/24/solid'
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from '@headlessui/vue'
import {ChevronDownIcon} from "@heroicons/vue/20/solid/index.js";
import {
    PlusCircleIcon,
    PencilSquareIcon,
    ListBulletIcon,
    CalendarDaysIcon,
    BarsArrowDownIcon,
    MapPinIcon,
    DocumentIcon,
    WrenchScrewdriverIcon,
    BuildingOfficeIcon,
    TableCellsIcon
} from "@heroicons/vue/24/outline/index.js";
defineProps({
    title: String,
});
const pButton = useTemplateRef('missionsbutton')
const approButton = useTemplateRef('approButton')
const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-white">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex lg:text-sm">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Tableau de bord
                                </NavLink>
                            </div>
                        </div>
                        <div class="hidden sm:flex  sm:flex-auto justify-evenly items-center  ">
                            <PopoverGroup class="hidden lg:flex lg:gap-x-12">
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('missions.*')||route().current('destination*')">Missions</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('missions.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('missions.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste des missions
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>

                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <CalendarDaysIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></CalendarDaysIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('missions.show_calendar')"
                                                              class="block font-semibold text-gray-900">
                                                            Calendrier des missions
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <MapPinIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></MapPinIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('destinations.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste des destinations
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="deplacementsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('deplacements.*')||route().current('deplacement*')">Déplacement</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('deplacements.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('deplacements.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste des déplacements
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <TableCellsIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></TableCellsIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('deplacements.carnetDeBord')"
                                                              class="block font-semibold text-gray-900">
                                                            Carnet de bord
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>

                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('car*')||route().current('fuels.*')||route().current('papers.*')">Véhicule</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('cars.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('cars.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <DocumentIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></DocumentIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('papers.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Documents de véhicule
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('carbrands.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Marque de véhicule
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('cartypes.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Type de véhicule
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('fuels.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Type de carburants
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('maintenance*')">Maintenances</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenances.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenances.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <WrenchScrewdriverIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></WrenchScrewdriverIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenancetypes.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Type de maintenances
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <WrenchScrewdriverIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></WrenchScrewdriverIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenancecategories.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Catégories de maintenances
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <WrenchScrewdriverIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></WrenchScrewdriverIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenancetypes.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Type de maintenances
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <TableCellsIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></TableCellsIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenances.etatmensuelle')"
                                                              class="block font-semibold text-gray-900">
                                                            Etat mensuelle
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <TableCellsIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></TableCellsIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('maintenances.etat')"
                                                              class="block font-semibold text-gray-900">
                                                            Etat par type
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>

                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('personnels*')||route().current('depart*')">Fonctionnaires</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('personnels.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('personnels.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <BuildingOfficeIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></BuildingOfficeIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('departments.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Départements
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('dailyworker*')||route().current('pointages*')">Ouvriers PN</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('dailyworkers.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('dailyworkers.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PencilSquareIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PencilSquareIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('pointages.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Pointages
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>

                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <TableCellsIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></TableCellsIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('pointages.payment')"
                                                              class="block font-semibold text-gray-900">
                                                            Paiement Mensuelle
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('leave*')">Congés</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <PlusCircleIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></PlusCircleIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('leaves.create')"

                                                              class="block font-semibold text-gray-900">
                                                            Ajouter
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('leaves.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Liste
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <WrenchScrewdriverIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></WrenchScrewdriverIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('leavetypes.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Type de congé
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <CalendarDaysIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></CalendarDaysIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('leaves.show_calendar')"
                                                              class="block font-semibold text-gray-900">
                                                            Calendrier des congés
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>

                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>
                                <Popover class="relative">
                                    <PopoverButton
                                        ref="missionsbutton"
                                        @mouseenter="$event.target.click()"
                                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900">
                                        <NavLink :active="route().current('budget*')||route().current('dotation*')">Budget/Dotation</NavLink>
                                        <ChevronDownIcon class="size-5 flex-none text-gray-400" aria-hidden="true"/>
                                    </PopoverButton>
                                    <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0 translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100 translate-y-0"
                                                leave-to-class="opacity-0 translate-y-1">
                                        <PopoverPanel
                                            @mouseleave="pButton.el.click()"
                                            class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
                                            <div class="p-4">
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('budgets.index')"

                                                              class="block font-semibold text-gray-900">
                                                            Budgets
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                                <div
                                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50">
                                                    <div
                                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                                        <ListBulletIcon
                                                            class="size-6 text-gray-600 group-hover:text-indigo-600"
                                                            aria-hidden="true"></ListBulletIcon>
                                                    </div>
                                                    <div class="flex-auto">
                                                        <Link :href="route('dotations.index')"
                                                              class="block font-semibold text-gray-900">
                                                            Dotations
                                                            <span class="absolute inset-0"/>
                                                        </Link>
                                                        <!--p class="mt-1 text-gray-600">Ajouter un nouveau bordereaux</p-->
                                                    </div>
                                                </div>
                                            </div>
                                        </PopoverPanel>
                                    </transition>
                                </Popover>

                            </PopoverGroup>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Team
                                            </div>

                                            <!-- Team Settings -->
                                            <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                Team Settings
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                Create New Team
                                            </DropdownLink>

                                            <!-- Team Switcher -->
                                            <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                <div class="border-t border-gray-200" />

                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>

                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('users.index')"
                                                      v-if="$page.props.auth.user.roles[0]?.name=='Administrateur'">
                                            Gestion des utilisateurs
                                        </DropdownLink>
                                        <DropdownLink :href="route('roles.index')"
                                                      v-if="$page.props.auth.user.roles[0]?.name=='Administrateur'">
                                            Gestion des Rôles
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Déconnexion
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
