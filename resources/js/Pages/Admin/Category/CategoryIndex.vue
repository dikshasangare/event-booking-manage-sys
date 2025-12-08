<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    categories: Object,
});

const categoryCreate = () => {
    router.visit("/admin/event-categories/create");
};

const userSearch = ref(props.filters?.userSearch || "");
let timeout = null;
watch(userSearch, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            "/admin/users",
            { userSearch: value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 400);
});
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
                        @click="categoryCreate()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-cyan-50 font-bold py-2 px-4 rounded-full"
                    >
                        <Icon name="create" class="h-4 w-4 inline-block" />
                        Add Category
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
                            v-model="userSearch"
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
                                                    <span>Category Name</span>
                                                </button>
                                            </th>

                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Status
                                            </th>

                                            <th
                                                scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500"
                                            >
                                                Description
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
                                            v-for="category in categories.data"
                                            :key="category.id"
                                        >
                                            <td
                                                class="px-4 py-4 text-sm font-medium whitespace-nowrap"
                                            >
                                                <div
                                                    class="flex items-center space-x-3"
                                                >
                                                    <img
                                                        :src="
                                                            category.event_logo
                                                                ? `/storage/${category.event_logo}`
                                                                : '/images/default-avatar.png'
                                                        "
                                                        alt="User Photo"
                                                        class="w-12 h-12 rounded-full border border-cyan-800 object-cover"
                                                    />
                                                    <div>
                                                        <h2
                                                            class="font-medium text-gray-800"
                                                        >
                                                            {{ category.name }}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </td>

                                            <td
                                                class="px-4 py-4 text-sm whitespace-nowrap"
                                            >
                                                <div>
                                                    <span
                                                        class="capitalize px-2 py-1 rounded text-sm mr-1"
                                                        :class="{
                                                            'bg-green-700 text-white':
                                                                category.status ===
                                                                '1',
                                                            ' bg-red-700 text-white':
                                                                category.status !==
                                                                '1',
                                                        }"
                                                    >
                                                        {{
                                                            category.status ===
                                                            "1"
                                                                ? "Active"
                                                                : "Inactive"
                                                        }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td
                                                class="px-4 py-4 text-sm whitespace-nowrap"
                                            >
                                                <p class="text-gray-500">
                                                    {{
                                                        category.short_description
                                                    }}
                                                </p>
                                            </td>

                                            <td
                                                class="px-4 py-4 text-sm whitespace-nowrap"
                                            >
                                                <Dropdown>
                                                    <template #trigger>
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg hover:bg-gray-100"
                                                        >
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-6 h-6"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </template>

                                                    <template #content>
                                                        <!-- :href="
                                                                route(
                                                                    'admin.user.edit',
                                                                    {
                                                                        id: category.id,
                                                                    }
                                                                )
                                                            " -->
                                                        <DropdownLink
                                                            >Edit
                                                            Detail</DropdownLink
                                                        >
                                                        <DropdownLink
                                                            :href="
                                                                route('logout')
                                                            "
                                                            method="post"
                                                            as="button"
                                                        >
                                                            View Detail
                                                        </DropdownLink>
                                                    </template>
                                                </Dropdown>
                                            </td>
                                        </tr>
                                        <!-- When no data exists -->
                                        <tr v-if="categories.data.length === 0">
                                            <td
                                                colspan="4"
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
                            {{ categories.current_page }} of
                            {{ categories.last_page }}
                        </span>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center mt-4 gap-x-2 sm:mt-0">
                        <!-- Previous Button -->
                        <button
                            class="flex items-center justify-center px-3 py-2 text-sm bg-white border rounded-md gap-x-2 hover:bg-gray-100"
                            :class="{
                                'text-gray-400 cursor-not-allowed':
                                    !categories.prev_page_url,
                            }"
                            :disabled="!categories.prev_page_url"
                            @click="
                                categories.prev_page_url &&
                                    router.visit(categories.prev_page_url)
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
                            v-for="link in categories.links"
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
                                    !categories.next_page_url,
                            }"
                            :disabled="!categories.next_page_url"
                            @click="
                                categories.next_page_url &&
                                    router.visit(categories.next_page_url)
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
</template>
