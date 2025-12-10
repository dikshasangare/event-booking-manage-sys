<script setup>
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

const cities = ref([
    { name: "Mumbai", events: 32 },
    { name: "Delhi", events: 25 },
    { name: "Bengaluru", events: 18 },
    { name: "Chennai", events: 12 },
    { name: "Kolkata", events: 20 },
]);

const testimonials = ref([
    {
        id: 1,
        name: "Rahul Sharma",
        feedback: "Best event booking platform ever! Smooth and quick.",
    },
    {
        id: 2,
        name: "Ananya Gupta",
        feedback: "Loved the VIP seating selection. Highly recommend!",
    },
]);
</script>

<template>
    <Head title="Home" />

    <CustomerLayout>
        <!-- Hero Section -->
        <div class="relative">
            <div
                class="relative bg-gradient-to-b from-red-500 to-red-800 h-[60vh] sm:h-[65vh] md:h-[70vh] lg:h-[75vh] flex flex-col items-center justify-end text-white px-4 bg-cover bg-center rounded-b-3xl"
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
                        Discover & Book Exciting Events
                    </h1>

                    <p class="text-lg text-cyan-200 mt-3 mb-4">
                        Concerts, Conferences, Workshops, and more — all in one
                        place.
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
                                class="flex items-center hover:text-cyan-400 transition"
                            >
                                <a class="opacity-80" href="#">
                                    <Icon
                                        name="home"
                                        :class="'h-4 w-4 sm:h-5 sm:w-5 md:h-6 md:w-6'"
                                    />
                                </a>
                            </li>

                            <span class="text-gray-300 mx-1">/</span>
                            <li
                                class="opacity-80 hover:text-cyan-400 transition"
                            >
                                <a href="/">Home</a>
                            </li>
                            <span class="text-gray-300 mx-1">/</span>
                            <li
                                class="font-semibold hover:text-cyan-400 transition"
                            >
                                Events Listing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="py-16 px-6 max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-cyan-700">
                Upcoming Events
            </h2>
            <hr />

            <div class="grid md:grid-cols-3 gap-8 mt-10">
                <div
                    v-for="event in events"
                    :key="event.title"
                    class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition"
                >
                    <img :src="event.image" class="w-full h-56 object-cover" />

                    <div>
                        <div class="px-5">
                            <h3 class="text-xl font-semibold pt-5">
                                {{ event.title }}
                            </h3>

                            <p
                                class="text-gray-700 text-sm font-medium mt-3 inline-flex"
                            >
                                <Icon
                                    name="calendar"
                                    class="w-4 h-4 my-auto mr-2"
                                />
                                {{ event.date }}
                            </p>
                        </div>

                        <div class="border-b pb-4 px-5 mt-5">
                            <button
                                class="w-full py-3 bg-gradient-to-r from-cyan-400 to-teal-500 text-white font-bold rounded-full shadow-lg hover:scale-105 transition-all"
                            >
                                Book Now
                            </button>
                        </div>

                        <div class="border-cyan-700 p-5 flex justify-between">
                            <p class="text-gray-500 mt-2">
                                {{ event.location }}
                            </p>
                            <p class="text-gray-500 mt-2">
                                {{ event.location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-950 text-white">
            <!-- Popular Cities Section -->
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-3xl font-bold mb-6 text-white">
                    Popular Cities
                </h2>
                <hr />
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mt-10">
                    <div
                        v-for="city in cities"
                        :key="city.name"
                        class="bg-gray-900 p-6 rounded-xl text-center shadow-lg hover:shadow-2xl transition"
                    >
                        <h3 class="text-xl font-bold mb-2">{{ city.name }}</h3>
                        <p class="text-cyan-400 font-semibold">
                            {{ city.events }} Events
                        </p>
                    </div>
                </div>
            </div>

            <!-- Event Statistics / Fun Facts -->
            <div class="max-w-6xl mx-auto px-6 py-16">
                <h2 class="text-3xl font-bold mb-6 text-white">Fun Facts</h2>
                <hr />
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center mt-10">
                    <div
                        class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                    >
                        <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                            120+
                        </h3>
                        <p class="text-gray-400">Events Hosted</p>
                    </div>
                    <div
                        class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                    >
                        <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                            50k+
                        </h3>
                        <p class="text-gray-400">Tickets Sold</p>
                    </div>
                    <div
                        class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                    >
                        <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                            30+
                        </h3>
                        <p class="text-gray-400">Cities Covered</p>
                    </div>
                    <div
                        class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                    >
                        <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                            500+
                        </h3>
                        <p class="text-gray-400">Happy Customers</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call-to-Action Banner -->
        <div
            class="relative bg-gradient-to-r from-cyan-500 to-teal-500 py-20 my-10 rounded-3xl mx-6 text-center shadow-lg"
        >
            <h2 class="text-4xl font-extrabold text-white mb-4">
                Ready to Book Your Next Event?
            </h2>
            <p class="text-white/80 mb-6">
                Browse our events and secure your spot in just a few clicks.
            </p>
            <button
                class="px-10 py-4 bg-white text-cyan-500 font-bold rounded-full shadow-xl hover:scale-105 transition"
            >
                Browse Events
            </button>
        </div>
    </CustomerLayout>
</template>
