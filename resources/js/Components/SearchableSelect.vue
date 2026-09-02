<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import {
    Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption,
} from '@headlessui/vue';
import { Check, ChevronsUpDown, Plus, X, Loader2 } from 'lucide-vue-next';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import InputError from './InputError.vue';
import AppButton from './AppButton.vue';
import QuickCreateModal from './QuickCreateModal.vue';

const props = defineProps({
    modelValue: { type: [Number, String, Array], default: null },
    resource: { type: String, required: true }, // 'nature' | 'meanused' | 'placefreature' | 'placeuse' | 'fireprotection' | 'type'
    label: { type: String, default: null },
    required: { type: Boolean, default: false },
    multiple: { type: Boolean, default: false },
    error: { type: String, default: null },
    initialOptions: { type: Array, default: () => [] }, // known {id, name, nature_name?} for the current value(s)
    params: { type: Object, default: () => ({}) },
    allowCreate: { type: Boolean, default: true },
});

const emit = defineEmits(['update:modelValue']);

const page = usePage();
const canCreate = computed(() => props.allowCreate && !!page.props.auth.user?.admin);

const query = ref('');
const options = ref([]);
const loading = ref(false);
const showCreateModal = ref(false);
const cache = new Map();

function cacheOptions(list) {
    list.forEach((option) => cache.set(option.id, option));
}

cacheOptions(props.initialOptions);

let debounceTimer = null;
watch(query, (value) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => search(value), 250);
});

async function search(q) {
    loading.value = true;

    try {
        const { data } = await axios.get(`/lookup-search/${props.resource}`, { params: { q, ...props.params } });
        options.value = data;
        cacheOptions(data);
    } finally {
        loading.value = false;
    }
}

onMounted(() => search(''));

const selected = computed({
    get() {
        if (props.multiple) {
            return (props.modelValue ?? []).map((id) => cache.get(id)).filter(Boolean);
        }

        return props.modelValue ? cache.get(props.modelValue) ?? null : null;
    },
    set(value) {
        if (props.multiple) {
            emit('update:modelValue', value.map((option) => option.id));
        } else {
            emit('update:modelValue', value?.id ?? '');
            query.value = '';
            search('');
        }
    },
});

function removeSelected(id) {
    emit('update:modelValue', (props.modelValue ?? []).filter((existing) => existing !== id));
}

function onCreated(option) {
    cache.set(option.id, option);
    options.value = [option, ...options.value];

    if (props.multiple) {
        emit('update:modelValue', [...(props.modelValue ?? []), option.id]);
    } else {
        emit('update:modelValue', option.id);
    }

    showCreateModal.value = false;
}
</script>

<template>
    <div>
        <label v-if="label" class="mb-1.5 block text-sm font-medium text-gray-700">
            {{ label }}
            <span v-if="required" class="text-brand-red">*</span>
        </label>

        <div class="flex gap-2">
            <Combobox v-model="selected" :multiple="multiple" by="id" class="min-w-0 flex-1">
                <div class="relative">
                    <ComboboxInput
                        class="block w-full rounded-md border-0 px-3.5 py-2.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-blue sm:text-sm"
                        :class="{ 'ring-brand-red focus:ring-brand-red': error }"
                        :display-value="(option) => (multiple ? '' : (option?.name ?? ''))"
                        placeholder="Buscar..."
                        @change="query = $event.target.value"
                    />
                    <ComboboxButton class="absolute inset-y-0 right-0 flex items-center px-2.5">
                        <Loader2 v-if="loading" class="h-4 w-4 animate-spin text-gray-400" />
                        <ChevronsUpDown v-else class="h-4 w-4 text-gray-400" />
                    </ComboboxButton>

                    <ComboboxOptions class="absolute z-20 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-gray-950/5">
                        <div v-if="!loading && options.length === 0" class="px-3 py-2 text-gray-500">
                            Nenhum resultado encontrado.
                        </div>
                        <ComboboxOption v-for="option in options" v-slot="{ active, selected: isSelected }" :key="option.id" :value="option" as="template">
                            <li
                                class="flex cursor-pointer items-center justify-between px-3 py-2"
                                :class="active ? 'bg-brand-blue text-white' : 'text-gray-900'"
                            >
                                <span>
                                    {{ option.name }}
                                    <span v-if="option.nature_name" class="block text-xs" :class="active ? 'text-blue-100' : 'text-gray-500'">
                                        {{ option.nature_name }}
                                    </span>
                                </span>
                                <Check v-if="isSelected" class="h-4 w-4 shrink-0" />
                            </li>
                        </ComboboxOption>
                    </ComboboxOptions>
                </div>
            </Combobox>

            <AppButton v-if="canCreate" type="button" variant="secondary" @click="showCreateModal = true">
                <Plus class="h-4 w-4" />
            </AppButton>
        </div>

        <div v-if="multiple && selected.length" class="mt-2 flex flex-wrap gap-1.5">
            <span
                v-for="option in selected"
                :key="option.id"
                class="inline-flex items-center gap-1 rounded-full bg-brand-blue/10 px-2.5 py-1 text-xs font-medium text-brand-blue"
            >
                {{ option.name }}
                <button type="button" @click="removeSelected(option.id)">
                    <X class="h-3 w-3" />
                </button>
            </span>
        </div>

        <InputError :message="error" />

        <QuickCreateModal
            v-if="showCreateModal"
            :resource="resource"
            :initial-name="query"
            @close="showCreateModal = false"
            @created="onCreated"
        />
    </div>
</template>
