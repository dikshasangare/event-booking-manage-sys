<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    events: Object,
});

const eventCreate = () => {
    router.visit("/admin/events/create");
};

const eventSearch = ref(props.filters?.eventSearch || "");
let timeout = null;
watch(eventSearch, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            "/admin/events",
            { eventSearch: value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 400);
});

const categoryIdBeingDeleted = ref(null);
const showDeleteModal = ref(false);

const showViewDetailModal = ref(false);
const selectedCategory = ref(null);

const confirmCategoryDelete = (id) => {
    categoryIdBeingDeleted.value = id;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    categoryIdBeingDeleted.value = null;
};

const confirmCategoryShow = (category) => {
    selectedCategory.value = category;
    showViewDetailModal.value = true;
};

const closeViewDetailModal = () => {
    showViewDetailModal.value = false;
    selectedCategory.value = null;
};

const deleteCategory = () => {
    router.delete(route("admin.events.destroy", categoryIdBeingDeleted.value), {
        onSuccess: () => {
            closeDeleteModal();
        },
    });
};

const editEvent = (id) => {
    router.visit(route("admin.events.edit", id));
};

const addTicketType = (id) => {
    // router.visit(route("admin.ticket-types.index", id));
    router.visit(route("admin.events.ticket-types.index", id));
};
</script>

