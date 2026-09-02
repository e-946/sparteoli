<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { CheckCircle2, X } from 'lucide-vue-next';

const page = usePage();
const message = computed(() => page.props.flash?.message);
const visible = ref(false);

watch(message, (value) => {
    visible.value = Boolean(value);
}, { immediate: true });
</script>

<template>
    <div v-if="visible && message" class="mb-4 flex items-start justify-between gap-3 rounded-md bg-emerald-50 px-4 py-3 text-sm text-emerald-800 ring-1 ring-inset ring-emerald-600/20">
        <div class="flex items-start gap-2">
            <CheckCircle2 class="mt-0.5 h-4 w-4 shrink-0" />
            <span>{{ message }}</span>
        </div>
        <button type="button" class="text-emerald-600 hover:text-emerald-800" @click="visible = false">
            <X class="h-4 w-4" />
        </button>
    </div>
</template>
