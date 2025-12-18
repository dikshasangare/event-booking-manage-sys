<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";
import ArtistSelector from "@/Components/Admin/ArtistSelector.vue";

const backToBtn = () => {
    router.visit("/admin/events");
};

const props = defineProps({
    event: Object,
    errors: Object,
    venues: Array,
    categories: Array,
    artists: Array,
});

const isEdit = !!props.event;

const form = useForm({
    _method: isEdit ? "PUT" : "POST",
    venue_id: props.event?.venue_id ?? "",
    category_id: props.event?.category_id ?? "",
    title: props.event?.title ?? "",
    short_description: props.event?.short_description ?? "",
    about_event: props.event?.about_event ?? "",
    event_type: props.event?.event_type ?? "other",
    age_limit: props.event?.age_limit ?? "",
    language: props.event?.language ?? "",
    start_datetime: props.event?.start_datetime ?? "",
    end_datetime: props.event?.end_datetime ?? "",
    is_featured: props.event?.is_featured ?? false,
    is_private: props.event?.is_private ?? false,
    banner_image: null,
    artists: [], // [{id, event_role}]
});

function submit() {
    const url = isEdit
        ? route("admin.events.update", props.event.id)
        : route("admin.events.store");

    form.post(url, {
        forceFormData: true,
    });
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Event' : 'Create Event'" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        {{ isEdit ? "Edit" : "Create" }} Event
                    </h2>
                </div>
                <div>
                    <button
                        type="button"
                        @click="backToBtn()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-xs text-cyan-50 font-normal py-2 px-4 rounded-full"
                    >
                        <Icon name="backarrow" class="h-4 w-4 inline-block" />
                        Back to Events
                    </button>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-full sm:px-6 lg:px-8 py-5">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <!-- component -->
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="px-8 py-5 mb-4 my-2">
                        <!-- Venue Name & Status -->
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Event Title
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="text"
                                    placeholder="Enter event title"
                                    v-model="form.title"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.title"
                                >
                                    {{ errors.title }}
                                </div>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Venue
                                </label>
                                <select
                                    v-model="form.venue_id"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                >
                                    <option value="">Select Venue</option>
                                    <option
                                        v-for="v in venues"
                                        :key="v.id"
                                        :value="v.id"
                                    >
                                        {{ v.name }}
                                    </option>
                                </select>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.venue_id"
                                >
                                    {{ errors.venue_id }}
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Category
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                >
                                    <option value="">Select Category</option>
                                    <option
                                        v-for="c in categories"
                                        :key="c.id"
                                        :value="c.id"
                                    >
                                        {{ c.name }}
                                    </option>
                                </select>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.category_id"
                                >
                                    {{ errors.category_id }}
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Event Type
                                </label>
                                <select
                                    v-model="form.event_type"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                >
                                    <option value="">Select Venue</option>
                                    <option value="classical">Classical</option>
                                    <option value="fusion">Fusion</option>
                                    <option value="rock">Rock</option>
                                    <option value="comedy">Comedy</option>
                                    <option value="conference">
                                        Conference
                                    </option>
                                    <option value="workshop">Workshop</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="other">Other</option>
                                </select>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.event_type"
                                >
                                    {{ errors.event_type }}
                                </div>
                            </div>
                        </div>
                        <!-- City, State, Country (Single Row) -->
                        <div class="-mx-3 grid grid-cols-1 md:grid-cols-2 mb-6">
                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Start Date & Time
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="datetime-local"
                                    placeholder="Start Date & Time"
                                    v-model="form.start_datetime"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.start_datetime"
                                >
                                    {{ errors.start_datetime }}
                                </div>
                            </div>

                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    End Date & Time
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="datetime-local"
                                    placeholder="End Date & Time"
                                    v-model="form.end_datetime"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.end_datetime"
                                >
                                    {{ errors.end_datetime }}
                                </div>
                            </div>
                        </div>

                        <!-- Capacity -->
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Age Limit
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="number"
                                    placeholder="Age Limit"
                                    v-model="form.age_limit"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.age_limit"
                                >
                                    {{ errors.age_limit }}
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Language
                                </label>
                                <input
                                    type="text"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    placeholder="Language"
                                    v-model="form.language"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.language"
                                >
                                    {{ errors.language }}
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="-mx-3 flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Short Description
                                </label>
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    placeholder="Short Description"
                                    v-model="form.short_description"
                                ></textarea>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.short_description"
                                >
                                    {{ errors.short_description }}
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    About Event
                                </label>
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    placeholder="About Event"
                                    v-model="form.about_event"
                                ></textarea>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.about_event"
                                >
                                    {{ errors.about_event }}
                                </div>
                            </div>
                        </div>

                        <div class="flex -mx-3">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Is this event Featured / Private?
                                </label>
                                <div class="flex gap-5 py-3 mb-3">
                                    <label class="flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            v-model="form.is_featured"
                                        />
                                        Featured
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input
                                            type="checkbox"
                                            v-model="form.is_private"
                                        />
                                        Private
                                    </label>
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Banner Image
                                </label>
                                <input
                                    class="focus:outline-none w-full py-3 mb-3"
                                    id="grid-first-name"
                                    type="file"
                                    accept="image/*"
                                    @change="
                                        (e) =>
                                            (form.banner_image =
                                                e.target.files[0])
                                    "
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.banner_image"
                                >
                                    {{ errors.banner_image }}
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 mb-6 px-3">
                            <label
                                class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                            >
                                Artists
                            </label>
                            <div class="mb-6 md:mb-0">
                                <ArtistSelector v-model="form.artists" />
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div
                        class="flex justify-end border-t-2 py-10 px-8 border-gray-200"
                    >
                        <button
                            type="submit"
                            class="hover:shadow-form rounded-md bg-cyan-600 py-3 px-8 text-base font-semibold text-white outline-none"
                        >
                            {{ isEdit ? "Update Event" : "Save Event" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
