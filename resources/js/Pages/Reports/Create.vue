<script setup>
import { computed, ref, watchEffect } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import TextInput from '../../Components/TextInput.vue';
import SelectInput from '../../Components/SelectInput.vue';
import SearchableSelect from '../../Components/SearchableSelect.vue';
import InputError from '../../Components/InputError.vue';

const props = defineProps({
    fields: { type: Object, required: true }, // { field_key: label }
    users: { type: Array, required: true }, // [{ id, name }]
});

const formatOptions = [
    { value: 'csv', label: 'CSV (planilha)' },
    { value: 'pdf', label: 'PDF' },
];

const userOptions = props.users.map((user) => ({ value: user.id, label: user.name }));
const fieldKeys = Object.keys(props.fields);

const form = useForm({
    format: 'csv',
    fields: [],
    filters: {
        type_id: '',
        date_from: '',
        date_to: '',
        city: '',
        caller: '',
        meanused_id: '',
        placefreature_id: '',
        placeuse_id: '',
        filler_name: '',
        user_id: '',
    },
});

const allFieldsSelected = computed(() => fieldKeys.length > 0 && fieldKeys.every((key) => form.fields.includes(key)));
const someFieldsSelected = computed(() => form.fields.length > 0 && !allFieldsSelected.value);

const selectAllCheckbox = ref(null);
watchEffect(() => {
    if (selectAllCheckbox.value) {
        selectAllCheckbox.value.indeterminate = someFieldsSelected.value;
    }
});

function toggleAllFields(event) {
    form.fields = event.target.checked ? [...fieldKeys] : [];
}

function submit() {
    form.post(route('store-report'));
}
</script>

<template>
    <AppLayout>
        <template #header>Novo relatório</template>

        <AppButton :as="Link" :href="route('index-report')" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <form class="space-y-6" @submit.prevent="submit">
            <AppCard title="Filtros">
                <p class="mb-4 text-sm text-gray-500">Deixe em branco os filtros que não deseja aplicar.</p>
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <SearchableSelect
                        v-model="form.filters.type_id"
                        resource="type"
                        label="Categoria (tipo)"
                        :allow-create="false"
                        :error="form.errors['filters.type_id']"
                    />
                    <SearchableSelect
                        v-model="form.filters.meanused_id"
                        resource="meanused"
                        label="Meio de chamado"
                        :allow-create="false"
                        :error="form.errors['filters.meanused_id']"
                    />
                    <TextInput v-model="form.filters.date_from" type="date" label="Data inicial" :error="form.errors['filters.date_from']" />
                    <TextInput v-model="form.filters.date_to" type="date" label="Data final" :error="form.errors['filters.date_to']" />
                    <TextInput v-model="form.filters.city" label="Cidade" :error="form.errors['filters.city']" />
                    <TextInput v-model="form.filters.caller" label="Solicitante (nome ou telefone)" :error="form.errors['filters.caller']" />
                    <SearchableSelect
                        v-model="form.filters.placefreature_id"
                        resource="placefreature"
                        label="Característica do local"
                        :allow-create="false"
                        :error="form.errors['filters.placefreature_id']"
                    />
                    <SearchableSelect
                        v-model="form.filters.placeuse_id"
                        resource="placeuse"
                        label="Uso do local"
                        :allow-create="false"
                        :error="form.errors['filters.placeuse_id']"
                    />
                    <TextInput v-model="form.filters.filler_name" label="Preenchido por" :error="form.errors['filters.filler_name']" />
                    <SelectInput
                        v-model="form.filters.user_id"
                        label="Cadastrado por"
                        placeholder="Todos"
                        :options="userOptions"
                        :error="form.errors['filters.user_id']"
                    />
                </div>
            </AppCard>

            <AppCard title="Campos do relatório">
                <p class="mb-4 text-sm text-gray-500">Selecione os campos que deverão aparecer no relatório.</p>

                <label class="mb-3 flex items-center gap-2 border-b border-gray-100 pb-3 text-sm font-medium text-gray-900">
                    <input
                        ref="selectAllCheckbox"
                        type="checkbox"
                        :checked="allFieldsSelected"
                        class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue"
                        @change="toggleAllFields"
                    >
                    Selecionar todos
                </label>

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                    <label v-for="(label, key) in fields" :key="key" class="flex items-center gap-2 text-sm text-gray-700">
                        <input v-model="form.fields" type="checkbox" :value="key" class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
                        {{ label }}
                    </label>
                </div>
                <InputError :message="form.errors.fields" />
            </AppCard>

            <AppCard title="Formato">
                <div class="flex gap-6">
                    <label v-for="option in formatOptions" :key="option.value" class="flex items-center gap-2 text-sm text-gray-700">
                        <input v-model="form.format" type="radio" name="format" :value="option.value" class="border-gray-300 text-brand-blue focus:ring-brand-blue">
                        {{ option.label }}
                    </label>
                </div>
                <InputError :message="form.errors.format" />
            </AppCard>

            <div class="flex flex-col-reverse items-center gap-3 sm:flex-row sm:justify-end">
                <AppButton :as="Link" :href="route('index-report')" variant="secondary" class="w-full sm:w-auto">
                    Cancelar
                </AppButton>
                <AppButton type="submit" class="w-full sm:w-auto" :disabled="form.processing">
                    Solicitar relatório
                </AppButton>
            </div>
        </form>
    </AppLayout>
</template>
