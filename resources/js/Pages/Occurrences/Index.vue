<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Pencil, Trash2, Plus } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import ErrorBanner from '../../Components/ErrorBanner.vue';
import Pagination from '../../Components/Pagination.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

defineProps({
    occurrences: { type: Object, required: true }, // Laravel paginator
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();
</script>

<template>
    <AppLayout>
        <template #header>Ocorrências</template>

        <ErrorBanner />

        <div class="mb-4 flex justify-end">
            <AppButton :as="Link" :href="route('create-occurrence')" variant="success">
                <Plus class="h-4 w-4" /> Adicionar
            </AppButton>
        </div>

        <div v-if="occurrences.data.length === 0" class="rounded-lg bg-white p-6 text-center text-sm text-gray-500 shadow-sm ring-1 ring-gray-950/5">
            Nenhuma ocorrência registrada.
        </div>

        <div v-else class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
            <div v-for="occurrence in occurrences.data" :key="occurrence.id" class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                <Link :href="route('show-occurrence', occurrence.id)" class="font-medium text-gray-900 hover:text-brand-blue">
                    Nº {{ occurrence.id }} — Preenchido por: {{ occurrence.filler_name }}
                </Link>
                <div v-if="isAdmin()" class="flex items-center gap-2">
                    <AppButton :as="Link" :href="route('edit-occurrence', occurrence.id)" size="sm">
                        <Pencil class="h-3.5 w-3.5" /> Atualizar
                    </AppButton>
                    <AppButton type="button" variant="danger" size="sm" @click="ask(occurrence)">
                        <Trash2 class="h-3.5 w-3.5" /> Excluir
                    </AppButton>
                </div>
            </div>
        </div>

        <Pagination :links="occurrences.links" />

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
