<script setup>
import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Pencil, Trash2, Plus } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppButton from '../../Components/AppButton.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';
import ErrorBanner from '../../Components/ErrorBanner.vue';
import SlideOver from '../../Components/SlideOver.vue';
import DynamicFieldGrid from '../../Components/DynamicFieldGrid.vue';
import { useDeleteConfirm } from '../../composables/useDeleteConfirm.js';

const props = defineProps({
    title: { type: String, required: true },
    items: { type: Array, required: true },
    fields: { type: Array, required: true }, // [{ key, label, type, options?, required? }]
    routes: { type: Object, required: true }, // { index, create, store, show?, edit, update, destroy }
});

const page = usePage();
const isAdmin = () => page.props.auth.user?.admin;

const { target, processing, ask, cancel, confirm } = useDeleteConfirm();

const panelOpen = ref(false);
const editingItem = ref(null);
const form = ref(null);

function buildForm(item) {
    const initial = {};
    props.fields.forEach((field) => {
        initial[field.key] = item?.[field.key] ?? '';
    });

    return useForm(initial);
}

function openCreate() {
    editingItem.value = null;
    form.value = buildForm(null);
    panelOpen.value = true;
}

function openEdit(item) {
    editingItem.value = item;
    form.value = buildForm(item);
    panelOpen.value = true;
}

function closePanel() {
    panelOpen.value = false;
}

function submit() {
    const options = { onSuccess: closePanel, preserveScroll: true };

    if (editingItem.value) {
        form.value.put(route(props.routes.update, editingItem.value.id), options);
    } else {
        form.value.post(route(props.routes.store), options);
    }
}
</script>

<template>
    <AppLayout>
        <template #header>{{ title }}</template>

        <ErrorBanner />

        <div v-if="isAdmin()" class="mb-4 flex justify-end">
            <AppButton type="button" variant="success" @click="openCreate">
                <Plus class="h-4 w-4" /> Adicionar
            </AppButton>
        </div>

        <div v-if="items.length === 0" class="rounded-lg bg-white p-6 text-center text-sm text-gray-500 shadow-sm ring-1 ring-gray-950/5">
            Nenhum registro encontrado.
        </div>

        <div v-else class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-950/5">
            <div v-for="item in items" :key="item.id" class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                <Link v-if="routes.show" :href="route(routes.show, item.id)" class="font-medium text-gray-900 hover:text-brand-blue">
                    {{ item.name }}
                    <span v-if="item.subtitle" class="block text-xs font-normal text-gray-500">{{ item.subtitle }}</span>
                </Link>
                <span v-else class="font-medium text-gray-900">
                    {{ item.name }}
                    <span v-if="item.subtitle" class="block text-xs font-normal text-gray-500">{{ item.subtitle }}</span>
                </span>
                <div v-if="isAdmin()" class="flex items-center gap-2">
                    <AppButton type="button" size="sm" @click="openEdit(item)">
                        <Pencil class="h-3.5 w-3.5" /> Atualizar
                    </AppButton>
                    <AppButton type="button" variant="danger" size="sm" @click="ask(item)">
                        <Trash2 class="h-3.5 w-3.5" /> Excluir
                    </AppButton>
                </div>
            </div>
        </div>

        <SlideOver :show="panelOpen" :title="editingItem ? `Atualizar ${editingItem.name}` : 'Adicionar'" @close="closePanel">
            <form v-if="form" @submit.prevent="submit">
                <DynamicFieldGrid :fields="fields" :form="form" />

                <div class="mt-6 flex items-center gap-3">
                    <AppButton type="submit" class="flex-1" :disabled="form.processing">Salvar</AppButton>
                    <AppButton type="button" variant="secondary" @click="closePanel">Cancelar</AppButton>
                </div>
            </form>
        </SlideOver>

        <ConfirmDialog
            :show="!!target"
            :processing="processing"
            :message="target ? `Tem certeza que deseja remover ${target.name}?` : ''"
            @cancel="cancel"
            @confirm="confirm(routes.destroy, target?.id)"
        />
    </AppLayout>
</template>
