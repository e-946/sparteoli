<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Pencil, Trash2 } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import ErrorBanner from '../../Components/ErrorBanner.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';
import { formatDateTime } from '../../format.js';

const props = defineProps({
    title: { type: String, required: true },
    backRoute: { type: String, required: true },
    routes: { type: Object, required: true }, // { edit, destroy }
    item: { type: Object, required: true }, // { id, name }
    desc: { type: String, default: null },
    stats: { type: Array, default: () => [] }, // [{ label, value }]
    related: { type: Object, default: null }, // { label, items: [{ id, name, route }] }
    createdAt: { type: String, default: null },
    updatedAt: { type: String, default: null },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();
</script>

<template>
    <AppLayout>
        <template #header>{{ title }}</template>

        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route(backRoute)" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>

            <div v-if="isAdmin()" class="flex items-center gap-2">
                <AppButton :as="Link" :href="route(routes.edit, item.id)">
                    <Pencil class="h-4 w-4" /> Atualizar
                </AppButton>
                <AppButton type="button" variant="danger" @click="ask(item)">
                    <Trash2 class="h-4 w-4" /> Excluir
                </AppButton>
            </div>
        </div>

        <ErrorBanner />

        <AppCard>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-sm font-semibold text-gray-900">Informações</h3>
                <span v-for="stat in stats" :key="stat.label" class="text-xs text-gray-500">{{ stat.label }}: {{ stat.value }}</span>
            </div>
            <p v-if="desc" class="mt-2 text-sm text-gray-700">{{ desc }}</p>

            <div v-if="related?.items?.length" class="mt-4 space-y-1">
                <p class="text-xs font-medium text-gray-500">{{ related.label }}</p>
                <Link
                    v-for="related_item in related.items"
                    :key="related_item.id"
                    :href="route(related_item.route, related_item.id)"
                    class="block rounded-md px-3 py-1.5 text-sm text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-gray-50"
                >
                    {{ related_item.name }}
                </Link>
            </div>

            <p v-if="createdAt" class="mt-4 text-xs text-gray-500">Criado em: {{ formatDateTime(createdAt) }}</p>
            <p v-if="updatedAt" class="text-xs text-gray-500">Última alteração: {{ formatDateTime(updatedAt) }}</p>
        </AppCard>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover ${target.name}?` : ''"
            @cancel="cancel"
            @confirm="confirm(routes.destroy, target?.id)"
        />
    </AppLayout>
</template>
