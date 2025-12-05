<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const page = usePage();
const showingNavigationDropdown = ref(false);

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// Detect if user is logged in
const isAuthenticated = computed(() => {
    return (
        page.props?.auth?.user !== null && page.props?.auth?.user !== undefined
    );
});

const user = usePage().props.auth?.user;

const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20; // change when scrolled
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <div class="min-h-screen bg-transparent">
        <nav
            :class="[
                'fixed top-0 left-0 w-full z-50 transition-all duration-300',
                isScrolled ? 'bg-white shadow-md' : 'bg-transparent',
            ]"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <Link :href="'/'">
                            <ApplicationLogo class="text-3xl"
                                :class="
                                    isScrolled
                                        ? 'hover:text-cyan-800'
                                        : 'text-white hover:text-gray-200'
                                "
                            />
                        </Link>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <Link
                            href="/events"
                            :class="
                                isScrolled
                                    ? 'hover:text-cyan-800'
                                    : 'text-white hover:text-gray-200'
                            "
                            >Events</Link
                        >
                        <Link
                            href="/categories"
                            :class="
                                isScrolled
                                    ? 'hover:text-cyan-800'
                                    : 'text-white hover:text-gray-200'
                            "
                            >Categories</Link
                        >
                        <!-- If user is logged in -->
                        <template v-if="isAuthenticated">
                            <Link
                                href="/my-tickets"
                                :class="
                                    isScrolled
                                        ? 'hover:text-cyan-800'
                                        : 'text-white hover:text-gray-200'
                                "
                                v-if="user"
                            >
                                My Tickets
                            </Link>

                            <Link
                                href="/my-bookings"
                                :class="
                                    isScrolled
                                        ? 'hover:text-cyan-800'
                                        : 'text-white hover:text-gray-200'
                                "
                                v-if="user"
                            >
                                My Bookings
                            </Link>
                        </template>

                        <!-- If user is NOT logged in -->
                        <template v-else>
                            <Link
                                :href="route('login')"
                                :class="
                                    isScrolled
                                        ? 'hover:text-cyan-800'
                                        : 'text-white hover:text-gray-200'
                                "
                            >
                                Log in
                            </Link>

                            <Link
                                :href="route('register')"
                                :class="
                                    isScrolled
                                        ? 'hover:text-cyan-800'
                                        : 'text-white hover:text-gray-200'
                                "
                            >
                                Register
                            </Link>
                        </template>
                    </div>

                    <!-- User Dropdown (only when logged in) -->
                    <div
                        class="hidden sm:flex sm:items-center"
                        v-if="isAuthenticated"
                    >
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="inline-flex items-center rounded-md px-3 py-2 text-sm "
                                    :class="
                                        isScrolled
                                            ? 'hover:text-cyan-800'
                                            : 'text-white hover:text-gray-200'
                                    "
                                >
                                    {{ page.props.auth.user.name }}
                                    <svg
                                        class="ms-2 h-4 w-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')"
                                    >Profile</DropdownLink
                                >
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

                    <!-- Mobile Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="rounded-md p-2 bg-gray-100 text-gray-700"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <!-- When user is logged in -->
            <div
                v-if="isAuthenticated"
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden bg-white"
            >
                <ResponsiveNavLink
                    :href="'/'"
                    :class="
                        isScrolled
                            ? 'hover:text-cyan-800'
                            : 'text-white hover:text-gray-200'
                    "
                    >Home</ResponsiveNavLink
                >
                <ResponsiveNavLink
                    :href="route('events')"
                    :class="
                        isScrolled
                            ? 'hover:text-cyan-800'
                            : 'text-white hover:text-gray-200'
                    "
                    >Events</ResponsiveNavLink
                >
                <ResponsiveNavLink
                    :href="route('categories')"
                    :class="
                        isScrolled
                            ? 'hover:text-cyan-800'
                            : 'text-white hover:text-gray-200'
                    "
                    >Categories</ResponsiveNavLink
                >
                <!-- If user is logged in -->
                <template v-if="isAuthenticated">
                    <ResponsiveNavLink
                        :href="route('my-tickets')"
                        :class="
                            isScrolled
                                ? 'hover:text-cyan-800'
                                : 'text-white hover:text-gray-200'
                        "
                        v-if="user"
                    >
                        My Tickets
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('my-bookings')"
                        :class="
                            isScrolled
                                ? 'hover:text-cyan-800'
                                : 'text-white hover:text-gray-200'
                        "
                        v-if="user"
                    >
                        My Bookings
                    </ResponsiveNavLink>
                </template>

                <div class="border-t border-gray-200 mt-3">
                    <div class="px-4 pt-4 text-gray-800 font-medium">
                        {{ page.props.auth.user.name }}
                    </div>

                    <div class="mt-3">
                        <ResponsiveNavLink :href="route('profile.edit')"
                            >Profile</ResponsiveNavLink
                        >
                        <ResponsiveNavLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>

            <!-- When user is NOT logged in -->
            <div
                v-else
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden bg-white border-t pt-4 pb-3"
            >
                <ResponsiveNavLink
                    :href="route('login')"
                    :class="
                        isScrolled
                            ? 'hover:text-cyan-800'
                            : 'text-white hover:text-gray-200'
                    "
                    >Log in</ResponsiveNavLink
                >
                <ResponsiveNavLink
                    :href="route('register')"
                    :class="
                        isScrolled
                            ? 'hover:text-cyan-800'
                            : 'text-white hover:text-gray-200'
                    "
                >
                    Register
                </ResponsiveNavLink>
            </div>
        </nav>

        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Body -->
        <main>
            <slot />
        </main>
    </div>
</template>
