<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { Plus, Download, Loader2 } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppButton from '../../Components/AppButton.vue';
import Pagination from '../../Components/Pagination.vue';

const props = defineProps({
    reports: { type: Object, required: true }, // Laravel paginator
});

const statusStyles = {
    pending: 'bg-gray-100 text-gray-700',
    processing: 'bg-blue-100 text-blue-700',
    completed: 'bg-emerald-100 text-emerald-700',
    failed: 'bg-red-100 text-brand-red',
};

const statusLabels = {
    pending: 'Pendente',
    processing: 'Processando',
    completed: 'Concluído',
    failed: 'Falhou',
};

const formatLabels = {
    csv: 'CSV',
    pdf: 'PDF',
};

const hasActiveReports = computed(() => props.reports.data.some(
    (report) => report.status === 'pending' || report.status === 'processing',
));

let interval = null;

function startPolling() {
    if (interval) {
        return;
    }

    interval = setInterval(() => {
        if (! hasActiveReports.value) {
            clearInterval(interval);
            interval = null;
            return;
        }

        router.reload({ only: ['reports'], showProgress: false });
    }, 3000);
}

onMounted(() => {
    if (hasActiveReports.value) {
        startPolling();
    }
});

watch(hasActiveReports, (active) => {
    if (active) {
        startPolling();
    }
});

onUnmounted(() => clearInterval(interval));
</script>

<template>
    <AppLayout>
        <template #header>Relatórios</template>

        <div class="mb-4 flex justify-end">
            <AppButton :as="Link" :href="route('create-report')" variant="success">
                <Plus class="h-4 w-4" /> Novo relatório
            </AppButton>
        </div>

        <div v-if="reports.data.length === 0" class="rounded-lg bg-white p-6 text-center text-sm text-gray-500 shadow-sm ring-1 ring-gray-950/5">
            Nenhum relatório solicitado.
        </div>

        <div v-else class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
            <div v-for="report in reports.data" :key="report.id" class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                <div>
                    <p class="font-medium text-gray-900">
                        Relatório Nº {{ report.id }} — {{ formatLabels[report.format] ?? report.format }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Solicitado por {{ report.user?.name }} em {{ new Date(report.created_at).toLocaleString('pt-BR') }}
                    </p>
                    <p v-if="report.status === 'failed' && report.error_message" class="mt-1 text-xs text-brand-red">
                        {{ report.error_message }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium"
                        :class="statusStyles[report.status] ?? 'bg-gray-100 text-gray-700'"
                    >
                        <Loader2 v-if="report.status === 'pending' || report.status === 'processing'" class="h-3 w-3 animate-spin" />
                        {{ statusLabels[report.status] ?? report.status }}
                    </span>

                    <AppButton
                        v-if="report.status === 'completed'"
                        :as="'a'"
                        :href="route('download-report', report.id)"
                        size="sm"
                    >
                        <Download class="h-3.5 w-3.5" /> Baixar
                    </AppButton>
                </div>
            </div>
        </div>

        <Pagination :links="reports.links" />
    </AppLayout>
</template>
