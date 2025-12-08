<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";

import Icon from "@/Components/Icon.vue";

const backToBtn = () => {
    router.visit("/admin/event-categories");
};

defineProps({
    errors: Object,
});

const form = useForm({
    name: "",
    status: null,
    description: "",
    categoryPhoto: null,
});

function submit() {
    form.post(route("admin.event-categories.store"));
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Event Categories
                    </h2>
                </div>
                <div>
                    <button
                        type="button"
                        @click="backToBtn()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-cyan-50 font-bold py-2 px-4 rounded-full"
                    >
                        <Icon name="backarrow" class="h-4 w-4 inline-block" />
                        Back to Event Category
                    </button>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-full sm:px-6 lg:px-8 py-5">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-5">
                <!-- component -->
                <form @submit.prevent="submit">
                    <div class="px-8 mb-4 flex flex-col my-2">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Name
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    id="grid-first-name"
                                    type="text"
                                    placeholder="Jane"
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
                                    for="grid-first-name"
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

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-description"
                                >
                                    Description
                                </label>

                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    id="grid-description"
                                    placeholder="Say something..."
                                    v-model="form.description"
                                ></textarea>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.description"
                                >
                                    {{ errors.description }}
                                </div>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Category Photo
                                </label>
                                <input
                                    class="focus:outline-none w-full py-3 mb-3"
                                    id="grid-first-name"
                                    type="file"
                                    placeholder="1234567898"
                                    @input="
                                        form.categoryPhoto =
                                            $event.target.files[0]
                                    "
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.categoryPhoto"
                                >
                                    {{ errors.categoryPhoto }}
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex justify-end border-t-2 pt-10 border-gray-200"
                        >
                            <button
                                type="submit"
                                class="hover:shadow-form rounded-md bg-cyan-600 py-3 px-8 text-base font-semibold text-white outline-none"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
