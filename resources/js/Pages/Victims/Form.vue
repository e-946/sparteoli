<script setup>
import { computed, ref, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import TextInput from '../../Components/TextInput.vue';
import SelectInput from '../../Components/SelectInput.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';

const props = defineProps({
    mode: { type: String, required: true },
    occurrence_id: { type: Number, required: true },
    victim: { type: Object, default: null },
    rescuers: { type: Array, required: true },
    problems: { type: Array, required: true },
});

const backRoute = props.mode === 'edit'
    ? { name: 'show-victim', params: { occurrence_id: props.occurrence_id, id: props.victim.id } }
    : { name: 'index-victim', params: props.occurrence_id };

const form = useForm({
    name: props.victim?.name ?? '',
    age: props.victim?.age ?? '',
    sex: props.victim?.sex ?? '',
    rescuer_id: props.victim?.rescuer_id ?? '',
    problemForSave: props.victim?.problems?.map((p) => p.id) ?? [],
    fatal: props.victim?.fatal !== undefined && props.victim?.fatal !== null ? String(Number(props.victim.fatal)) : '',
    conscious: props.victim?.conscious !== undefined && props.victim?.conscious !== null ? String(Number(props.victim.conscious)) : '',
});

const sexOptions = [{ value: 'M', label: 'Masculino' }, { value: 'F', label: 'Feminino' }];
const rescuerOptions = props.rescuers.map((r) => ({ value: r.id, label: r.name }));
const fatalOptions = [{ value: '1', label: 'Vítima fatal' }, { value: '0', label: 'Vítima não fatal' }];
const consciousOptions = [{ value: '1', label: 'Vítima consciente' }, { value: '0', label: 'Vítima não consciente' }];

const isFatal = computed(() => form.fatal === '1');

watch(isFatal, (fatal) => {
    if (fatal) {
        form.conscious = '';
    }
});

const confirming = ref(false);

function attemptSubmit() {
    if (props.mode === 'edit') {
        confirming.value = true;
        return;
    }

    submit();
}

function submit() {
    confirming.value = false;

    if (props.mode === 'edit') {
        form.put(route('update-victim', { occurrence_id: props.occurrence_id, id: props.victim.id }));
    } else {
        form.post(route('store-victim', props.occurrence_id));
    }
}
</script>

<template>
    <AppLayout>
        <template #header>{{ mode === 'edit' ? `Alterar vítima: ${victim.name}` : 'Adicionar vítima' }}</template>

        <AppButton :as="Link" :href="route(backRoute.name, backRoute.params)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto max-w-2xl">
            <form @submit.prevent="attemptSubmit">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput v-model="form.name" label="Nome" required class="sm:col-span-2" :error="form.errors.name" />
                    <TextInput v-model="form.age" type="number" label="Idade" required :error="form.errors.age" />
                    <SelectInput v-model="form.sex" label="Sexo" :options="sexOptions" required :error="form.errors.sex" />
                    <SelectInput v-model="form.rescuer_id" label="Socorrista" :options="rescuerOptions" required :error="form.errors.rescuer_id" />
                    <SelectInput v-model="form.fatal" label="Sobre a fatalidade" :options="fatalOptions" required :error="form.errors.fatal" />
                    <SelectInput
                        v-model="form.conscious"
                        label="Sobre a consciência"
                        :options="consciousOptions"
                        :required="!isFatal"
                        :disabled="isFatal"
                        :error="form.errors.conscious"
                    />

                    <div class="sm:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Problemas encontrados</label>
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <label v-for="problem in problems" :key="problem.id" class="flex items-center gap-2 text-sm text-gray-700">
                                <input
                                    v-model="form.problemForSave"
                                    type="checkbox"
                                    :value="problem.id"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-blue focus:ring-brand-blue"
                                >
                                {{ problem.name }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <AppButton :as="Link" :href="route(backRoute.name, backRoute.params)" variant="secondary" class="w-full sm:w-auto">
                        Cancelar
                    </AppButton>
                    <AppButton type="submit" class="w-full sm:w-auto" :disabled="form.processing">Salvar</AppButton>
                </div>
            </form>
        </AppCard>

        <ConfirmDialog
            :show="confirming"
            :processing="form.processing"
            confirm-label="Salvar"
            :message="`Tem certeza que deseja atualizar ${victim?.name}?`"
            @cancel="confirming = false"
            @confirm="submit"
        />
    </AppLayout>
</template>
