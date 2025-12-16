<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    venues: Object,
});

const venueCreate = () => {
    router.visit("/admin/venues/create");
};

const venueSearch = ref(props.filters?.venueSearch || "");
let timeout = null;
watch(venueSearch, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            "/admin/venues",
            { venueSearch: value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 400);
});

const venueIdBeingDeleted = ref(null);
const showDeleteModal = ref(false);
const showViewDetailModal = ref(false);
const selectedVenue = ref(null);

const confirmVenueDeletion = (id) => {
    venueIdBeingDeleted.value = id;
    showDeleteModal.value = true;
};

const confirmVenueShow = (venue) => {
    selectedVenue.value = venue;
    showViewDetailModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    venueIdBeingDeleted.value = null;
};

const closeViewDetailModal = () => {
    showViewDetailModal.value = false;
    selectedVenue.value = null;
};

const deleteVenue = () => {
    router.delete(route("admin.venues.destroy", venueIdBeingDeleted.value), {
        onSuccess: () => {
            closeDeleteModal();
        },
    });
};

const editVenue = (id) => {
    router.visit(route("admin.venues.edit", id));
};
</script>

<template>
    <Head title="Venues" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Event Venues
                    </h2>
                </div>
                <div>
                    <button
                        type="button"
                        @click="venueCreate()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-cyan-50 text-xs font-normal py-2 px-4 rounded-full"
                    >
                        <Icon name="create" class="h-4 w-4 inline-block" />
                        Add Venue
                    </button>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-full sm:px-6 lg:px-8 py-5">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-5">
                <!-- flash msg start -->
                <div
                    v-if="$page.props.flash?.message"
                    class="mx-auto max-w-7xl"
                >
                    <div
                        class="bg-green-100 border-l-4 mb-4 border-green-500 text-green-700 py-2 px-5"
                        role="alert"
                    >
                        <p class="font-bold">Success</p>
                        <p>{{ $page.props.flash.message }}</p>
                    </div>
                </div>
                <!-- flash msg end -->
                <div class="my-2 md:flex md:items-end md:justify-end">
                    <div class="relative flex items-center mt-4 md:mt-0">
                        <span class="absolute">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 mx-3 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                />
                            </svg>
                        </span>

                        <input
                            type="text"
                            placeholder="Search"
                            class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            v-model="venueSearch"
                        />
                    </div>
                </div>

                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden border border-gray-200 md:rounded-lg"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-200"
                                >
                                    <thead class="bg-cyan-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                <button
                                                    class="flex items-center gap-x-3 focus:outline-none"
                                                >
                                                    <span>Venue Name</span>
                                                </button>
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                City
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                State
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Country
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Capacity
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Address
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Status
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative py-3.5 px-4"
                                            ></th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200"
                                    >
                                        <tr
                                            v-for="venue in venues.data"
                                            :key="venue.id"
                                        >
                                            <td
                                                class="px-4 py-4 text-sm font-medium whitespace-nowrap"
                                            >
                                                <div
                                                    class="flex items-center space-x-3"
                                                >
                                                    <img
                                                        :src="
                                                            venue.venue_image
                                                                ? `/storage/${venue.venue_image}`
                                                                : '/images/default-avatar.png'
                                                        "
                                                        alt="User Photo"
                                                        class="w-12 h-12 rounded-full border border-cyan-800 object-cover"
                                                    />
                                                    <div>
                                                        <h2
                                                            class="font-semibold text-gray-800"
                                                        >
                                                            {{ venue.name }}
                                                        </h2>
                                                        <p
                                                            class="font-medium text-xs text-gray-500"
                                                        >
                                                            {{ venue.slug }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{ venue.city }}
                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{ venue.state }}
                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{ venue.country }}
                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{ venue.capacity }}
                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{
                                                        venue.address
                                                            ?.split(" ")
                                                            .slice(0, 2)
                                                            .join(" ")
                                                    }}...
                                                </p>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-xs whitespace-nowrap"
                                            >
                                                <div>
                                                    <span
                                                        class="capitalize px-1.5 py-1 rounded text-xs mr-1"
                                                        :class="{
                                                            'bg-green-700 text-white':
                                                                venue.is_active ===
                                                                '1',
                                                            ' bg-red-700 text-white':
                                                                venue.is_active !==
                                                                '1',
                                                        }"
                                                    >
                                                        {{
                                                            venue.is_active ===
                                                            "1"
                                                                ? "Active"
                                                                : "Inactive"
                                                        }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td
                                                class="text-xs whitespace-nowrap"
                                            >
                                                <div
                                                    class="flex items-center gap-1"
                                                >
                                                    <button
                                                        type="button"
                                                        @click="
                                                            editVenue(venue.id)
                                                        "
                                                        class="inline-flex items-center gap-1 bg-blue-700 hover:bg-blue-500 text-blue-50 font-normal text-xs py-1 px-2 rounded-full"
                                                    >
                                                        <Icon
                                                            name="edit"
                                                            class="h-3 w-3"
                                                        />
                                                        <span>Edit</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        @click="
                                                            confirmVenueShow(
                                                                venue
                                                            )
                                                        "
                                                        class="inline-flex items-center gap-1 bg-blue-700 hover:bg-blue-500 text-blue-50 font-normal text-xs py-1 px-2 rounded-full"
                                                    >
                                                        <Icon
                                                            name="eye"
                                                            class="h-3 w-3"
                                                        />
                                                        <span>View</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        @click="
                                                            confirmVenueDeletion(
                                                                venue.id
                                                            )
                                                        "
                                                        class="inline-flex items-center gap-1 bg-red-700 hover:bg-red-500 text-red-50 font-normal text-xs py-1 px-2 rounded-full"
                                                    >
                                                        <Icon
                                                            name="delete"
                                                            class="h-3 w-3"
                                                        />
                                                        <span>Delete</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- When no data exists -->
                                        <tr v-if="venues.data.length === 0">
                                            <td
                                                colspan="8"
                                                class="text-center py-4 text-gray-500"
                                            >
                                                No record found
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 sm:flex sm:items-center sm:justify-between">
                    <!-- Page Info -->
                    <div class="text-sm text-gray-500">
                        Page
                        <span class="font-medium text-gray-700">
                            {{ venues.current_page }} of
                            {{ venues.last_page }}
                        </span>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center mt-4 gap-x-2 sm:mt-0">
                        <!-- Previous Button -->
                        <button
                            class="flex items-center justify-center px-3 py-2 text-sm bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                            :class="{
                                'text-gray-400 cursor-not-allowed':
                                    !venues.prev_page_url,
                            }"
                            :disabled="!venues.prev_page_url"
                            @click="
                                venues.prev_page_url &&
                                    router.visit(venues.prev_page_url)
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
                            v-for="link in venues.links"
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
                                    !venues.next_page_url,
                            }"
                            :disabled="!venues.next_page_url"
                            @click="
                                venues.next_page_url &&
                                    router.visit(venues.next_page_url)
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
    </AuthenticatedLayout>

    <!-- view venue modal -->
    <div
        v-if="showViewDetailModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
    >
        <div
            class="relative bg-white w-11/12 md:max-w-2xl rounded-3xl shadow-2xl overflow-hidden"
        >
            <div class="relative h-48 md:h-56">
                <img
                    :src="
                        selectedVenue.venue_image
                            ? `/storage/${selectedVenue.venue_image}`
                            : '/images/default-avatar.png'
                    "
                    class="absolute inset-0 w-full h-full object-cover"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"
                ></div>

                <button
                    @click="closeViewDetailModal()"
                    class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 hover:bg-white flex items-center justify-center text-gray-800 shadow"
                >
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6"
                        />
                    </svg>
                </button>

                <div class="absolute bottom-4 left-6 text-white">
                    <h2 class="text-2xl font-bold tracking-wide">
                        {{ selectedVenue.name }}
                    </h2>
                    <p class="text-sm text-white/80">
                        {{ selectedVenue.slug }}
                    </p>
                </div>
            </div>

            <div class="px-6 py-3 space-y-3">
                <div class="flex flex-wrap items-center justify-between">
                    <span
                        class="inline-block px-3 py-1 rounded-full text-xs font-medium"
                        :class="{
                            'bg-green-600 text-white':
                                selectedVenue.is_active === '1',
                            'bg-red-600 text-white':
                                selectedVenue.is_active !== '1',
                        }"
                    >
                        {{
                            selectedVenue.is_active === "1"
                                ? "Active Venue"
                                : "Inactive Venue"
                        }}
                    </span>

                    <div class="flex gap-3">
                        <div
                            class="px-4 py-2 rounded-xl text-center bg-gradient-to-br from-cyan-50 to-white border"
                        >
                            <p class="text-xs text-cyan-600">Capacity</p>
                            <p
                                class="font-normal text-sm text-gray-800 leading-relaxed"
                            >
                                {{ selectedVenue.capacity }}
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-cyan-50 to-white border px-4 py-2 rounded-xl text-center"
                        >
                            <p class="text-xs text-cyan-600">Country</p>
                            <p
                                class="font-normal text-sm text-gray-800 leading-relaxed"
                            >
                                {{ selectedVenue.country }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div
                        class="py-3 rounded-2xl text-center bg-gradient-to-br from-gray-50 to-white border"
                    >
                        <p
                            class="text-xs uppercase tracking-wide text-gray-400"
                        >
                            City
                        </p>
                        <p
                            class="text-md font-normal text-gray-800 leading-relaxed"
                        >
                            {{ selectedVenue.city }}
                        </p>
                    </div>

                    <div
                        class="py-3 rounded-2xl text-center bg-gradient-to-br from-gray-50 to-white border"
                    >
                        <p
                            class="text-xs uppercase tracking-wide text-gray-400"
                        >
                            State
                        </p>
                        <p
                            class="text-md font-normal text-gray-800 leading-relaxed"
                        >
                            {{ selectedVenue.state }}
                        </p>
                    </div>
                </div>

                <div
                    class="p-6 rounded-2xl text-center bg-gradient-to-br from-cyan-50 to-white border"
                >
                    <p
                        class="text-xs uppercase tracking-wide text-cyan-600 mb-2"
                    >
                        Address
                    </p>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ selectedVenue.address }}
                    </p>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
                <button
                    @click="closeViewDetailModal()"
                    class="px-6 py-2 rounded-full text-sm bg-cyan-700 text-white hover:bg-cyan-600 shadow"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
    <!-- view venue modal end -->

    <!-- delete venue modal -->
    <div
        v-if="showDeleteModal"
        class="main-modal fixed w-full h-full inset-0 z-50 flex justify-center items-center"
        style="background: rgba(0, 0, 0, 0.7)"
    >
        <div
            class="border border-teal-500 modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto"
        >
            <div class="modal-content py-4 text-left px-6">
                <!--body-->
                <div class="text-center p-5 flex-auto justify-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-16 h-16 flex items-center text-red-500 mx-auto"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <h2 class="text-xl font-bold py-4">Are you sure?</h2>
                    <p class="text-sm text-gray-500 px-8">
                        Do you really want to delete this venue? This process
                        cannot be undone.
                    </p>
                </div>
                <!--footer-->
                <div class="p-3 mt-2 text-center space-x-4 md:block">
                    <button
                        @click="closeDeleteModal()"
                        class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteVenue()"
                        class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete venue modal end -->
</template>
