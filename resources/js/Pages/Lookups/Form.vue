<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import AppLayout from '../../Layouts/AppLayout.vue';
import AppCard from '../../Components/AppCard.vue';
import AppButton from '../../Components/AppButton.vue';
import DynamicFieldGrid from '../../Components/DynamicFieldGrid.vue';
import ConfirmDialog from '../../Components/ConfirmDialog.vue';

const props = defineProps({
    title: { type: String, required: true },
    backRoute: { type: String, required: true },
    backRouteParams: { type: [Object, Number, String], default: null },
    submitRoute: { type: String, required: true },
    submitRouteParams: { type: [Object, Number, String], default: null },
    mode: { type: String, required: true }, // 'create' | 'edit'
    item: { type: Object, default: null },
    fields: { type: Array, required: true }, // [{ key, label, type: 'text'|'textarea'|'select', options?, required? }]
    confirmLabel: { type: String, default: null }, // if set, edit submits go through a confirm dialog with this item name
});

const initial = {};
props.fields.forEach((field) => {
    initial[field.key] = props.item?.[field.key] ?? '';
});

const form = useForm(initial);
const confirming = ref(false);

const multiColumn = props.fields.length > 1;

function attemptSubmit() {
    if (props.mode === 'edit' && props.confirmLabel) {
        confirming.value = true;
        return;
    }

    submit();
}

function submit() {
    confirming.value = false;

    const url = route(props.submitRoute, props.submitRouteParams ?? undefined);

    if (props.mode === 'edit') {
        form.put(url);
    } else {
        form.post(url);
    }
}
</script>

<template>
    <AppLayout>
        <template #header>{{ title }}</template>

        <AppButton :as="Link" :href="route(backRoute, backRouteParams ?? undefined)" variant="secondary" class="mb-5">
            <ArrowLeft class="h-4 w-4" /> Voltar
        </AppButton>

        <AppCard class="mx-auto" :class="multiColumn ? 'max-w-2xl' : 'max-w-lg'">
            <form @submit.prevent="attemptSubmit">
                <DynamicFieldGrid :fields="fields" :form="form" />

                <div class="mt-8 flex flex-col-reverse items-center gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <AppButton :as="Link" :href="route(backRoute, backRouteParams ?? undefined)" variant="secondary" class="w-full sm:w-auto">
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
            :message="`Tem certeza que deseja atualizar ${confirmLabel}?`"
            @cancel="confirming = false"
            @confirm="submit"
        />
    </AppLayout>
</template>
