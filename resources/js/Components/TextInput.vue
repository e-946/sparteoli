<script setup>
import InputError from './InputError.vue';

defineProps({
    modelValue: { type: [String, Number], default: '' },
    label: { type: String, default: null },
    type: { type: String, default: 'text' },
    error: { type: String, default: null },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
});

defineEmits(['update:modelValue', 'blur']);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1.5 block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-brand-red">*</span>
        </label>
        <input
            :type="type"
            :value="modelValue"
            :required="required"
            :disabled="disabled"
            class="block w-full rounded-md border-0 px-3.5 py-2.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-blue disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 sm:text-sm"
            :class="{ 'ring-brand-red focus:ring-brand-red': error }"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur', $event)"
        >
        <InputError :message="error" />
    </div>
</template>
