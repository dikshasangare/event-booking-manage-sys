<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link, usePage } from "@inertiajs/vue3";
import AdminLayout from "./SidebarLayout.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const page = usePage();
const isOpen = ref(false);
const isMinimized = ref(false);

// --- Layout Toggle Logic ---
const toggleSidebar = () => {
    if (window.innerWidth >= 1024) {
        isMinimized.value = !isMinimized.value;
    } else {
        isOpen.value = !isOpen.value;
    }
};
const handleResize = () => {
    if (window.innerWidth >= 1024) {
        isOpen.value = true;
    }
};
onMounted(() => {
    window.addEventListener("resize", handleResize);
});
onUnmounted(() => {
    window.removeEventListener("resize", handleResize);
});

const isNotCustomer = computed(() => {
    return (
        Array.isArray(page.props.auth.roles) &&
        !page.props.auth.roles.includes("Customer")
    );
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-200 bg-white fixed top-0 left-0 w-full z-50"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-full">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div
                                class="flex items-center w-20 bg-cyan-800"
                                v-if="$page?.props?.auth?.roles != 'Customer'"
                            >
                                <button
                                    @click="toggleSidebar"
                                    class="text-cyan-100 hover:text-cyan-100 focus:outline-none mx-auto"
                                >
                                    <svg
                                        xmlns="www.w3.org"
                                        class="w-6 h-6 text-cyan-100 hover:text-cyan-100"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            v-if="!isOpen || isMinimized"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 6h16M4 12h16m-7 6h7"
                                        />
                                        <path
                                            v-if="isOpen && !isMinimized"
                                            class="hidden lg:block"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 19l-7-7 7-7"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    v-if="
                                        $page?.props?.auth?.roles == 'Customer'
                                    "
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Customer Dashboard
                                </NavLink>
                            </div>

                            <div v-if="$page?.props?.auth?.roles != 'Customer'">
                                <AdminLayout
                                    :isOpen="isOpen"
                                    :isMinimized="isMinimized"
                                    @toggle="isOpen = !isOpen"
                                />
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div
                :class="{
                    'lg:pl-64': isNotCustomer && !isMinimized,
                    'lg:pl-20': isNotCustomer && isMinimized,
                }"
                class="flex-1 pt-16 flex flex-col overflow-hidden transition-all duration-300 ease-in-out"
            >
                <!-- Page Heading -->
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="mx-auto max-w-full px-4 py-6 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
