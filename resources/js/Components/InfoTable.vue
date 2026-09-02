<script setup>
defineProps({
    rows: { type: Array, required: true }, // [{ label, value }]
});
</script>

<template>
    <dl class="divide-y divide-gray-100">
        <div v-for="row in rows" :key="row.label" class="flex flex-col gap-1 py-2.5 sm:flex-row sm:justify-between sm:gap-4">
            <dt class="text-sm text-gray-500">{{ row.label }}</dt>
            <dd class="text-sm font-medium text-gray-900 sm:text-right">
                <slot :name="row.label" :row="row">{{ row.value }}</slot>
            </dd>
        </div>
    </dl>
</template>
