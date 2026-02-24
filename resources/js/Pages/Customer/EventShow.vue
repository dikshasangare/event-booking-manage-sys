<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import { computed, ref } from "vue";

const props = defineProps({
    event: Object,
    seats: Array,
});

const selectedSeats = ref([]);

const quantity = computed(() => selectedSeats.value.length);

const toggleSeat = (seat) => {
    if (seat.status === "booked") return;

    const index = selectedSeats.value.findIndex(s => s.id === seat.id);

    if (index === -1) {
        selectedSeats.value.push(seat);
    } else {
        selectedSeats.value.splice(index, 1);
    }
};

const bookNow = () => {
    router.post(route("booking.store"), {
        event_id: props.event.id,
        seats: selectedSeats.value.map(s => s.id),
    });
};

// Unique rows for seat layout
const seatRows = computed(() => {
    return [...new Set(props.seats.map(s => s.row))];
});

const formattedDateTime = computed(() => {
    if (!props.event.start_datetime) return "";

    const date = new Date(props.event.start_datetime);

    const options = {
        weekday: "short",
        day: "2-digit",
        month: "short",
        year: "numeric",
    };

    const formattedDate = date.toLocaleDateString("en-IN", options);

    const formattedTime = date.toLocaleTimeString("en-IN", {
        hour: "numeric",
        minute: "2-digit",
        hour12: true,
    });

    return `${formattedDate} • ${formattedTime}`;
});
</script>

<template>

    <Head :title="props.event.title" />

    <CustomerLayout>
        <!-- HERO SECTION -->
        <div class="relative">
            <div class="relative bg-gradient-to-b from-cyan-500 to-cyan-800 h-[60vh] sm:h-[65vh] md:h-[70vh] lg:h-[75vh] flex flex-col items-center justify-end text-white px-4 bg-cover bg-center rounded-b-3xl"
                :style="{
                    backgroundImage: `url('https://images.unsplash.com/photo-1694898971137-2f5078bceed7?q=80&w=1632&auto=format&fit=crop')`,
                }">
                <div class="absolute inset-0 bg-black/40 md:bg-black/45 rounded-b-3xl"></div>

                <div class="relative z-10 text-center my-auto px-4">
                    <h1 class="text-3xl md:text-5xl font-extrabold">
                        {{ props.event.title }}
                    </h1>
                    <p class="mt-3 text-white/80">
                        {{ formattedDateTime }} • {{ props.event.location }}
                    </p>
                </div>
            </div>
        </div>

        <!-- META BAR -->
        <div class="bg-white shadow-xl rounded-2xl -mt-12 relative z-20 max-w-6xl mx-auto px-6 py-6 flex flex-wrap items-center justify-between gap-4 border"
            :style="{
                boxShadow:
                    '0px 0px 0px 8px rgba(255, 255, 255, 0.2)',
            }">
            <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <Icon name="calendar" class="w-5 h-5 text-indigo-600" />
                    <span>{{ formattedDateTime }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <Icon name="map-pin" class="w-5 h-5 text-indigo-600" />
                    <span>{{ props.event.location }}</span>
                </div>

                <div class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-xs">
                    {{ props.event.category ?? 'Live Event' }}
                </div>
            </div>

            <span class="text-2xl font-bold text-indigo-600">
                ₹{{ props.event.price }}
            </span>
        </div>

        <!-- MAIN CONTENT -->
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-2 space-y-10">

                <!-- ABOUT -->
                <div class="bg-white shadow-lg rounded-2xl p-6">
                    <h2 class="text-xl font-semibold mb-4">About Event</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ props.event.description }}
                    </p>
                </div>

                <!-- ORGANIZER -->
                <div class="bg-white shadow-lg rounded-2xl p-6 flex items-center gap-6">
                    <div
                        class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600 text-lg">
                        {{ props.event.organizer?.charAt(0) ?? 'E' }}
                    </div>
                    <div>
                        <h3 class="font-semibold">
                            {{ props.event.organizer ?? 'Event Organizer' }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            Professional Event Host
                        </p>
                    </div>
                </div>

                <!-- SEAT LAYOUT -->
                <div class="bg-white shadow-lg rounded-2xl p-6">
                    <h2 class="text-xl font-semibold mb-6">Select Your Seats</h2>

                    <div class="space-y-3">
                        <div v-for="row in seatRows" :key="row" class="flex items-center gap-4">
                            <span class="w-6 text-sm text-gray-500">
                                {{ row }}
                            </span>

                            <div class="flex gap-2 flex-wrap">
                                <div v-for="seat in props.seats.filter(s => s.row === row)" :key="seat.id"
                                    @click="toggleSeat(seat)" :class="[
                                        'w-8 h-8 rounded-md flex items-center justify-center text-xs cursor-pointer transition',
                                        seat.status === 'booked'
                                            ? 'bg-red-500 text-white cursor-not-allowed'
                                            : selectedSeats.find(s => s.id === seat.id)
                                                ? 'bg-green-500 text-white'
                                                : 'bg-gray-200 hover:bg-indigo-500 hover:text-white'
                                    ]">
                                    {{ seat.number }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LEGEND -->
                    <div class="mt-6 flex gap-6 text-sm text-gray-500">
                        <span class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-gray-200 rounded"></div> Available
                        </span>
                        <span class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-500 rounded"></div> Selected
                        </span>
                        <span class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-500 rounded"></div> Booked
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT BOOKING CARD -->
            <div class="sticky top-24 h-fit">
                <div class="bg-white shadow-2xl rounded-2xl p-6">

                    <h2 class="text-2xl font-bold text-indigo-600">
                        ₹{{ props.event.price }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ quantity }} Seats Selected
                    </p>

                    <!-- PRICE SUMMARY -->
                    <div class="border-t pt-4 mt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Ticket Price</span>
                            <span>₹{{ props.event.price }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Quantity</span>
                            <span>{{ quantity }}</span>
                        </div>

                        <div class="flex justify-between font-semibold text-base">
                            <span>Total</span>
                            <span>₹{{ quantity * props.event.price }}</span>
                        </div>
                    </div>

                    <button @click="bookNow" :disabled="quantity === 0"
                        class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white py-3 rounded-xl font-semibold transition">
                        Continue to Payment
                    </button>

                </div>
            </div>
        </div>

        <!-- MOBILE BOOK BAR -->
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg p-4 flex justify-between items-center lg:hidden">
            <div>
                <p class="text-sm text-gray-500">{{ quantity }} Seats</p>
                <p class="font-semibold">
                    ₹{{ quantity * props.event.price }}
                </p>
            </div>

            <button @click="bookNow" class="bg-indigo-600 text-white px-6 py-2 rounded-xl">
                Book Now
            </button>
        </div>

    </CustomerLayout>
</template>