<script setup>
import { Check } from 'lucide-vue-next';

defineProps({
    steps: { type: Array, required: true }, // [{ title }]
    current: { type: Number, required: true }, // 1-indexed
});
</script>

<template>
    <div>
        <div class="mb-2 flex items-center justify-between text-sm font-medium text-gray-600 sm:hidden">
            <span>Passo {{ current }} de {{ steps.length }}</span>
            <span class="text-gray-900">{{ steps[current - 1].title }}</span>
        </div>
        <div class="h-1.5 w-full rounded-full bg-gray-200 sm:hidden">
            <div
                class="h-1.5 rounded-full bg-brand-blue transition-all"
                :style="{ width: `${(current / steps.length) * 100}%` }"
            />
        </div>

        <ol class="hidden items-center sm:flex">
            <li v-for="(step, i) in steps" :key="step.title" class="flex items-center" :class="i < steps.length - 1 ? 'flex-1' : ''">
                <div class="flex items-center gap-2">
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-sm font-semibold"
                        :class="i + 1 < current ? 'bg-brand-blue text-white' : i + 1 === current ? 'bg-brand-blue text-white ring-4 ring-brand-blue/20' : 'bg-gray-200 text-gray-500'"
                    >
                        <Check v-if="i + 1 < current" class="h-4 w-4" />
                        <template v-else>{{ i + 1 }}</template>
                    </span>
                    <span class="text-sm font-medium whitespace-nowrap" :class="i + 1 <= current ? 'text-gray-900' : 'text-gray-400'">
                        {{ step.title }}
                    </span>
                </div>
                <div v-if="i < steps.length - 1" class="mx-3 h-px flex-1" :class="i + 1 < current ? 'bg-brand-blue' : 'bg-gray-200'" />
            </li>
        </ol>
    </div>
</template>
