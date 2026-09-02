<script setup>
import { X } from 'lucide-vue-next';

defineProps({
    show: { type: Boolean, default: false },
    title: { type: String, required: true },
});

defineEmits(['close']);
</script>

<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-50 pointer-events-none" @keydown.esc="$emit('close')">
            <Transition
                enter-active-class="transition-opacity ease-out duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity ease-in duration-150"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="show" class="fixed inset-0 bg-gray-900/50 pointer-events-auto" @click="$emit('close')" />
            </Transition>

            <Transition
                enter-active-class="transition-transform ease-out duration-300"
                enter-from-class="translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition-transform ease-in duration-200"
                leave-from-class="translate-x-0"
                leave-to-class="translate-x-full"
            >
                <div v-if="show" class="fixed inset-y-0 right-0 flex w-full max-w-md flex-col bg-white shadow-xl pointer-events-auto">
                    <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                        <h2 class="text-base font-semibold text-gray-900">{{ title }}</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600" @click="$emit('close')">
                            <X class="h-5 w-5" />
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-5">
                        <slot />
                    </div>
                </div>
            </Transition>
        </div>
    </Teleport>
</template>
