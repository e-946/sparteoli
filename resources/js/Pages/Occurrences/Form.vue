<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, ArrowRight } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import TextInput from '../../Components/TextInput.vue';
import SelectInput from '../../Components/SelectInput.vue';
import SearchableSelect from '../../Components/SearchableSelect.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import Stepper from '../../Components/Stepper.vue';

const props = defineProps({
    mode: { type: String, required: true }, // 'create' | 'edit'
    occurrence: { type: Object, default: null },
    fillers: { type: Array, required: true },
});

const backRoute = props.mode === 'edit' ? 'show-occurrence' : 'index-occurrence';
const backRouteParams = props.mode === 'edit' ? props.occurrence.id : undefined;

const form = useForm({
    date: props.occurrence?.date ?? '',
    call_time: props.occurrence?.call_time ?? '',
    arrival_time: props.occurrence?.arrival_time ?? '',
    end_time: props.occurrence?.end_time ?? '',
    meanused_id: props.occurrence?.meanused_id ?? '',
    zip_code: props.occurrence?.zip_code ?? '',
    street: props.occurrence?.street ?? '',
    number: props.occurrence?.number ?? '',
    neighborhood: props.occurrence?.neighborhood ?? '',
    city: props.occurrence?.city ?? '',
    state: props.occurrence?.state ?? '',
    requester: props.occurrence?.requester ?? '',
    requester_phone: props.occurrence?.requester_phone ?? '',
    resume: props.occurrence?.resume ?? '',
    placefreature_id: props.occurrence?.placefreature_id ?? '',
    placeuse_id: props.occurrence?.placeuse_id ?? '',
    place_preservation: props.occurrence?.place_preservation !== undefined && props.occurrence?.place_preservation !== null
        ? String(Number(props.occurrence.place_preservation))
        : '',
    filler_register: props.occurrence?.filler_register ?? '',
    filler_name: props.occurrence?.filler_name ?? '',
    filler_patent: props.occurrence?.filler_patent ?? '',
    type_id: props.occurrence?.type_id ?? '',
    protectionsForSave: props.occurrence?.fireprotections?.map((p) => p.id) ?? [],
});

// Known {id, name} for whatever is already selected in edit mode, so the
// searchable comboboxes can show a label before any search request runs.
const meanusedInitial = props.occurrence?.meanused ? [props.occurrence.meanused] : [];
const placefreatureInitial = props.occurrence?.placefreature ? [props.occurrence.placefreature] : [];
const placeuseInitial = props.occurrence?.placeuse ? [props.occurrence.placeuse] : [];
const typeInitial = props.occurrence?.type
    ? [{ id: props.occurrence.type.id, name: props.occurrence.type.name, nature_name: props.occurrence.type.nature?.name }]
    : [];
const protectionsInitial = props.occurrence?.fireprotections ?? [];

const preservationOptions = [{ value: '1', label: 'Sim' }, { value: '0', label: 'Não' }];

const cepLoading = ref(false);
const cepError = ref(null);

async function lookupCep() {
    const cep = form.zip_code.replace(/\D/g, '');
    cepError.value = null;

    if (cep.length !== 8) {
        cepError.value = 'Formato de CEP inválido.';
        return;
    }

    cepLoading.value = true;

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            cepError.value = 'CEP não encontrado.';
            return;
        }

        form.street = data.logradouro;
        form.neighborhood = data.bairro;
        form.city = data.localidade;
        form.state = data.uf;
    } catch {
        cepError.value = 'Não foi possível consultar o CEP.';
    } finally {
        cepLoading.value = false;
    }
}

function lookupFiller() {
    const match = props.fillers.find((filler) => filler.filler_register === form.filler_register);

    if (match) {
        form.filler_name = match.filler_name;
        form.filler_patent = match.filler_patent;
    }
}

const steps = [
    { title: 'Chamado' },
    { title: 'Endereço' },
    { title: 'Solicitante' },
    { title: 'Local e operação' },
    { title: 'Preenchedor' },
];

// Fields backed by a SearchableSelect (not a native form control), so they
// need their own required-check — the browser's reportValidity() can't see them.
const stepSelectFields = {
    1: ['meanused_id'],
    4: ['placefreature_id', 'placeuse_id', 'type_id'],
};

function validateSelectFields(step) {
    let valid = true;

    (stepSelectFields[step] ?? []).forEach((field) => {
        if (! form[field]) {
            form.setError(field, 'Este campo é obrigatório.');
            valid = false;
        } else {
            form.clearErrors(field);
        }
    });

    return valid;
}

const currentStep = ref(1);
const formEl = ref(null);

