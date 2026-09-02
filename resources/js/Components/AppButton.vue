<script setup>
import { computed } from 'vue';

const props = defineProps({
    as: { type: [String, Object, Function], default: 'button' },
    variant: { type: String, default: 'primary' },
    size: { type: String, default: 'md' },
});

const variants = {
    primary: 'bg-brand-blue text-white hover:bg-blue-900 focus-visible:outline-brand-blue',
    secondary: 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-gray-400',
    success: 'bg-emerald-600 text-white hover:bg-emerald-700 focus-visible:outline-emerald-600',
    danger: 'bg-brand-red text-white hover:bg-red-700 focus-visible:outline-brand-red',
};

const sizes = {
    sm: 'px-2.5 py-1.5 text-xs',
    md: 'px-3.5 py-2 text-sm',
};

const classes = computed(() => [
    'inline-flex items-center justify-center gap-1.5 rounded-md font-semibold shadow-sm transition-colors',
    'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
    'disabled:cursor-not-allowed disabled:opacity-50',
    variants[props.variant] ?? variants.primary,
    sizes[props.size] ?? sizes.md,
]);
</script>

<template>
    <component :is="as" :class="classes">
        <slot />
    </component>
</template>
