<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

import { ref } from "vue";
import {
    MusicalNoteIcon,
    TrophyIcon,
    WrenchScrewdriverIcon,
    MicrophoneIcon,
    SparklesIcon,
} from "@heroicons/vue/24/outline";

const categories = ref([
    { name: "Concert", icon: MusicalNoteIcon },
    { name: "Sports", icon: TrophyIcon },
    { name: "Workshop", icon: WrenchScrewdriverIcon },
    { name: "Conference", icon: MicrophoneIcon },
    { name: "Festival", icon: SparklesIcon },
]);

const events = ref([
    {
        title: "Summer Music Festival 2025",
        location: "Mumbai, India",
        date: "March 18, 2025",
        image: "https://picsum.photos/600/400?random=1",
    },
    {
        title: "Tech Innovators Conference",
        location: "Bangalore, India",
        date: "April 02, 2025",
        image: "https://picsum.photos/600/400?random=2",
    },
    {
        title: "Digital Art Workshop",
        location: "Pune, India",
        date: "March 25, 2025",
        image: "https://picsum.photos/600/400?random=3",
    },
]);

const steps = ref([
    {
        title: "Browse Events",
        description:
            "Search concerts, shows, sports, conferences & more with smart filters.",
        icon: "search",
    },
    {
        title: "Choose Tickets",
        description:
            "Select seat categories, VIP packages or passes that best suit your needs.",
        icon: "TicketIcon",
    },
    {
        title: "Confirm Booking",
        description:
            "Make secure payments & instantly receive your digital/QR ticket.",
        icon: "ConfirmIcon",
    },
]);
</script>

