<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import { Head } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import { ref } from "vue";

const category = ref("Concerts");
const subCategories = ref(["VIP", "Regular", "Balcony", "Workshop"]);
const topCities = ref([
    {
        name: "Mumbai",
        img: "https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c1?auto=format&w=400&q=80",
    },
    {
        name: "Delhi",
        img: "https://images.unsplash.com/photo-1520975910334-17f0cda5a9b3?auto=format&w=400&q=80",
    },
    {
        name: "Bengaluru",
        img: "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&w=400&q=80",
    },
]);

const cities = [
    {
        name: "Mumbai",
        image: "https://images.unsplash.com/photo-1666843527155-14ec5f016802?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 45,
    },
    {
        name: "Delhi",
        image: "https://images.unsplash.com/photo-1587474260584-136574528ed5?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 32,
    },
    {
        name: "Bengaluru",
        image: "https://images.unsplash.com/photo-1596176530529-78163a4f7af2?q=80&w=1527&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 27,
    },
    {
        name: "Pune",
        image: "https://images.unsplash.com/photo-1760034588108-987757454c18?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 18,
    },
    {
        name: "Jaipur",
        image: "https://images.unsplash.com/photo-1504705759706-c5ee7158f8bb?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 22,
    },
    {
        name: "Indore",
        image: "https://images.unsplash.com/photo-1645517483636-3665aed3acea?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        event_count: 22,
    },
];

const categoryEvents = ref([
    {
        id: 1,
        title: "Rock Concert 2026",
        date: "Dec 20, 2026",
        location: "Mumbai Arena",
        tickets: "VIP, Regular",
        image: "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&w=800&q=80",
    },
    {
        id: 2,
        title: "Jazz Night",
        date: "Jan 12, 2026",
        location: "Delhi Music Hall",
        tickets: "Standard",
        image: "https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf?auto=format&w=800&q=80",
    },
]);

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
</script>

