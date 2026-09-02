<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import TextInput from '../../Components/TextInput.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';

const props = defineProps({
    mode: { type: String, required: true },
    occurrence_id: { type: Number, required: true },
    resource: { type: Object, default: null },
});

const backRoute = props.mode === 'edit'
    ? { name: 'show-resource', params: { occurrence_id: props.occurrence_id, id: props.resource.id } }
    : { name: 'index-resource', params: props.occurrence_id };

const form = useForm({
    who: props.resource?.who ?? '',
    what: props.resource?.what ?? '',
    where: props.resource?.where ?? '',
    how: props.resource?.how ?? '',
});

const confirming = ref(false);

function attemptSubmit() {
    if (props.mode === 'edit') {
        confirming.value = true;
        return;
    }

    submit();
}

function submit() {
    confirming.value = false;

    if (props.mode === 'edit') {
        form.put(route('update-resource', { occurrence_id: props.occurrence_id, id: props.resource.id }));
    } else {
        form.post(route('store-resource', props.occurrence_id));
    }
}
</script>

<template>
    <AppLayout>
        <template #header>{{ mode === 'edit' ? `Alterar recurso de ${resource.who}` : 'Adicionar recurso' }}</template>

        <AppButton :as="Link" :href="route(backRoute.name, backRoute.params)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto max-w-2xl">
            <form @submit.prevent="attemptSubmit">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput v-model="form.who" label="De quem é o recurso" required :error="form.errors.who" />
                    <TextInput v-model="form.what" label="O que foi empregado" required :error="form.errors.what" />
                    <TextInput v-model="form.where" label="Onde foi empregado" required :error="form.errors.where" />
                    <TextInput v-model="form.how" label="Como foi empregado" required :error="form.errors.how" />
                </div>

                <div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <AppButton :as="Link" :href="route(backRoute.name, backRoute.params)" variant="secondary" class="w-full sm:w-auto">
                        Cancelar
                    </AppButton>
                    <AppButton type="submit" class="w-full sm:w-auto" :disabled="form.processing">Salvar</AppButton>
                </div>
            </form>
        </AppCard>

        <ConfirmDialog
            :show="confirming"
            :processing="form.processing"
            confirm-label="Salvar"
            :message="`Tem certeza que deseja atualizar o recurso de ${resource?.who}?`"
            @cancel="confirming = false"
            @confirm="submit"
        />
    </AppLayout>
</template>
