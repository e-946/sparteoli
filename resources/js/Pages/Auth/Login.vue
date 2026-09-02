<script setup>
import { useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import TextInput from '../../Components/TextInput.vue';
import AppButton from '../../Components/AppButton.vue';

const form = useForm({
    register: '',
    password: '',
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <GuestLayout>
        <form class="space-y-5" @submit.prevent="submit">
            <TextInput
                v-model="form.register"
                label="Matrícula"
                required
                :error="form.errors.register"
            />
            <TextInput
                v-model="form.password"
                type="password"
                label="Senha"
                required
                :error="form.errors.password"
            />
            <AppButton type="submit" class="w-full" :disabled="form.processing">
                Entrar
            </AppButton>
        </form>
    </GuestLayout>
</template>
