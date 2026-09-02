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

const MONTH_NAMES = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

const monthsChart = computed(() => {
    const years = [...new Set(props.months.map((m) => m.year))].sort();

    return {
        labels: MONTH_NAMES,
        datasets: years.map((year, i) => ({
            label: year,
            data: MONTH_NAMES.map((_, monthIndex) => {
                const month = String(monthIndex + 1).padStart(2, '0');
                const entry = props.months.find((m) => m.year === year && m.month === month);

                return entry ? entry.total : 0;
            }),
            backgroundColor: colorAt(i),
        })),
    };
});

const bairrosChart = computed(() => {
    const cities = [...new Set(props.bairros.map((b) => b.city))].sort();
    const neighborhoods = [...new Set(props.bairros.map((b) => b.neighborhood))].sort();

    return {
        labels: neighborhoods,
        datasets: cities.map((city, i) => ({
            label: city,
            data: neighborhoods.map((neighborhood) => {
                const entry = props.bairros.find((b) => b.city === city && b.neighborhood === neighborhood);

                return entry ? entry.total : 0;
            }),
            backgroundColor: colorAt(i),
        })),
    };
});

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
            <AppCard title="Ocorrências por natureza">
                <div class="h-72">
                    <Doughnut :data="naturesChart" :options="pieOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por mês">
                <div class="h-72">
                    <Bar :data="monthsChart" :options="chartOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por tipo">
                <div class="h-72">
                    <Pie :data="typesChart" :options="pieOptions" />
                </div>
            </AppCard>
            <AppCard title="Ocorrências por bairro">
                <div class="h-72">
                    <Bar :data="bairrosChart" :options="chartOptions" />
                </div>
            </AppCard>
        </div>
    </AppLayout>
</template>
