<script setup>
import FlashBanner from '../Components/FlashBanner.vue';
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-brand-blue px-4">
        <div class="w-full max-w-sm">
            <div class="mb-6 flex flex-col items-center gap-2 text-white">
                <img src="/img/logo-insignia.png" alt="Sparteoli" class="h-16 w-16 rounded-full">
                <h1 class="text-xl font-bold">Sparteoli</h1>
            </div>
            <div class="rounded-lg bg-white p-6 shadow-xl sm:p-8">
                <FlashBanner />
                <slot />
            </div>
        </div>
    </div>
</template>
