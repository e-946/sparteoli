<script setup>
import { computed } from 'vue';
import { Bar, Doughnut, Pie } from 'vue-chartjs';
import AppLayout from '../Layouts/AppLayout.vue';
import AppCard from '../Components/AppCard.vue';

const props = defineProps({
    months: { type: Array, required: true },
    bairros: { type: Array, required: true },
    natures: { type: Array, required: true },
    types: { type: Array, required: true },
    colors: { type: Array, required: true },
});

function colorAt(index) {
    return props.colors[index % props.colors.length];
}

const monthsChart = computed(() => ({
    labels: props.months.map((m) => m.name),
    datasets: [{
        label: 'Ocorrências',
        data: props.months.map((m) => m.total),
        backgroundColor: props.months.map((_, i) => colorAt(i)),
    }],
}));

const bairrosChart = computed(() => ({
    labels: props.bairros.map((b) => b.name),
    datasets: [{
        label: 'Ocorrências',
        data: props.bairros.map((b) => b.total),
        backgroundColor: props.bairros.map((_, i) => colorAt(i)),
    }],
}));

const naturesChart = computed(() => ({
    labels: props.natures.map((n) => n.name),
    datasets: [{
        data: props.natures.map((n) => n.occurrences_count),
        backgroundColor: props.natures.map((_, i) => colorAt(i)),
    }],
}));

const typesChart = computed(() => ({
    labels: props.types.map((t) => t.name),
    datasets: [{
        data: props.types.map((t) => t.occurrences_count),
        backgroundColor: props.types.map((_, i) => colorAt(i)),
    }],
}));

const chartOptions = { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } };
const pieOptions = { responsive: true, maintainAspectRatio: false };
</script>

<template>
    <AppLayout>
        <template #header>Dashboard</template>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <AppCard title="Ocorrências por mês">
                <div class="h-72">
                    <Bar :data="monthsChart" :options="chartOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por natureza">
                <div class="h-72">
                    <Doughnut :data="naturesChart" :options="pieOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por bairro">
                <div class="h-72">
                    <Bar :data="bairrosChart" :options="chartOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por tipo">
                <div class="h-72">
                    <Pie :data="typesChart" :options="pieOptions" />
                </div>
            </AppCard>
        </div>
    </AppLayout>
</template>
