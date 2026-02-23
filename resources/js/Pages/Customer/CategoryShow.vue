<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import { ref } from "vue";

defineProps({
    category: Object,
    events: Object,
});
</script>

<template>
    <Head :title="category.name" />

    <CustomerLayout>
        <div class="relative">
            <div
                class="relative bg-gradient-to-b from-cyan-500 to-cyan-800 h-[60vh] sm:h-[65vh] md:h-[70vh] lg:h-[75vh] flex flex-col items-center justify-end text-white px-4 bg-cover bg-center rounded-b-3xl"
                :style="{
                    backgroundImage: `url('https://images.unsplash.com/photo-1694898971137-2f5078bceed7?q=80&w=1632&auto=format&fit=crop')`,
                }"
            >
                <!-- Overlay -->
                <div
                    class="absolute inset-0 bg-black/40 md:bg-black/45 rounded-b-3xl"
                ></div>

                <!-- Content -->
                <div
                    class="relative z-10 px-4 sm:px-6 md:px-8 mb-16 sm:mb-20 lg:mb-24 text-center"
                >
                    <!-- Title -->
                    <h1
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white drop-shadow-lg"
                    >
                        {{ category.name }} Events
                    </h1>

                    <p class="text-sm text-white/80 mt-3">
                        Secure bookings • Instant confirmation • Digital tickets
                    </p>
                    <!-- Breadcrumb -->
                    <nav
                        aria-label="breadcrumb"
                        class="flex justify-center text-gray-200"
                    >
                        <ol
                            class="flex items-center justify-center gap-1 sm:gap-2 px-2 py-1 sm:px-4 sm:py-2 text-sm sm:text-base md:text-lg"
                        >
                            <li
                                class="opacity-80 hover:text-cyan-400 transition"
                            >
                                <a href="/" class="inline-flex">
                                    <Icon
                                        name="home"
                                        :class="'h-4 w-4 sm:h-5 sm:w-5 md:h-5 md:w-5 mt-0.5 mx-1'"
                                    />
                                    Home</a
                                >
                            </li>
                            <span class="text-gray-300 mx-1">/</span>
                            <li
                                class="font-semibold hover:text-cyan-400 transition"
                            >
                                Categories
                            </li>
                            <span class="text-gray-300">/</span>
                            <li class="font-semibold text-white">
                                {{ category.name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="py-16 px-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                <!-- Sidebar Filters -->
                <aside class="lg:col-span-1">
                    <h1 class="text-2xl font-bold text-cyan-700 mb-5">
                        Filters
                    </h1>
                    <div
                        class="bg-white shadow rounded-xl p-6 sticky top-24 space-y-6"
                    >
                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Event Date
                            </label>
                            <input
                                type="date"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Location
                            </label>
                            <input
                                type="text"
                                placeholder="Enter city"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500"
                            />
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">
                                Max Price
                            </label>
                            <input
                                type="range"
                                min="0"
                                max="10000"
                                class="w-full"
                            />
                        </div>

                        <button
                            class="w-full bg-cyan-600 text-white py-2 rounded-lg hover:bg-cyan-700 transition"
                        >
                            Apply Filters
                        </button>
                    </div>
                </aside>

                <!-- Events Grid -->
                <div class="lg:col-span-3">
                    <div class="mb-10">
                        <h1 class="text-3xl font-bold text-cyan-700">
                            {{ category.name }} Events
                        </h1>

                        <p class="text-sm text-cyan-700 my-2">
                            Discover the best
                            {{ category.name.toLowerCase() }} experiences near
                            you. Browse upcoming events, exclusive passes,
                            workshops, and live shows — all in one place.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="event in events.data"
                            :key="event.id"
                            class="relative rounded-xl overflow-hidden bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15 flex flex-col h-full border"
                        >
                            <div
                                class="absolute inset-0 rounded-b-xl bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15"
                            ></div>

                            <!-- Card -->
                            <div
                                class="relative rounded-xl overflow-hidden bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15"
                            >
                                <!-- Image -->
                                <div class="relative h-64 overflow-hidden">
                                    <img
                                        :src="
                                            event.banner_image
                                                ? `/storage/${event.banner_image}`
                                                : 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4'
                                        "
                                        class="absolute inset-0 w-full h-full object-cover transition-all duration-[1200ms]"
                                        :class="{
                                            'scale-110 group-hover:scale-125':
                                                event.status !== 'cancelled',
                                            'grayscale blur-[1px] scale-105 opacity-70':
                                                event.status === 'cancelled',
                                        }"
                                    />

                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"
                                    ></div>
                                    <!-- Title -->
                                    <div
                                        class="absolute bottom-6 left-6 right-6 text-white"
                                    >
                                        <p
                                            class="text-xs pb-1 uppercase tracking-[0.25em]"
                                        >
                                            {{ event.event_type }}
                                        </p>
                                        <h2
                                            class="text-xl font-black leading-tight tracking-tight line-clamp-1"
                                        >
                                            {{ event.title }}
                                        </h2>
                                    </div>

                                    <div>
                                        <!-- Featured -->
                                        <div
                                            v-if="event.is_private"
                                            class="absolute top-6 right-6 bg-white/90 text-cyan-800 text-xs font-black px-4 py-1.5 rounded-full"
                                        >
                                            PRIVATE
                                        </div>
                                        <div
                                            v-else
                                            class="absolute top-6 right-6 bg-white/90 text-cyan-800 text-xs font-black px-4 py-1.5 rounded-full"
                                        >
                                            FEATURED
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Actions -->
                                <div class="relative px-3 py-6 min-h-[96px]">
                                    <div
                                        class="rounded-3xl p-1 space-y-4 flex-1"
                                    >
                                        <p
                                            class="text-sm text-gray-700 leading-relaxed line-clamp-1"
                                        >
                                            {{ event.short_description }}
                                        </p>

                                        <!-- Meta -->
                                        <div
                                            class="grid grid-cols-2 gap-y-3 text-[11px] font-semibold text-gray-600 tracking-wide"
                                        >
                                            <div>
                                                📅
                                                {{
                                                    new Date(
                                                        event.start_datetime,
                                                    ).toLocaleDateString(
                                                        undefined,
                                                        {
                                                            weekday: "short",
                                                            month: "short",
                                                            day: "numeric",
                                                        },
                                                    )
                                                }}
                                            </div>

                                            <div>
                                                🗣
                                                {{
                                                    event.language ??
                                                    "Any Language"
                                                }}
                                            </div>

                                            <div>
                                                🔞
                                                {{
                                                    event.age_limit
                                                        ? event.age_limit + "+"
                                                        : "All Ages"
                                                }}
                                            </div>

                                            <div
                                                class="inline-flex items-center gap-2"
                                            >
                                                <span
                                                    class="w-2 h-2 rounded-full"
                                                    :class="
                                                        event.max_capacity
                                                            ? 'bg-emerald-500'
                                                            : 'bg-rose-500'
                                                    "
                                                ></span>
                                                {{
                                                    event.max_capacity
                                                        ? "Tickets Available"
                                                        : "Sold Out"
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-6 sm:flex sm:items-center sm:justify-between"
                    >
                        <!-- Page Info -->
                        <div class="text-sm text-gray-500">
                            Page
                            <span class="font-medium text-gray-700">
                                {{ events.current_page }} of
                                {{ events.last_page }}
                            </span>
                        </div>

                        <!-- Pagination -->
                        <div class="flex items-center mt-4 gap-x-2 sm:mt-0">
                            <!-- Previous Button -->
                            <button
                                class="flex items-center justify-center px-3 py-2 text-sm bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                                :class="{
                                    'text-gray-400 cursor-not-allowed':
                                        !events.prev_page_url,
                                }"
                                :disabled="!events.prev_page_url"
                                @click="
                                    events.prev_page_url &&
                                    router.visit(events.prev_page_url)
                                "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5 rtl:-scale-x-100"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"
                                    />
                                </svg>
                                <span>Previous</span>
                            </button>

                            <!-- Number Buttons -->
                            <template
                                v-for="link in events.links"
                                :key="link.label"
                            >
                                <button
                                    v-if="Number(link.label)"
                                    @click="link.url && router.visit(link.url)"
                                    class="px-3 py-1 rounded border"
                                    :class="{
                                        'bg-cyan-600 text-white': link.active,
                                        'hover:bg-gray-100':
                                            link.url && !link.active,
                                        'text-gray-400 cursor-not-allowed':
                                            !link.url,
                                    }"
                                    :disabled="!link.url"
                                >
                                    {{ link.label }}
                                </button>
                            </template>

                            <!-- Next Button -->
                            <button
                                class="flex items-center justify-center px-3 py-2 text-sm bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                                :class="{
                                    'text-gray-400 cursor-not-allowed':
                                        !events.next_page_url,
                                }"
                                :disabled="!events.next_page_url"
                                @click="
                                    events.next_page_url &&
                                    router.visit(events.next_page_url)
                                "
                            >
                                <span>Next</span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5 rtl:-scale-x-100"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
