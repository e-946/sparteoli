<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Pencil, Key, Trash2, ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';
import { formatDateTime } from '../../format.js';

const props = defineProps({
    user: { type: Object, required: true },
    occurrencesCount: { type: Number, required: true },
    backRoute: { type: String, default: 'index-user' },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;
const isSelf = () => page.props.auth.user?.id === props.user.id;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();
</script>

<template>
    <AppLayout>
        <template #header>{{ user.name }}</template>

        <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
            <AppButton :as="Link" :href="route(backRoute)" variant="secondary">
                <ArrowLeft class="h-4 w-4" /> Voltar
            </AppButton>

            <div v-if="isAdmin()" class="flex items-center gap-2">
                <AppButton :as="Link" :href="route('edit-user', user.id)">
                    <Pencil class="h-4 w-4" /> Atualizar
                </AppButton>
                <AppButton :as="Link" :href="route('passwordId', user.id)">
                    <Key class="h-4 w-4" /> Alterar senha
                </AppButton>
                <AppButton v-if="!isSelf()" type="button" variant="danger" @click="ask(user)">
                    <Trash2 class="h-4 w-4" /> Excluir
                </AppButton>
            </div>
        </div>

        <AppCard>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-sm font-semibold text-gray-900">Informações</h3>
                <span v-if="user.admin" class="text-xs font-medium text-brand-blue">Administrador</span>
            </div>
            <p class="mt-2 text-sm text-gray-700">Usuário cadastrou {{ occurrencesCount }} ocorrências</p>
            <p v-if="user.created_at" class="mt-2 text-xs text-gray-500">Criado em: {{ formatDateTime(user.created_at) }}</p>
            <p v-if="user.updated_at" class="text-xs text-gray-500">Última alteração: {{ formatDateTime(user.updated_at) }}</p>
        </AppCard>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover ${target.name}?` : ''"
            @cancel="cancel"
            @confirm="confirm('destroy-user', target?.id)"
        />
    </AppLayout>
</template>
