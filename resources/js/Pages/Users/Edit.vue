<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import TextInput from '../../Components/TextInput.vue';
import AppButton from '../../Components/AppButton.vue';

const props = defineProps({
    user: { type: Object, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const form = useForm({
    name: props.user.name,
    register: props.user.register,
    admin: props.user.admin,
});

function submit() {
    form.put(route('update-user', props.user.id));
}
</script>

<template>
    <AppLayout>
        <template #header>Atualizar {{ user.name }}</template>

        <AppButton :as="Link" :href="route('show-user', user.id)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto max-w-2xl">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput v-model="form.name" label="Nome" required :error="form.errors.name" />
                    <TextInput v-model="form.register" label="Matrícula" required :disabled="!isAdmin()" :error="form.errors.register" />
                    <label v-if="isAdmin()" class="flex items-center gap-2 text-sm text-gray-700 sm:col-span-2">
                        <input v-model="form.admin" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                        Usuário é administrador?
                    </label>
                </div>

                <div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <AppButton :as="Link" :href="route('show-user', user.id)" variant="secondary" class="w-full sm:w-auto">
                        Cancelar
                    </AppButton>
                    <AppButton type="submit" class="w-full sm:w-auto" :disabled="form.processing">Salvar</AppButton>
                </div>
            </form>
        </AppCard>
    </AppLayout>
</template>
