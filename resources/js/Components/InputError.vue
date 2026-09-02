<script setup>
defineProps({
    message: { type: String, default: null },
});
</script>

<template>
    <p v-if="message" class="mt-1 text-sm text-brand-red">{{ message }}</p>
</template>
