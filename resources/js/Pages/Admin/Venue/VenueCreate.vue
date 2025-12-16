<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

const backToBtn = () => {
    router.visit("/admin/venues");
};

const props = defineProps({
    venue: Object,
    errors: Object,
});

const isEdit = !!props.venue;

const form = useForm({
    _method: isEdit ? "PUT" : "POST",
    name: props.venue?.name ?? "",
    status: props.venue?.is_active ?? "",
    city: props.venue?.city ?? "",
    state: props.venue?.state ?? "",
    country: props.venue?.country ?? "",
    capacity: props.venue?.capacity ?? "",
    address: props.venue?.address ?? "",
    venuePhoto: null,
});

function submit() {
    const url = isEdit
        ? route("admin.venues.update", props.venue.id)
        : route("admin.venues.store");

    form.post(url, {
        forceFormData: true,
    });
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Venue' : 'Create Venue'" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        {{ isEdit ? "Edit" : "Create" }} Event Venues
                    </h2>
                </div>
                <div>
                    <button
                        type="button"
                        @click="backToBtn()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-xs text-cyan-50 font-normal py-2 px-4 rounded-full"
                    >
                        <Icon name="backarrow" class="h-4 w-4 inline-block" />
                        Back to Venues
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
                                    Venue Name
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="text"
                                    placeholder="Enter venue name"
                                    v-model="form.name"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.name"
                                >
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Status
                                </label>
                                <select
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    v-model="form.status"
                                >
                                    <option disabled :value="null">
                                        Select Status
                                    </option>
                                    <option :value="1">Active</option>
                                    <option :value="0">Inactive</option>
                                </select>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.status"
                                >
                                    {{ errors.status }}
                                </div>
                            </div>
                        </div>

                        <!-- City, State, Country (Single Row) -->
                        <div class="-mx-3 grid grid-cols-1 md:grid-cols-3 mb-6">
                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    City
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="text"
                                    placeholder="City"
                                    v-model="form.city"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.city"
                                >
                                    {{ errors.city }}
                                </div>
                            </div>

                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    State
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="text"
                                    placeholder="State"
                                    v-model="form.state"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.state"
                                >
                                    {{ errors.state }}
                                </div>
                            </div>

                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Country
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="text"
                                    placeholder="Country"
                                    v-model="form.country"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.country"
                                >
                                    {{ errors.country }}
                                </div>
                            </div>
                        </div>

                        <!-- Capacity -->
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Capacity
                                </label>
                                <input
                                    type="number"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    placeholder="Max capacity"
                                    v-model="form.capacity"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.capacity"
                                >
                                    {{ errors.capacity }}
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Venue Photo
                                </label>
                                <input
                                    class="focus:outline-none w-full py-3 mb-3"
                                    id="grid-first-name"
                                    type="file"
                                    accept="image/*"
                                    @change="
                                        (e) =>
                                            (form.venuePhoto =
                                                e.target.files[0])
                                    "
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.venuePhoto"
                                >
                                    {{ errors.venuePhoto }}
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="-mx-3 mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Address
                                </label>
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    placeholder="Full venue address"
                                    v-model="form.address"
                                ></textarea>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.address"
                                >
                                    {{ errors.address }}
                                </div>
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
                            {{ isEdit ? "Update Venue" : "Save Venue" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
