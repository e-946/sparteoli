<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowLeft, Pencil, Download, HeartPulse, Plus, HandHelping, Trash2 } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import InfoTable from '../../Components/InfoTable.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import { formatDate, formatZipCode, formatPhone } from '../../format.js';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

const props = defineProps({
    occurrence: { type: Object, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();

const callRows = computed(() => [
    { label: 'Data do chamado', value: formatDate(props.occurrence.date) },
    { label: 'Horário do chamado', value: props.occurrence.call_time },
    { label: 'Horário de chegada', value: props.occurrence.arrival_time },
    { label: 'Horário de encerramento', value: props.occurrence.end_time },
    { label: 'Meio utilizado no chamado', value: props.occurrence.meanused?.name },
]);

const addressRows = computed(() => [
    { label: 'Endereço', value: props.occurrence.address },
    { label: 'Bairro', value: props.occurrence.neighborhood },
    { label: 'CEP', value: formatZipCode(props.occurrence.zip_code) },
    { label: 'Cidade', value: props.occurrence.city },
    { label: 'Estado', value: props.occurrence.state },
]);

const requesterRows = computed(() => [
    { label: 'Nome', value: props.occurrence.requester },
    { label: 'Telefone', value: formatPhone(props.occurrence.requester_phone) },
]);

const detailRows = computed(() => [
    { label: 'Tipo de ocorrência', value: props.occurrence.type?.name },
    { label: 'Natureza da ocorrência', value: props.occurrence.type?.nature?.name },
    { label: 'Resumo', value: props.occurrence.resume },
]);

const placeRows = computed(() => [
    { label: 'Característica do local', value: props.occurrence.placefreature?.name },
    { label: 'Uso do local', value: props.occurrence.placeuse?.name },
    { label: 'Local de preservação', value: props.occurrence.place_preservation ? 'Sim' : 'Não' },
]);

const fillerRows = computed(() => [
    { label: 'Nome', value: props.occurrence.filler_name },
    { label: 'Registro', value: props.occurrence.filler_register },
    { label: 'Patente', value: props.occurrence.filler_patent },
]);

function victimSituation(victim) {
    if (victim.fatal) {
        return 'Vítima fatal';
    }

    return victim.conscious ? 'Vítima não fatal e consciente' : 'Vítima não fatal e não consciente';
}
</script>

<template>
    <AppLayout>
        <template #header>Ocorrência {{ occurrence.id }}</template>

        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route('index-occurrence')" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>

            <div class="flex flex-wrap items-center gap-2">
                <AppButton v-if="isAdmin()" :as="Link" :href="route('edit-occurrence', occurrence.id)">
                    <Pencil class="h-4 w-4" /> Atualizar
                </AppButton>
                <AppButton :as="'a'" :href="route('toPdf-occurrence', occurrence.id)" target="_blank">
                    <Download class="h-4 w-4" /> Baixar PDF
                </AppButton>
                <AppButton :as="Link" :href="route(occurrence.victims.length ? 'index-victim' : 'create-victim', occurrence.id)" variant="success">
                    <component :is="occurrence.victims.length ? HeartPulse : Plus" class="h-4 w-4" />
                    {{ occurrence.victims.length ? 'Listar vítimas' : 'Adicionar vítimas' }}
                </AppButton>
                <AppButton :as="Link" :href="route(occurrence.resources.length ? 'index-resource' : 'create-resource', occurrence.id)" variant="success">
                    <component :is="occurrence.resources.length ? HandHelping : Plus" class="h-4 w-4" />
                    {{ occurrence.resources.length ? 'Listar recursos' : 'Adicionar recursos' }}
                </AppButton>
                <AppButton v-if="isAdmin()" type="button" variant="danger" @click="ask(occurrence)">
                    <Trash2 class="h-4 w-4" /> Excluir
                </AppButton>
            </div>
        </div>

        <div class="space-y-6">
            <AppCard title="Detalhes do chamado"><InfoTable :rows="callRows" /></AppCard>
            <AppCard title="Endereço"><InfoTable :rows="addressRows" /></AppCard>
            <AppCard title="Solicitante"><InfoTable :rows="requesterRows" /></AppCard>
            <AppCard title="Detalhes da ocorrência"><InfoTable :rows="detailRows" /></AppCard>
            <AppCard title="Detalhes do local">
                <InfoTable :rows="placeRows" />
                <div v-if="occurrence.fireprotections.length" class="mt-3">
                    <p class="text-xs font-medium text-gray-500">Proteção contra incêndio</p>
                    <ul class="mt-1 list-disc space-y-0.5 pl-5 text-sm text-gray-900">
                        <li v-for="protection in occurrence.fireprotections" :key="protection.id">{{ protection.name }}</li>
                    </ul>
                </div>
            </AppCard>
            <AppCard title="Detalhes do preenchedor"><InfoTable :rows="fillerRows" /></AppCard>

            <AppCard v-if="occurrence.victims.length" title="Vítimas">
                <div class="divide-y divide-gray-100">
                    <div v-for="victim in occurrence.victims" :key="victim.id" class="py-2.5">
                        <p class="text-sm font-medium text-gray-900">{{ victim.name }}, {{ victim.age }} anos — {{ victim.sex === 'M' ? 'Masculino' : 'Feminino' }}</p>
                        <p class="text-sm text-gray-500">{{ victimSituation(victim) }}</p>
                    </div>
                </div>
            </AppCard>

            <AppCard v-if="occurrence.resources.length" title="Recursos">
                <div class="divide-y divide-gray-100">
                    <div v-for="resource in occurrence.resources" :key="resource.id" class="py-2.5">
                        <p class="text-sm font-medium text-gray-900">{{ resource.who }} — {{ resource.what }}</p>
                        <p class="text-sm text-gray-500">{{ resource.where }} · {{ resource.how }}</p>
                    </div>
                </div>
            </AppCard>
        </div>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            title="Excluir ocorrência"
            :message="target ? `Tem certeza que deseja remover a ocorrência Nº ${target.id}? Vítimas e recursos associados também serão excluídos.` : ''"
            @cancel="cancel"
            @confirm="confirm('destroy-occurrence', target?.id)"
        />
    </AppLayout>
</template>
