<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Pencil, Trash2, Plus, ShieldCheck } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

defineProps({
    users: { type: Array, required: true },
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();
</script>

<template>
    <AppLayout>
        <template #header>Usuários</template>

        <div class="mb-4 flex justify-end">
            <AppButton v-if="isAdmin()" :as="Link" :href="route('register')" variant="success">
                <Plus class="h-4 w-4" /> Adicionar
            </AppButton>
        </div>

        <div class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
            <div v-for="user in users" :key="user.id" class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                <Link :href="route('show-user', user.id)" class="font-medium text-gray-900 hover:text-brand-blue">
                    {{ user.name }}
                    <span v-if="user.admin" class="ml-2 inline-flex items-center gap-1 rounded-full bg-brand-blue/10 px-2 py-0.5 text-xs font-medium text-brand-blue">
                        <ShieldCheck class="h-3 w-3" /> Administrador
                    </span>
                </Link>
                <div v-if="isAdmin()" class="flex items-center gap-2">
                    <AppButton :as="Link" :href="route('edit-user', user.id)" size="sm">
                        <Pencil class="h-3.5 w-3.5" /> Atualizar
                    </AppButton>
                    <AppButton type="button" variant="danger" size="sm" @click="ask(user)">
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
            @confirm="confirm('destroy-user', target?.id)"
        />
    </AppLayout>
</template>
