<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $page?.props?.auth?.roles[0] }} Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="px-6  text-gray-900">
                        You're logged in as
                        <b>{{ $page?.props?.auth?.roles[0] }}</b
                        >!
                    </div>
                    <div class="px-6 text-gray-900">
                        {{ $page?.props?.auth?.user?.name }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
