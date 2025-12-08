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

        <!-- ========================= -->
        <!-- Footer -->
        <!-- ========================= -->
        <footer class="bg-gray-900 text-gray-300 py-10 mt-20">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">
                <div>
                    <h4 class="text-xl font-bold text-white mb-3">Eventify</h4>
                    <p>
                        Your trusted platform to find and book the best events.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-3">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Events</a></li>
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li>
                            <a href="#" class="hover:text-white">Contact</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-3">Support</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="hover:text-white">Help Center</a>
                        </li>
                        <li><a href="#" class="hover:text-white">FAQs</a></li>
                        <li>
                            <a href="#" class="hover:text-white"
                                >Terms & Policies</a
                            >
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-3">Newsletter</h4>
                    <input
                        type="email"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 text-gray-200 border border-gray-700 focus:ring-2 focus:ring-cyan-500"
                    />
                    <button
                        class="w-full mt-3 bg-cyan-600 text-white py-2 rounded-lg hover:bg-cyan-700 transition"
                    >
                        Subscribe
                    </button>
                </div>
            </div>
            <p class="text-center mt-10 text-gray-500 text-sm">
                © 2025 Eventify. All Rights Reserved.
            </p>
        </footer>
    </CustomerLayout>
</template>
