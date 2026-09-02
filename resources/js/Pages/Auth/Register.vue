<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import TextInput from '../../Components/TextInput.vue';
import AppButton from '../../Components/AppButton.vue';

const form = useForm({
    name: '',
    register: '',
    password: '',
    password_confirmation: '',
    admin: false,
});

function submit() {
    form.post(route('register'));
}
</script>

<template>
    <AppLayout>
        <template #header>Criar usuário</template>

        <AppButton :as="Link" :href="route('index-user')" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto max-w-2xl">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput v-model="form.name" label="Nome completo" required :error="form.errors.name" class="sm:col-span-2" />
                    <TextInput v-model="form.register" label="Matrícula" required :error="form.errors.register" class="sm:col-span-2" />
                    <TextInput v-model="form.password" type="password" label="Senha" required :error="form.errors.password" />
                    <TextInput
                        v-model="form.password_confirmation"
                        type="password"
                        label="Confirmar senha"
                        required
                        :error="form.errors.password_confirmation"
                    />
                    <label class="flex items-center gap-2 text-sm text-gray-700 sm:col-span-2">
                        <input v-model="form.admin" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                        Usuário é administrador?
                    </label>
                </div>

                <div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <AppButton :as="Link" :href="route('index-user')" variant="secondary" class="w-full sm:w-auto">
                        Cancelar
                    </AppButton>
                    <AppButton type="submit" class="w-full sm:w-auto" :disabled="form.processing">Criar</AppButton>
                </div>
            </form>
        </AppCard>
    </AppLayout>
</template>
