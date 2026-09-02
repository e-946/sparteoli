<script setup>
import TextInput from './TextInput.vue';
import SelectInput from './SelectInput.vue';

const props = defineProps({
    fields: { type: Array, required: true }, // [{ key, label, type: 'text'|'textarea'|'select', options?, required? }]
    form: { type: Object, required: true }, // an Inertia useForm() instance
});

const multiColumn = props.fields.length > 1;

function fieldSpanClass(field) {
    return multiColumn && field.type !== 'textarea' ? '' : 'sm:col-span-2';
}
</script>

<template>
    <div class="grid grid-cols-1 gap-x-6 gap-y-5" :class="{ 'sm:grid-cols-2': multiColumn }">
        <template v-for="field in fields" :key="field.key">
            <SelectInput
                v-if="field.type === 'select'"
                v-model="form[field.key]"
                :class="fieldSpanClass(field)"
                :label="field.label"
                :options="field.options"
                :required="field.required"
                :error="form.errors[field.key]"
            />
            <div v-else-if="field.type === 'textarea'" :class="fieldSpanClass(field)">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">{{ field.label }}</label>
                <textarea
                    v-model="form[field.key]"
                    rows="4"
                    class="block w-full rounded-md border-0 px-3.5 py-2.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-blue sm:text-sm"
                />
            </div>
            <TextInput
                v-else
                v-model="form[field.key]"
                :class="fieldSpanClass(field)"
                :label="field.label"
                :required="field.required"
                :error="form.errors[field.key]"
            />
        </template>
    </div>
</template>
