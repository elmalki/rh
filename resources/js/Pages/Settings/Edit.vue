<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FloatLabel from "primevue/floatlabel";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Message from "primevue/message";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    setting: Object,
    errors: Object
});

const form = useForm({
    key: props.setting.key,
    value: props.setting.value
});

const updateSetting = () => {
    form.put(route('settings.update', { setting: props.setting.id }), form);
};
</script>

<template>
    <AppLayout title="Modifier un paramètre">
        <div class="px-4 sm:px-6 lg:px-8 bg-transparent py-10 h-screen max-w-5xl mx-auto">
            <div class="sm:flex sm:items-center">
                <Breadcrumbs
                    class="mb-4"
                    :pages="[
                        { name: 'Paramètres', href: route('settings.index'), current: false },
                        { name: 'Modifier', href: route('settings.edit', { setting: setting.id }), current: true }
                    ]"
                />
            </div>

            <div class="mt-5 flex flex-col gap-4">

                <div class="w-1/2 mx-auto">
                    <FloatLabel class="w-full">
                        <InputText v-model="form.value" class="w-full" />
                        <label v-text="form.key"></label>
                    </FloatLabel>
                    <Message v-if="errors.value" severity="error" size="small" variant="simple">
                        {{ errors.value }}
                    </Message>
                </div>

                <div class="flex justify-end mt-4">
                    <PrimaryButton @click="updateSetting" class="bg-green-600 hover:bg-green-700">
                        Modifier
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
</style>
