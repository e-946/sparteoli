<script setup>
import { AlertTriangle } from 'lucide-vue-next';
import AppButton from './AppButton.vue';

defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, default: 'Tem certeza?' },
    message: { type: String, default: 'Esta ação não pode ser desfeita.' },
    confirmLabel: { type: String, default: 'Excluir' },
    processing: { type: Boolean, default: false },
});

defineEmits(['confirm', 'cancel']);
</script>

<template>
    <Teleport to="body">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4" @keydown.esc="$emit('cancel')">
            <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <AlertTriangle class="h-5 w-5 text-brand-red" />
                    </span>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ title }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ message }}</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <AppButton type="button" variant="secondary" :disabled="processing" @click="$emit('cancel')">
                        Cancelar
                    </AppButton>
                    <AppButton type="button" variant="danger" :disabled="processing" @click="$emit('confirm')">
                        {{ confirmLabel }}
                    </AppButton>
                </div>
            </div>
        </div>
    </Teleport>
</template>
