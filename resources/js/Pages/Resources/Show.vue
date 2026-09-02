<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Pencil, Trash2 } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import InfoTable from '../../Components/InfoTable.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import ErrorBanner from '../../Components/ErrorBanner.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

const props = defineProps({
    resource: { type: Object, required: true },
    occurrence_id: { type: Number, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();

const rows = computed(() => [
    { label: 'De quem', value: props.resource.who },
    { label: 'O que', value: props.resource.what },
    { label: 'Onde', value: props.resource.where },
    { label: 'Como', value: props.resource.how },
]);
</script>

<template>
    <AppLayout>
        <template #header>Recurso empregado por {{ resource.who }}</template>

        <ErrorBanner />

        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route('index-resource', occurrence_id)" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>
            <div v-if="isAdmin()" class="flex items-center gap-2">
                <AppButton :as="Link" :href="route('edit-resource', { occurrence_id, id: resource.id })">
                    <Pencil class="h-4 w-4" /> Atualizar
                </AppButton>
                <AppButton type="button" variant="danger" @click="ask(resource)">
                    <Trash2 class="h-4 w-4" /> Excluir
                </AppButton>
            </div>
        </div>

        <AppCard><InfoTable :rows="rows" /></AppCard>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover o recurso de ${target.who}?` : ''"
            @cancel="cancel"
            @confirm="confirm('destroy-resource', { occurrence_id, id: target?.id })"
        />
    </AppLayout>
</template>