<template>
    <Head title="Home" />

    <CustomerLayout>
        <!-- Hero Section -->
        <div class="relative">
            <div
                class="relative bg-gradient-to-b from-red-500 to-red-800 h-[80vh] sm:h-screen flex flex-col items-center justify-center text-white px-4 bg-cover bg-center"
                :style="{
                    backgroundImage: `url('https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=1469&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')`,
                }"
            >
                <div class="absolute inset-0 bg-black/45"></div>

                <div class="relative z-10 text-center px-4 sm:px-8">
                    <h1
                        class="text-4xl md:text-6xl font-extrabold text-white drop-shadow-lg"
                    >
                        Discover Events Near You
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mt-4 font-light">
                        Book tickets for concerts, sports, workshops,
                        conferences, and more.
                    </p>
                </div>
            </div>

            <div className="px-4">
                <div
                    className="relative w-full sm:absolute sm:-bottom-10 sm:left-0 mt-10 sm:mt-0"
                >
                    <div
                        className="bg-white border border-gray-300 shadow-xl rounded-2xl mx-auto max-w-full sm:max-w-4xl px-4 sm:px-6 md:px-8 py-6 sm:py-10"
                        :style="{
                            boxShadow:
                                '0px 0px 0px 8px rgba(255, 255, 255, 0.2)',
                        }"
                    >
                        <div
                            className="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-2"
                        >
                            <input
                                type="text"
                                placeholder="Search for events..."
                                class="flex-1 px-4 py-2 rounded-lg border focus:ring-2 focus:ring-cyan-500 focus:outline-none"
                            />
                            <button
                                class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition inline-flex"
                            >
                                <Icon name="search" />
                                <span class="px-2">Search</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <section class="py-16 mt-10 px-6 max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-cyan-700">
                Popular Categories
            </h2>
            <hr />
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 py-10"
            >
                <div
                    v-for="c in categories"
                    :key="c.name"
                    class="group relative cursor-pointer overflow-hidden bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl rounded-xl"
                >
                    <!-- expanding circle -->
                    <span
                        class="absolute top-10 z-0 h-20 w-20 rounded-full bg-cyan-500 transition-all duration-300 group-hover:scale-[10]"
                    ></span>

                    <div class="relative z-10 mx-auto max-w-md">
                        <!-- icon circle -->
                        <span
                            class="grid h-20 w-20 place-items-center rounded-full bg-cyan-500 transition-all duration-300 group-hover:bg-cyan-800"
                        >
                            <component
                                :is="c.icon"
                                class="h-10 w-10 text-white transition-all"
                            />
                        </span>

                        <!-- name -->
                        <div
                            class="space-y-6 pt-5 text-base leading-7 text-gray-600 transition-all duration-300 group-hover:text-white/90"
                        >
                            <p>{{ c.name }}</p>
                        </div>

                        <!-- link -->
                        <div class="pt-5 text-base font-semibold leading-7">
                            <p>
                                <a
                                    href="#"
                                    class="text-cyan-800 transition-all duration-300 group-hover:text-white"
                                >
                                    Browse events →
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================= -->
        <!-- Featured Events -->
        <!-- ========================= -->
        <section class="pb-16 px-6 max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-cyan-700">
                Featured Events
            </h2>
            <hr />

            <div class="grid md:grid-cols-3 gap-8 mt-10">
                <div
                    v-for="event in events"
                    :key="event.title"
                    class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition"
                >
                    <img :src="event.image" class="w-full h-56 object-cover" />

                    <div class="p-5">
                        <h3 class="text-xl font-semibold">{{ event.title }}</h3>
                        <p class="text-gray-500 mt-2">{{ event.location }}</p>
                        <p class="text-gray-700 font-medium mt-3">
                            {{ event.date }}
                        </p>

                        <button
                            class="mt-4 w-full bg-cyan-600 text-white py-2 rounded-lg hover:bg-cyan-700 transition"
                        >
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative py-24 bg-gray-950 overflow-hidden">
            <!-- Background glow blobs -->
            <div
                class="absolute -top-32 -left-32 w-[28rem] h-[28rem] bg-cyan-500/30 rounded-full blur-3xl"
            ></div>
            <div
                class="absolute top-40 -right-40 w-[28rem] h-[28rem] bg-teal-500/30 rounded-full blur-3xl"
            ></div>

            <div class="relative max-w-7xl mx-auto px-6">
                <!-- Section Title -->
                <div class="text-center mb-20">
                    <h2
                        class="text-5xl font-extrabold bg-gradient-to-r from-cyan-400 to-teal-500 bg-clip-text text-transparent"
                    >
                        Book Your Event in 3 Simple Steps
                    </h2>
                    <p class="text-gray-400 mt-4 text-lg max-w-xl mx-auto">
                        A smooth and effortless booking journey crafted with a
                        premium experience.
                    </p>
                </div>

                <!-- Stepper Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-14 pt-10">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.title"
                        class="relative flex flex-col items-center text-center group"
                    >
                        <!-- Connector Arrow -->
                        <div
                            v-if="index !== steps.length - 1"
                            class="hidden md:block absolute right-[-60px] top-1/2 transform -translate-y-1/2"
                        >
                            <svg
                                class="w-10 h-10 text-cyan-400 opacity-80 animate-bounce-x"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 12h16m-6 6l6-6-6-6"
                                />
                            </svg>
                        </div>

                        <!-- Neon Icon Box -->
                        <div class="relative mb-8">
                            <!-- Glow Ring -->
                            <div
                                class="absolute inset-0 rounded-full bg-gradient-to-br from-cyan-600 to-teal-600 blur-xl opacity-40 group-hover:opacity-70 transition-all duration-500"
                            ></div>

                            <!-- Icon Circle -->
                            <div
                                class="relative w-24 h-24 rounded-full bg-white/5 backdrop-blur-lg border border-white/10 flex items-center justify-center shadow-lg shadow-cyan-500/30 transition-all duration-300 group-hover:scale-105 group-hover:shadow-cyan-600/40"
                            >
                                <Icon
                                    :name="step.icon"
                                    class="w-12 h-12 text-cyan-400"
                                />
                                <!-- <Icon :is="step.icon" class="w-12 h-12 text-cyan-400" /> -->
                            </div>
                        </div>

                        <!-- Step label -->
                        <span
                            class="text-sm font-semibold text-cyan-400 tracking-widest mb-2"
                        >
                            STEP {{ index + 1 }}
                        </span>

                        <!-- Title -->
                        <h3 class="text-2xl font-bold text-white mb-3">
                            {{ step.title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-400 max-w-xs leading-relaxed">
                            {{ step.description }}
                        </p>
                    </div>
                </div>

                <div class="mt-32 text-center">
                    <button
                        class="relative px-12 py-4 bg-gradient-to-r from-cyan-400 via-teal-400 to-cyan-500 text-white font-bold text-lg rounded-full shadow-xl overflow-hidden transform transition-all duration-500 hover:scale-105 hover:rotate-1"
                    >
                        <!-- Glow ring behind button -->
                        <span
                            class="absolute inset-0 rounded-full bg-gradient-to-r from-cyan-500 via-teal-500 to-cyan-600 blur-2xl opacity-50 animate-pulse"
                        ></span>

                        <!-- Button text on top -->
                        <span class="relative z-10">Book Now</span>
                    </button>
                </div>
            </div>
        </section>
    </CustomerLayout>
</template>

<style>
/* Horizontal Arrow Animation */
@keyframes bounce-x {
    0%,
    100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(8px);
    }
}
.animate-bounce-x {
    animation: bounce-x 1.2s infinite ease-in-out;
}
</style>
