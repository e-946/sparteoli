<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: { type: Array, required: true }, // Laravel paginator's `links` array
});
</script>

<template>
    <nav v-if="links.length > 3" class="mt-4 flex flex-wrap items-center justify-center gap-1">
        <template v-for="(link, i) in links" :key="i">
            <span
                v-if="!link.url"
                class="rounded-md px-3 py-1.5 text-sm text-gray-400"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                class="rounded-md px-3 py-1.5 text-sm"
                :class="link.active ? 'bg-brand-blue text-white' : 'text-gray-700 hover:bg-gray-100'"
                v-html="link.label"
            />
        </template>
    </nav>
</template>
