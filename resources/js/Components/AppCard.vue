<script setup>
defineProps({
    title: { type: String, default: null },
});
</script>

<template>
    <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
        <div v-if="title || $slots.actions" class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-4">
            <h2 v-if="title" class="text-base font-semibold text-gray-900">{{ title }}</h2>
            <div v-if="$slots.actions" class="flex items-center gap-2">
                <slot name="actions" />
            </div>
        </div>
        <div class="p-5 sm:p-6 lg:p-8">
            <slot />
        </div>
    </div>
</template>
