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
    victim: { type: Object, required: true },
    occurrence_id: { type: Number, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();

function situation(victim) {
    if (victim.fatal) {
        return 'Vítima fatal';
    }

    return victim.conscious ? 'Vítima não fatal e consciente' : 'Vítima não fatal e não consciente';
}

const rows = computed(() => [
    { label: 'Idade', value: props.victim.age },
    { label: 'Sexo', value: props.victim.sex === 'M' ? 'Masculino' : 'Feminino' },
    { label: 'Socorrista', value: props.victim.rescuer?.name },
    { label: 'Situação', value: situation(props.victim) },
]);
</script>

<template>
    <AppLayout>
        <template #header>Vítima {{ victim.name }}</template>

        <ErrorBanner />

        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route('index-victim', occurrence_id)" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>
            <div v-if="isAdmin()" class="flex items-center gap-2">
                <AppButton :as="Link" :href="route('edit-victim', { occurrence_id, id: victim.id })">
                    <Pencil class="h-4 w-4" /> Atualizar
                </AppButton>
                <AppButton type="button" variant="danger" @click="ask(victim)">
                    <Trash2 class="h-4 w-4" /> Excluir
                </AppButton>
            </div>
        </div>

        <AppCard>
            <InfoTable :rows="rows" />
            <div v-if="victim.problems.length" class="mt-3">
                <p class="text-xs font-medium text-gray-500">Problemas</p>
                <ul class="mt-1 list-disc space-y-0.5 pl-5 text-sm text-gray-900">
                    <li v-for="problem in victim.problems" :key="problem.id">{{ problem.name }}</li>
                </ul>
            </div>
        </AppCard>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover ${target.name}?` : ''"
            @cancel="cancel"
            @confirm="confirm('destroy-victim', { occurrence_id, id: target?.id })"
        />
    </AppLayout>
</template>
