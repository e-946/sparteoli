<script setup>
import { ref } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { Menu, X, LogOut, ChevronDown, Plus } from 'lucide-vue-next';
import FlashBanner from '../Components/FlashBanner.vue';
import { mainNav, lookupNav, adminNav, profileNav } from '../navigation.js';

const page = usePage();
const user = () => page.props.auth.user;

const sidebarOpen = ref(false);
const lookupOpen = ref(lookupNav.items.some((item) => route().current(item.route)));

function logout() {
    router.post(route('logout'));
}
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"
            @click="sidebarOpen = false"
        />

        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-brand-blue text-blue-100 transition-transform lg:translate-x-0"
            :class="{ '!translate-x-0': sidebarOpen }"
        >
            <div class="flex h-16 items-center gap-2 px-5">
                <img src="/img/logo-insignia.png" alt="" class="h-8 w-8 rounded-full">
                <span class="text-lg font-bold text-white">Sparteoli</span>
                <button type="button" class="ml-auto text-blue-200 lg:hidden" @click="sidebarOpen = false">
                    <X class="h-5 w-5" />
                </button>
            </div>

            <div class="px-3 pt-4">
                <Link
                    :href="route('create-occurrence')"
                    class="flex items-center justify-center gap-2 rounded-md bg-brand-yellow px-3 py-2 text-sm font-semibold text-brand-black transition-colors hover:bg-yellow-400"
                >
                    <Plus class="h-4 w-4" /> Nova ocorrência
                </Link>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm">
                <Link
                    v-for="item in mainNav"
                    :key="item.route"
                    :href="route(item.route)"
                    class="flex items-center gap-2.5 rounded-md px-3 py-2 transition-colors"
                    :class="route().current(item.route) ? 'bg-white/10 text-white' : 'hover:bg-white/5 hover:text-white'"
                >
                    <component :is="item.icon" class="h-4 w-4 shrink-0" />
                    {{ item.text }}
                </Link>

                <div>
                    <button
                        type="button"
                        class="flex w-full items-center gap-2.5 rounded-md px-3 py-2 transition-colors hover:bg-white/5 hover:text-white"
                        @click="lookupOpen = !lookupOpen"
                    >
                        <component :is="lookupNav.icon" class="h-4 w-4 shrink-0" />
                        <span class="flex-1 text-left">{{ lookupNav.text }}</span>
                        <ChevronDown class="h-3.5 w-3.5 transition-transform" :class="{ 'rotate-180': lookupOpen }" />
                    </button>
                    <div v-show="lookupOpen" class="mt-1 space-y-1 border-l border-white/10 pl-6">
                        <Link
                            v-for="item in lookupNav.items"
                            :key="item.route"
                            :href="route(item.route)"
                            class="block rounded-md px-3 py-1.5 text-[13px] transition-colors"
                            :class="route().current(item.route) ? 'bg-white/10 text-white' : 'text-blue-100/80 hover:bg-white/5 hover:text-white'"
                        >
                            {{ item.text }}
                        </Link>
                    </div>
                </div>

                <template v-if="user()?.admin">
                    <Link
                        v-for="item in adminNav"
                        :key="item.route"
                        :href="route(item.route)"
                        class="flex items-center gap-2.5 rounded-md px-3 py-2 transition-colors"
                        :class="route().current(item.route) ? 'bg-white/10 text-white' : 'hover:bg-white/5 hover:text-white'"
                    >
                        <component :is="item.icon" class="h-4 w-4 shrink-0" />
                        {{ item.text }}
                    </Link>
                </template>

                <div class="my-3 border-t border-white/10" />

                <Link
                    v-for="item in profileNav"
                    :key="item.route"
                    :href="route(item.route)"
                    class="flex items-center gap-2.5 rounded-md px-3 py-2 transition-colors"
                    :class="route().current(item.route) ? 'bg-white/10 text-white' : 'hover:bg-white/5 hover:text-white'"
                >
                    <component :is="item.icon" class="h-4 w-4 shrink-0" />
                    {{ item.text }}
                </Link>
            </nav>

            <div class="border-t border-white/10 p-3">
                <button
                    type="button"
                    class="flex w-full items-center gap-2.5 rounded-md px-3 py-2 text-sm text-blue-100 transition-colors hover:bg-white/5 hover:text-white"
                    @click="logout"
                >
                    <LogOut class="h-4 w-4" />
                    Sair
                </button>
            </div>
        </aside>

        <div class="flex min-h-screen flex-col lg:pl-64">
            <header class="flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 sm:px-6">
                <button type="button" class="text-gray-500 lg:hidden" @click="sidebarOpen = true">
                    <Menu class="h-6 w-6" />
                </button>
                <h1 class="text-base font-semibold text-gray-900">
                    <slot name="header" />
                </h1>
                <div class="ml-auto flex items-center gap-2 text-sm text-gray-600">
                    <Link :href="route('profile')" class="font-medium hover:text-brand-blue">{{ user()?.name }}</Link>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                <FlashBanner />
                <slot />
            </main>
        </div>
    </div>
</template>