<template>
    <Head title="Home" />

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
                        Discover Exciting {{ category }} Events
                    </h1>

                    <p class="text-lg text-cyan-200 mt-3 mb-4">
                        Explore top {{ category }} events, VIP passes,
                        workshops, and more.
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
                                Categories
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Featucyan Cities -->
        <section class="py-16 px-6 max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-cyan-700">
                Popular Cities
            </h2>
            <hr />
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 py-10"
            >
                <div
                    v-for="city in cities"
                    :key="city.name"
                    class="group relative cursor-pointer overflow-hidden shadow-xl rounded-t-[40px] transition-all duration-300"
                >
                    <!-- Background Image -->
                    <div
                        class="absolute inset-0 bg-cover bg-center transition-all duration-500 group-hover:scale-105"
                        :style="{ backgroundImage: `url(${city.image})` }"
                    ></div>

                    <!-- Dark overlay -->
                    <div
                        class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-all"
                    ></div>

                    <!-- Bottom border animation -->
                    <span
                        class="absolute bottom-0 left-0 w-full h-1 bg-cyan-600 transition-all duration-300 group-hover:h-10"
                    ></span>

                    <!-- City Content -->
                    <div
                        class="relative z-10 p-6 flex flex-col justify-end h-56"
                    >
                        <h3
                            class="text-white text-2xl font-bold drop-shadow-md"
                        >
                            {{ city.name }}
                        </h3>
                        <p class="text-gray-200 text-sm mt-1">
                            {{ city.event_count }} Events Available
                        </p>

                        <!-- CTA -->
                        <button
                            class="mt-4 w-fit px-4 py-2 bg-white/20 backdrop-blur-md text-white font-semibold rounded-full border border-white/30 hover:bg-white/30 transition"
                        >
                            Explore →
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="pb-16 px-6 max-w-7xl mx-auto">
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

        <section class="max-w-7xl mx-auto px-6 pb-14">
            <h2 class="text-3xl font-bold text-cyan-700 mb-6">
                Top Sub-Categories in {{ category }}
            </h2>
            <hr />

            <div
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 mt-10"
            >
                <div
                    v-for="(sub, index) in subCategories"
                    :key="index"
                    class="group p-6 bg-white shadow-xl rounded-2xl border border-gray-100 hover:border-cyan-500 hover:shadow-2xl transition cursor-pointer"
                >
                    <div
                        class="rounded-full w-14 h-14 bg-cyan-100 text-cyan-600 grid place-items-center mx-auto mb-4 text-xl font-bold"
                    >
                        {{ sub[0] }}
                    </div>

                    <h4
                        class="text-center text-gray-700 font-semibold group-hover:text-cyan-600"
                    >
                        {{ sub }}
                    </h4>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-14">
            <div
                className="w-full pt-8 sm:pt-10 pb-8 sm:pb-10 px-4 sm:px-10 md:px-5"
            >
                <div
                    className="grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative"
                >
                    <div>
                        <img
                            src="https://images.unsplash.com/photo-1565035010268-a3816f98589a?q=80&w=688&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            className="w-full h-64 sm:h-80 md:h-[500px] lg:h-[700px] object-cover"
                        />
                    </div>

                    <div
                        className="bg-white px-5 sm:px-8 md:px-12 py-8 sm:py-10 md:py-16 md:-ml-16 lg:-ml-28 relative z-10 shadow-md"
                    >
                        <h2
                            className="text-2xl sm:text-3xl md:text-4xl font-semibold text-cyan-700 mb-3 sm:mb-4"
                        >
                            Why People Love {{ category }} Events?
                        </h2>
                        <hr className="w-20 border-2 text-cyan-600 " />
                        <p class="text-gray-600 leading-relaxed mb-4">
                            {{ category }} events bring unforgettable
                            experiences— from breathtaking performances to
                            exclusive VIP access. Enjoy thrilling moments,
                            premium venues, and once-in-a-lifetime memories.
                        </p>

                        <ul class="space-y-3 text-gray-700">
                            <li class="flex gap-3 items-center">
                                <span
                                    class="h-3 w-3 bg-cyan-500 rounded-full"
                                ></span>
                                Curated events handpicked for quality
                            </li>
                            <li class="flex gap-3 items-center">
                                <span
                                    class="h-3 w-3 bg-cyan-500 rounded-full"
                                ></span>
                                Multiple ticket categories for every budget
                            </li>
                            <li class="flex gap-3 items-center">
                                <span
                                    class="h-3 w-3 bg-cyan-500 rounded-full"
                                ></span>
                                Premium venues & seamless experience
                            </li>
                            <li class="flex gap-3 items-center">
                                <span
                                    class="h-3 w-3 bg-cyan-500 rounded-full"
                                ></span>
                                Early-bird offers & member benefits
                            </li>
                        </ul>

                        <button
                            class="mt-6 px-7 py-3 bg-cyan-600 text-white font-bold rounded-full shadow-lg hover:shadow-2xl hover:scale-105 transition"
                        >
                            Book Your Experience →
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 mt-4">
            <h2 class="text-3xl font-bold mb-6 text-cyan-700">
                Explore More in {{ category }}
            </h2>
            <hr />
            <!-- Fun Facts / Stats -->
            <div
                class="max-w-6xl mx-auto px-6 py-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center"
            >
                <div
                    class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                >
                    <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                        {{ Math.floor(Math.random() * 100) + 50 }}+
                    </h3>
                    <p class="text-gray-400">Events Hosted</p>
                </div>
                <div
                    class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                >
                    <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                        {{ Math.floor(Math.random() * 5000) + 1000 }}+
                    </h3>
                    <p class="text-gray-400">Tickets Sold</p>
                </div>
                <div
                    class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                >
                    <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                        {{ Math.floor(Math.random() * 20) + 10 }} Cities
                    </h3>
                    <p class="text-gray-400">Covecyan</p>
                </div>
                <div
                    class="bg-gray-900 p-6 rounded-xl shadow-lg hover:shadow-2xl transition"
                >
                    <h3 class="text-4xl font-extrabold text-cyan-400 mb-2">
                        {{ Math.floor(Math.random() * 1000) + 200 }}+
                    </h3>
                    <p class="text-gray-400">Happy Attendees</p>
                </div>
            </div>
        </section>
    </CustomerLayout>
</template>