<template>
    <Head title="Events" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl inline-flex font-semibold leading-tight text-gray-800"
                    >
                        <Icon name="calendar" class="my-auto h-6 w-6 mx-3" />
                        Events
                    </h2>
                </div>
                <div>
                    <button
                        type="button"
                        @click="eventCreate()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-cyan-50 font-normal text-xs py-2 px-4 rounded-full"
                    >
                        <Icon name="create" class="h-4 w-4 inline-block" />
                        Add Event
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
                            v-model="eventSearch"
                        />
                    </div>
                </div>

                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block align-middle">
                            <div class="overflow-hidden">
                                <div
                                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-12 p-8"
                                >
                                    <div
                                        v-for="event in events.data"
                                        :key="event.id"
                                        class="relative group border border-cyan-200 rounded-[32px] overflow-hidden"
                                    >
                                        <!-- Background Glow -->
                                        <!-- bg-gradient-to-br from-cyan-500/40 via-cyan-500/20 to-fuchsia-500/40 blur-xl -->
                                        <!-- <div
                                            class="absolute -inset-1 rounded-[32px] opacity-0 group-hover:opacity-100 transition duration-700"
                                        ></div> -->

                                        <div
                                            class="absolute inset-0 rounded-b-3xl bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15"
                                        ></div>

                                        <!-- Card -->
                                        <div
                                            class="relative rounded-[32px] overflow-hidden bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15"
                                        >
                                            <!-- Image -->
                                            <div
                                                class="relative h-64 overflow-hidden rounded-b-3xl"
                                            >
                                                <img
                                                    :src="
                                                        event.banner_image
                                                            ? `/storage/${event.banner_image}`
                                                            : 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4'
                                                    "
                                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-[1200ms]"
                                                    :class="{
                                                        'scale-110 group-hover:scale-125':
                                                            event.status !==
                                                            'cancelled',
                                                        'grayscale blur-[1px] scale-105 opacity-70':
                                                            event.status ===
                                                            'cancelled',
                                                    }"
                                                />

                                                <!-- Overlay -->
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent rounded-b-3xl"
                                                ></div>
                                                <!-- Status Vertical -->
                                                <div
                                                    class="absolute left-6 top-6 bottom-6 w-[3px] rounded-full"
                                                    :class="{
                                                        'bg-yellow-400':
                                                            event.status ===
                                                            'draft',
                                                        'bg-emerald-400':
                                                            event.status ===
                                                            'published',
                                                        'bg-rose-400':
                                                            event.status ===
                                                            'cancelled',
                                                        'bg-slate-400':
                                                            event.status ===
                                                            'completed',
                                                    }"
                                                ></div>
                                                <!-- Title -->
                                                <div
                                                    class="absolute bottom-6 left-10 right-6 text-white"
                                                >
                                                    <p
                                                        class="text-xs uppercase tracking-[0.25em]"
                                                    >
                                                        {{ event.event_type }}
                                                    </p>
                                                    <h2
                                                        class="text-3xl font-black leading-tight tracking-tight line-clamp-2"
                                                    >
                                                        {{ event.title }}
                                                    </h2>
                                                </div>

                                                <div
                                                    v-if="
                                                        event.status ===
                                                        'cancelled'
                                                    "
                                                    class="absolute top-6 right-6 z-20 flex items-center gap-2 bg-rose-600/90 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest"
                                                >
                                                    CANCELLED
                                                </div>
                                                <div v-else>
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

                                            <!-- Floating Info Panel -->
                                            <div
                                                class="-mt-14 mx-6 bg-white/90 backdrop-blur-xl rounded-3xl shadow-xl p-6 space-y-4"
                                            >
                                                <p
                                                    class="text-sm text-gray-700 leading-relaxed line-clamp-1"
                                                >
                                                    {{
                                                        event.short_description
                                                    }}
                                                </p>

                                                <!-- Meta -->
                                                <div
                                                    class="grid grid-cols-2 gap-y-3 text-[11px] font-semibold text-gray-600 tracking-wide"
                                                >
                                                    <div>
                                                        📅
                                                        {{
                                                            new Date(
                                                                event.start_datetime
                                                            ).toLocaleDateString(
                                                                undefined,
                                                                {
                                                                    weekday:
                                                                        "short",
                                                                    month: "short",
                                                                    day: "numeric",
                                                                }
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
                                                                ? event.age_limit +
                                                                  "+"
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

                                            <!-- Footer Actions -->
                                            <div
                                                class="relative px-3 py-6 mt-6"
                                            >
                                                <!-- Cyan Glow Background -->
                                                <div
                                                    class="absolute inset-0 rounded-b-3xl bg-gradient-to-r from-cyan-500/15 via-cyan-400/5 to-cyan-500/15"
                                                ></div>

                                                <div
                                                    class="relative flex items-center justify-between gap-x-1"
                                                >
                                                    <!-- Primary CTA -->
                                                    <button
                                                        v-if="
                                                            ![
                                                                'cancelled',
                                                                'published',
                                                            ].includes(
                                                                event.status
                                                            )
                                                        "
                                                        @click="
                                                            addTicketType(
                                                                event.id
                                                            )
                                                        "
                                                        class="group inline-flex items-center gap-0 px-3 py-2.5 rounded-full bg-gradient-to-r from-cyan-600 to-cyan-500 text-white text-xs font-bold tracking-wide shadow-lg shadow-cyan-500/30 hover:from-cyan-500 hover:to-cyan-400 hover:scale-[1.03] transition-all duration-300"
                                                    >
                                                        Ticket Type
                                                        <Icon
                                                            name="create"
                                                            class="h-4 w-4 mx-1 my-auto"
                                                        />
                                                    </button>

                                                    <span
                                                        v-else-if="
                                                            event.status ===
                                                            'cancelled'
                                                        "
                                                        class="text-sm font-bold text-red-700 cursor-not-allowed"
                                                    >
                                                        Event Cancelled
                                                    </span>

                                                    <span
                                                        v-else-if="
                                                            event.status ===
                                                            'published'
                                                        "
                                                        class="text-sm font-bold text-green-700 cursor-not-allowed"
                                                    >
                                                        Event Published
                                                    </span>

                                                    <!-- Action Icons -->
                                                    <div
                                                        class="flex items-center gap-3"
                                                    >
                                                        <button
                                                            @click="
                                                                confirmCategoryShow(
                                                                    event
                                                                )
                                                            "
                                                            class="group w-10 h-10 flex items-center justify-center rounded-full bg-cyan-50 text-cyan-700 shadow hover:shadow-md hover:bg-cyan-600 hover:text-white transition font-extrabold"
                                                            title="View Event"
                                                        >
                                                            <Icon
                                                                name="eye"
                                                                class="h-4 w-4"
                                                            />
                                                        </button>

                                                        <button
                                                            v-if="
                                                                ![
                                                                    'cancelled',
                                                                    'published',
                                                                ].includes(
                                                                    event.status
                                                                )
                                                            "
                                                            @click="
                                                                editEvent(
                                                                    event.id
                                                                )
                                                            "
                                                            class="group w-10 h-10 flex items-center justify-center rounded-full bg-cyan-50 text-cyan-700 shadow hover:shadow-md hover:bg-cyan-500 hover:text-white transition"
                                                            title="Edit Event"
                                                        >
                                                            ✎
                                                        </button>

                                                        <button
                                                            @click="
                                                                confirmCategoryDelete(
                                                                    event.id
                                                                )
                                                            "
                                                            class="group w-10 h-10 flex items-center justify-center rounded-full bg-cyan-50 text-rose-600 shadow hover:shadow-md hover:bg-rose-600 hover:text-white transition"
                                                            title="Delete Event"
                                                        >
                                                            <Icon
                                                                name="delete"
                                                                class="h-4 w-4"
                                                            />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 sm:flex sm:items-center sm:justify-between">
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
    </AuthenticatedLayout>

    <!-- view category modal -->
    <div
        v-if="showViewDetailModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
    >
        <div
            class="relative bg-white w-11/12 md:max-w-2xl rounded-3xl shadow-2xl overflow-hidden"
        >
            <div class="relative h-48 md:h-64">
                <img
                    :src="
                        selectedCategory.event_logo
                            ? `/storage/${selectedCategory.event_logo}`
                            : '/images/default-avatar.png'
                    "
                    class="absolute inset-0 w-full h-full"
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
                        {{ selectedCategory.name }}
                    </h2>
                </div>
            </div>

            <div class="px-6 py-3 space-y-5">
                <div class="flex flex-wrap items-center justify-between">
                    <span
                        class="inline-block px-3 py-1 rounded-full text-xs font-medium"
                        :class="{
                            'bg-green-600 text-white':
                                selectedCategory.status === '1',
                            'bg-red-600 text-white':
                                selectedCategory.status !== '1',
                        }"
                    >
                        {{
                            selectedCategory.status === "1"
                                ? "Active Category"
                                : "Inactive Category"
                        }}
                    </span>
                </div>

                <div
                    class="p-6 rounded-2xl text-center bg-gradient-to-br from-cyan-50 to-white border"
                >
                    <p
                        class="text-xs uppercase tracking-wide text-cyan-600 mb-2"
                    >
                        Category Description
                    </p>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ selectedCategory.short_description }}
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

    <!-- delete category modal -->
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
                        Do you really want to delete this event? This process
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
                        @click="deleteCategory()"
                        class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete category modal end -->
</template>