function goNext() {
    if (formEl.value && ! formEl.value.reportValidity()) {
        return;
    }

    if (! validateSelectFields(currentStep.value)) {
        return;
    }

    currentStep.value = Math.min(currentStep.value + 1, steps.length);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function goBack() {
    currentStep.value = Math.max(currentStep.value - 1, 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const confirming = ref(false);

function attemptSubmit() {
    if (currentStep.value < steps.length) {
        goNext();
        return;
    }

    if (props.mode === 'edit') {
        confirming.value = true;
        return;
    }

    submit();
}

function submit() {
    confirming.value = false;

    if (props.mode === 'edit') {
        form.put(route('update-occurrence', props.occurrence.id));
    } else {
        form.post(route('store-occurrence'));
    }
}
</script>

<template>
    <AppLayout>
        <template #header>{{ mode === 'edit' ? `Alterar ocorrência ${occurrence.id}` : 'Adicionar ocorrência' }}</template>

        <AppButton :as="Link" :href="route(backRoute, backRouteParams)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mb-6">
            <Stepper :steps="steps" :current="currentStep" />
        </AppCard>

        <form ref="formEl" class="space-y-6" @submit.prevent="attemptSubmit">
            <AppCard v-if="currentStep === 1" title="Data e chamado">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <TextInput v-model="form.date" type="date" label="Data" required :error="form.errors.date" />
                    <SearchableSelect
                        v-model="form.meanused_id"
                        resource="meanused"
                        label="Meio de chamado utilizado"
                        required
                        :initial-options="meanusedInitial"
                        :error="form.errors.meanused_id"
                    />
                    <TextInput v-model="form.call_time" type="time" label="Horário do chamado" required :error="form.errors.call_time" />
                    <TextInput v-model="form.arrival_time" type="time" label="Horário da chegada" required :error="form.errors.arrival_time" />
                    <TextInput v-model="form.end_time" type="time" label="Horário do encerramento" required :error="form.errors.end_time" />
                </div>
            </AppCard>

            <AppCard v-if="currentStep === 2" title="Endereço">
                <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                    <div>
                        <TextInput v-model="form.zip_code" label="CEP" required :error="form.errors.zip_code || cepError" @blur="lookupCep" />
                        <p v-if="cepLoading" class="mt-1 text-xs text-gray-500">Consultando CEP...</p>
                    </div>
                    <TextInput v-model="form.street" label="Rua" required :error="form.errors.street" />
                    <TextInput v-model="form.number" type="number" label="Número" required :error="form.errors.number" />
                    <TextInput v-model="form.neighborhood" label="Bairro" required :error="form.errors.neighborhood" />
                    <TextInput v-model="form.city" label="Cidade" required :error="form.errors.city" />
                    <TextInput v-model="form.state" label="Estado" required :error="form.errors.state" />
                </div>
            </AppCard>

            <template v-if="currentStep === 3">
                <AppCard title="Solicitante">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                        <TextInput v-model="form.requester" label="Nome" required :error="form.errors.requester" />
                        <TextInput v-model="form.requester_phone" type="tel" label="Telefone" required :error="form.errors.requester_phone" />
                    </div>
                </AppCard>

                <AppCard title="Resumo">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Detalhes da ocorrência <span class="text-brand-red">*</span></label>
                    <textarea
                        v-model="form.resume"
                        rows="6"
                        required
                        class="block w-full rounded-md border-0 px-3.5 py-2.5 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-blue sm:text-sm"
                    />
                    <p v-if="form.errors.resume" class="mt-1 text-sm text-brand-red">{{ form.errors.resume }}</p>
                </AppCard>
            </template>

            <template v-if="currentStep === 4">
                <AppCard title="Local">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                        <SearchableSelect
                            v-model="form.placefreature_id"
                            resource="placefreature"
                            label="Característica do local"
                            required
                            :initial-options="placefreatureInitial"
                            :error="form.errors.placefreature_id"
                        />
                        <SearchableSelect
                            v-model="form.placeuse_id"
                            resource="placeuse"
                            label="Uso do local"
                            required
                            :initial-options="placeuseInitial"
                            :error="form.errors.placeuse_id"
                        />
                        <SelectInput v-model="form.place_preservation" label="É local de preservação" :options="preservationOptions" required :error="form.errors.place_preservation" />
                    </div>
                </AppCard>

                <AppCard title="Operação">
                    <SearchableSelect
                        v-model="form.type_id"
                        resource="type"
                        label="Tipo da operação"
                        required
                        :initial-options="typeInitial"
                        :error="form.errors.type_id"
                    />
                </AppCard>
            </template>

            <template v-if="currentStep === 5">
                <AppCard title="Preenchedor">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                        <TextInput v-model="form.filler_register" label="Matrícula" required :error="form.errors.filler_register" @blur="lookupFiller" />
                        <TextInput v-model="form.filler_name" label="Nome" required :error="form.errors.filler_name" />
                        <TextInput v-model="form.filler_patent" label="Posto/Graduação" required :error="form.errors.filler_patent" />
                    </div>
                </AppCard>

                <AppCard title="Proteção contra incêndios">
                    <SearchableSelect
                        v-model="form.protectionsForSave"
                        resource="fireprotection"
                        label="Sistemas de proteção existentes no local"
                        multiple
                        :initial-options="protectionsInitial"
                        :error="form.errors.protectionsForSave"
                    />
                </AppCard>
            </template>

            <div class="flex flex-col-reverse items-center gap-3 sm:flex-row sm:justify-between">
                <AppButton
                    type="button"
                    variant="secondary"
                    class="w-full sm:w-auto"
                    :disabled="currentStep === 1"
                    @click="goBack"
                >
                    <ArrowLeft class="h-4 w-4" /> Anterior
                </AppButton>

                <AppButton v-if="currentStep < steps.length" type="submit" class="w-full sm:w-auto">
                    Próximo <ArrowRight class="h-4 w-4" />
                </AppButton>
                <AppButton v-else type="submit" class="w-full sm:w-auto" :disabled="form.processing">
                    Salvar
                </AppButton>
            </div>
        </form>

        <ConfirmDialog
            :show="confirming"
            :processing="form.processing"
            confirm-label="Salvar"
            :message="`Tem certeza que deseja atualizar a ocorrência Nº ${occurrence?.id}?`"
            @cancel="confirming = false"
            @confirm="submit"
        />
    </AppLayout>
</template>
