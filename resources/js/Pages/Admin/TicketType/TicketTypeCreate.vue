<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import Icon from "@/Components/Icon.vue";

const backToBtn = () => {
    router.visit(route("admin.events.ticket-types.index", props.event.id));
};

const props = defineProps({
    ticket: Object,
    errors: Object,
    event: Object,
});

const isEdit = !!props.ticket;

const form = useForm({
    _method: isEdit ? "PUT" : "POST",
    event_id: props.event.id,
    name: props.ticket?.name ?? "",
    description: props.ticket?.description ?? "",
    price: props.ticket?.price ?? 0,
    currency: props.ticket?.currency ?? "INR",
    quantity: props.ticket?.quantity ?? 1,
    min_per_order: props.ticket?.min_per_order ?? 1,
    max_per_order: props.ticket?.max_per_order ?? 10,
    is_free: props.ticket?.is_free ?? false,
    is_visible: props.ticket?.is_visible ?? true,
    sale_start: props.ticket?.sale_start ?? null,
    sale_end: props.ticket?.sale_end ?? null,
    sales_channel: props.ticket?.sales_channel ?? "online",
    status: props.ticket?.status ?? "active",
    sort_order: props.ticket?.sort_order ?? 0,
});

function submit() {
    const url = isEdit
        ? route("admin.ticket-types.update", props.ticket.id)
        : route("admin.events.ticket-types.store", props.event.id);

    form.post(url, {
        forceFormData: true,
    });
}
</script>

<template>
    <Head :title="isEdit ? 'Edit Ticket Type' : 'Create Ticket Type'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div class="my-auto">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        {{ isEdit ? "Edit" : "Create" }} Ticket Types
                    </h2>
                </div>
                <div>
                    {{ event_id }}
                    <button
                        type="button"
                        @click="backToBtn()"
                        class="bg-cyan-700 hover:bg-cyan-500 text-cyan-50 font-normal text-xs py-2 px-4 rounded-full"
                    >
                        <Icon name="backarrow" class="h-4 w-4 inline-block" />
                        Back to Ticket Type
                    </button>
                </div>
            </div>
        </template>

        <div class="mx-auto max-w-full sm:px-6 lg:px-8 py-5">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <!-- component -->
                <form @submit.prevent="submit">
                    <div class="px-8 py-5 mb-4 my-2">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Ticket Name
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
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-description"
                                >
                                    Price
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    id="grid-description"
                                    placeholder="Say something..."
                                    type="number"
                                    step="0.01"
                                    :disabled="form.is_free"
                                    v-model="form.price"
                                />
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
                                    Currency
                                </label>
                                <select
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    v-model="form.currency"
                                >
                                    <option disabled :value="null">
                                        Select Currency
                                    </option>

                                    <option value="INR">INR</option>
                                    <option value="USD">USD</option>
                                </select>
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.name"
                                >
                                    {{ errors.name }}
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Sale Start
                                </label>
                                <input
                                    v-model="form.sale_start"
                                    type="datetime-local"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                />
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                    for="grid-first-name"
                                    >Sale End</label
                                >
                                <input
                                    v-model="form.sale_end"
                                    type="datetime-local"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                />
                            </div>
                        </div>

                        <div class="-mx-3 grid grid-cols-1 md:grid-cols-3 mb-6">
                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Total Quantity
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="number"
                                    placeholder="City"
                                    v-model="form.quantity"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.quantity"
                                >
                                    {{ errors.quantity }}
                                </div>
                            </div>

                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Min / Order
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="number"
                                    placeholder="State"
                                    v-model="form.min_per_order"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.min_per_order"
                                >
                                    {{ errors.min_per_order }}
                                </div>
                            </div>

                            <div class="px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                >
                                    Max / Order
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    type="number"
                                    placeholder="Country"
                                    v-model="form.max_per_order"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.max_per_order"
                                >
                                    {{ errors.max_per_order }}
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
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded mb-3"
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
                                    Status
                                </label>
                                <select
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    v-model="form.status"
                                >
                                    <option disabled :value="null">
                                        Select Status
                                    </option>
                                    <option :value="'active'">Active</option>
                                    <option :value="'inactive'">
                                        Inactive
                                    </option>
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
                                    Sales Channel
                                </label>
                                <select
                                    v-model="form.sales_channel"
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 capitalize focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                >
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                    <option value="invite">Invite Only</option>
                                </select>
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
                                    Sort Order
                                </label>
                                <input
                                    class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-cyan-700 focus:ring-cyan-500 rounded py-3 px-4 mb-3"
                                    id="grid-description"
                                    placeholder="Say something..."
                                    v-model="form.sort_order"
                                    type="number"
                                />
                                <div
                                    class="text-red-500 font-bold text-sm italic"
                                    v-if="errors.name"
                                >
                                    {{ errors.name }}
                                </div>
                            </div>
                        </div>
                        <!-- Toggles -->
                        <div class="grid grid-cols-3 gap-4">
                            <label class="flex items-center">
                                <Checkbox
                                    name="is_free"
                                    v-model:checked="form.is_free"
                                />
                                <span class="ms-2 text-sm text-gray-600"
                                    >Free Ticket</span
                                >
                            </label>

                            <label class="flex items-center">
                                <Checkbox
                                    name="is_visible"
                                    v-model:checked="form.is_visible"
                                />
                                <span class="ms-2 text-sm text-gray-600"
                                    >Visible</span
                                >
                            </label>
                        </div>
                    </div>
                    <div
                        class="flex justify-end border-t-2 py-10 px-8 border-gray-200"
                    >
                        <button
                            type="submit"
                            class="hover:shadow-form rounded-md bg-cyan-600 py-3 px-8 text-base font-semibold text-white outline-none"
                        >
                            {{
                                isEdit
                                    ? "Update Ticket Type"
                                    : "Save Ticket Type"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
