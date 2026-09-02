<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import { X } from 'lucide-vue-next';
import AppButton from './AppButton.vue';
import TextInput from './TextInput.vue';
import SearchableSelect from './SearchableSelect.vue';

const props = defineProps({
    resource: { type: String, required: true },
    initialName: { type: String, default: '' },
});

const emit = defineEmits(['close', 'created']);

const titles = {
    nature: 'Nova natureza de ocorrência',
    meanused: 'Novo meio de chamado',
    placefreature: 'Nova característica do local',
    placeuse: 'Novo uso do local',
    fireprotection: 'Novo sistema de proteção',
    type: 'Novo tipo de ocorrência',
};

const needsDesc = computed(() => ['fireprotection', 'type'].includes(props.resource));
const needsNature = computed(() => props.resource === 'type');

const name = ref(props.initialName);
const desc = ref('');
const natureId = ref('');
const errors = ref({});
const processing = ref(false);

async function submit() {
    processing.value = true;
    errors.value = {};

    const payload = { name: name.value };

    if (needsDesc.value) {
        payload.desc = desc.value;
    }

    if (needsNature.value) {
        payload.nature_id = natureId.value;
    }

    try {
        const { data } = await axios.post(`/lookup-search/${props.resource}`, payload);
        emit('created', data);
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = Object.fromEntries(
                Object.entries(error.response.data.errors).map(([key, messages]) => [key, messages[0]])
            );
        }
    } finally {
        processing.value = false;
    }
}
</script>

<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 px-4">
            <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-900">{{ titles[resource] }}</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" @click="$emit('close')">
                        <X class="h-5 w-5" />
                    </button>
                </div>

                <form class="space-y-4" @submit.prevent="submit">
                    <TextInput v-model="name" label="Nome" required :error="errors.name" />

                    <SearchableSelect
                        v-if="needsNature"
                        v-model="natureId"
                        resource="nature"
                        label="Natureza"
                        required
                        :allow-create="false"
                        :error="errors.nature_id"
                    />

                    <div v-if="needsDesc">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea
                            v-model="desc"
                            rows="3"
                            class="block w-full rounded-md border-0 px-3.5 py-2.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-blue sm:text-sm"
                        />
                        <p v-if="errors.desc" class="mt-1 text-sm text-brand-red">{{ errors.desc }}</p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <AppButton type="button" variant="secondary" @click="$emit('close')">Cancelar</AppButton>
                        <AppButton type="submit" :disabled="processing">Criar</AppButton>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
</template>
