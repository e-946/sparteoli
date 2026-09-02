<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { AlertCircle } from 'lucide-vue-next';

const page = usePage();
const messages = computed(() => Object.values(page.props.errors ?? {}));
</script>

<template>
    <div v-if="messages.length" class="mb-4 rounded-md bg-red-50 px-4 py-3 text-sm text-brand-red ring-1 ring-inset ring-red-600/20">
        <div v-for="(message, i) in messages" :key="i" class="flex items-start gap-2">
            <AlertCircle class="mt-0.5 h-4 w-4 shrink-0" />
            <span>{{ message }}</span>
        </div>
    </div>
</template>
