<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Pencil, Trash2, Plus } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import ErrorBanner from '../../Components/ErrorBanner.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

const props = defineProps({
    victims: { type: Array, required: true },
    occurrence_id: { type: Number, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();
</script>

<template>
    <AppLayout>
        <template #header>Vítimas</template>

        <ErrorBanner />

        <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route('show-occurrence', occurrence_id)" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>
            <AppButton :as="Link" :href="route('create-victim', occurrence_id)" variant="success">
                <Plus class="h-4 w-4" /> Adicionar
            </AppButton>
        </div>

        <div class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
            <div v-for="victim in victims" :key="victim.id" class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                <Link :href="route('show-victim', { occurrence_id, id: victim.id })" class="font-medium text-gray-900 hover:text-brand-blue">
                    {{ victim.name }}
                </Link>
                <div v-if="isAdmin()" class="flex items-center gap-2">
                    <AppButton :as="Link" :href="route('edit-victim', { occurrence_id, id: victim.id })" size="sm">
                        <Pencil class="h-3.5 w-3.5" /> Atualizar
                    </AppButton>
                    <AppButton type="button" variant="danger" size="sm" @click="ask(victim)">
                        <Trash2 class="h-3.5 w-3.5" /> Excluir
                    </AppButton>
                </div>
            </div>
        </div>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover ${target.name}?` : ''"
            @cancel="cancel"
            @confirm="confirm('destroy-victim', { occurrence_id, id: target?.id })"
        />
    </AppLayout>
</template>
