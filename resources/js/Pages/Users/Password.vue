<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import TextInput from '../../Components/TextInput.vue';
import AppButton from '../../Components/AppButton.vue';

const props = defineProps({
    user: { type: Object, required: true },
});

const form = useForm({
    password: '',
    password_confirmation: '',
});

function submit() {
    form.put(route('password-store', props.user.id), {
        onFinish: () => form.reset(),
    });
}
</script>

<template>
    <AppLayout>
        <template #header>Alterar senha {{ user.name }}</template>

        <AppButton :as="Link" :href="route('show-user', user.id)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto max-w-2xl">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput
                        v-model="form.password"
                        type="password"
                        label="Nova senha"
                        required
                        :error="form.errors.password"
                    />
                    <TextInput
                        v-model="form.password_confirmation"
                        type="password"
                        label="Confirme a senha"
                        required
                        :error="form.errors.password_confirmation"
                    />
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
