<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Icon from "@/Components/Icon.vue";

const props = defineProps({
    isOpen: Boolean,
    isMinimized: Boolean,
});

const emit = defineEmits(["toggle"]);

const page = usePage();

const roles = computed(() => page.props?.auth?.roles ?? []);
const hasRole = (role) => roles.value.includes(role);

const openDropdownName = ref(null);
const toggleDropdown = (name) => {
    openDropdownName.value = openDropdownName.value === name ? null : name;
};

// const isLinkActive = (routeName) => route().current(routeName);
const isLinkActive = (routeNames) => {
    if (Array.isArray(routeNames)) {
        return routeNames.some((name) => route().current(name));
    }
    return route().current(routeNames);
};

const menuRouteMap = {
    categories: [
        "admin.event-categories.index",
        "admin.event-categories.create",
    ],
    events: ["admin.events.index", "admin.events.create"],
    venues: ["admin.venues.index", "admin.venues.create"],
};

const autoOpenDropdown = () => {
    const current = route().current();

    for (const menuName in menuRouteMap) {
        const routes = menuRouteMap[menuName];

        if (routes.includes(current)) {
            openDropdownName.value = menuName;
            break;
        }
    }
};

autoOpenDropdown();
</script>

<template>
    <div class="flex bg-gray-100 antialiased">
        <aside
            :class="{
                '-translate-x-full': !props.isOpen,
                'translate-x-0': props.isOpen,
                'w-64': !props.isMinimized,
                'w-20': props.isMinimized,
            }"
            class="fixed inset-y-0 left-0 z-30 md:mt-14 lg:mt-16 border-t border-gray-200 bg-white shadow-xl transform transition-all duration-300 ease-in-out flex flex-col lg:translate-x-0 h-screen"
        >
            <!-- Logo / Mobile close -->
            <div
                class="p-4 flex lg:hidden items-center justify-between h-16 border-b border-cyan-700"
            >
                <button
                    @click="$emit('toggle')"
                    class="text-cyan-800 hover:text-white hover:bg-cyan-800 rounded p-1 lg:hidden"
                >
                    <svg
                        xmlns="www.w3.org"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- All navigation content -->
            <nav class="flex-1 flex flex-col p-4 space-y-2 overflow-y-auto">
                <!-- === ADMIN DASHBOARD === -->
                <Link
                    :href="route('dashboard')"
                    class="flex items-center text-sm p-3 rounded-lg transition duration-150 group"
                    :class="{
                        'bg-cyan-700 text-white shadow-md':
                            isLinkActive('dashboard'),
                        'text-cyan-800 hover:bg-cyan-700 hover:text-white':
                            !isLinkActive('dashboard'),
                    }"
                >
                    <Icon name="home" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Dashboard</span
                    >
                </Link>

                <!-- === EVENTS MANAGEMENT === -->
                <div v-if="hasRole('Admin')">
                    <a
                        @click.prevent="toggleDropdown('categories')"
                        href="#"
                        class="flex items-center p-3 rounded-lg transition duration-150 group cursor-pointer text-sm"
                        :class="{
                            'bg-cyan-700 text-white':
                                openDropdownName === 'categories',
                            'text-cyan-800 hover:bg-cyan-700 hover:text-white':
                                openDropdownName !== 'categories',
                        }"
                    >
                        <Icon name="category" class="w-5 h-5" />
                        <span v-if="!isMinimized" class="ml-3 flex-1 truncate"
                            >Event Category</span
                        >
                        <Icon
                            v-if="!isMinimized"
                            :name="
                                openDropdownName === 'categories'
                                    ? 'chevronUp'
                                    : 'chevronDown'
                            "
                            class="w-4 h-4 ml-auto"
                        />
                    </a>

                    <div
                        :class="{
                            'max-h-96 opacity-100':
                                openDropdownName === 'categories',
                            'max-h-0 opacity-0':
                                openDropdownName !== 'categories' ||
                                isMinimized,
                        }"
                        class="overflow-hidden transition-all duration-300 ease-in-out pl-4"
                    >
                        <Link
                            :href="route('admin.event-categories.index')"
                            :class="{
                                'bg-cyan-700 text-white': isLinkActive(
                                    'admin.event-categories.index'
                                ),
                            }"
                            class="flex items-center p-3 text-sm mt-2 rounded-lg hover:bg-cyan-700 hover:text-white"
                        >
                            <Icon name="list" class="w-4 h-4 mr-2" /> All
                            Categories
                        </Link>

                        <Link
                            :href="route('admin.event-categories.create')"
                            :class="{
                                'bg-cyan-700 text-white': isLinkActive(
                                    'admin.event-categories.create'
                                ),
                            }"
                            class="flex items-center p-3 text-sm my-2 rounded-lg hover:bg-cyan-700 hover:text-white"
                        >
                            <Icon name="create" class="w-5 h-5 mr-1" /> Create
                            Category
                        </Link>
                    </div>
                </div>

                <!-- === EVENTS MANAGEMENT === -->
                <div v-if="hasRole('Admin')">
                    <a
                        @click.prevent="toggleDropdown('events')"
                        href="#"
                        class="flex items-center p-3 rounded-lg transition duration-150 group cursor-pointer text-sm"
                        :class="{
                            'bg-cyan-700 text-white':
                                openDropdownName === 'events',
                            'text-cyan-800 hover:bg-cyan-700 hover:text-white':
                                openDropdownName !== 'events',
                        }"
                    >
                        <Icon name="calendar" class="w-5 h-5" />
                        <span v-if="!isMinimized" class="ml-3 flex-1 truncate"
                            >Events</span
                        >
                        <Icon
                            v-if="!isMinimized"
                            :name="
                                openDropdownName === 'events'
                                    ? 'chevronUp'
                                    : 'chevronDown'
                            "
                            class="w-4 h-4 ml-auto"
                        />
                    </a>

                    <div
                        :class="{
                            'max-h-96 opacity-100':
                                openDropdownName === 'events',
                            'max-h-0 opacity-0':
                                openDropdownName !== 'events' || isMinimized,
                        }"
                        class="overflow-hidden transition-all duration-300 ease-in-out pl-4"
                    >
                        <Link
                            :href="route('admin.events.index')"
                            :class="{
                                'bg-cyan-700 text-white':
                                    isLinkActive('admin.events.index'),
                            }"
                            class="flex items-center p-3 text-sm mt-2 rounded-lg hover:bg-cyan-700 hover:text-white"
                        >
                            <Icon name="list" class="w-4 h-4 mr-2" /> All Events
                        </Link>

                        <Link
                            :href="route('admin.events.create')"
                            :class="{
                                'bg-cyan-700 text-white': isLinkActive(
                                    'admin.events.create'
                                ),
                            }"
                            class="flex items-center p-3 text-sm my-2 rounded-lg hover:bg-cyan-700 hover:text-white"
                        >
                            <Icon name="create" class="w-5 h-5 mr-1" /> Create
                            Event
                        </Link>
                    </div>
                </div>

                <!-- === VENUE MANAGEMENT === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.venues.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive([
                            'admin.venues.index',
                            'admin.venues.create',
                            'admin.venues.edit',
                            'admin.venues.show',
                        ]),
                    }"
                    class="flex items-center p-3 text-sm text-cyan-800 rounded-lg hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="location" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Venues</span
                    >
                </Link>

                <!-- === TICKET TYPES === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.ticket-types.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.ticket-types.index',
                            'admin.ticket-types.create',
                            'admin.ticket-types.edit',
                            'admin.ticket-types.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="ticket" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Ticket Types</span
                    >
                </Link>

                <!-- === BOOKINGS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.bookings.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.bookings.index',
                            'admin.bookings.create',
                            'admin.bookings.edit',
                            'admin.bookings.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="list" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Bookings</span
                    >
                </Link>

                <!-- === PAYMENTS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.payments.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.payments.index',
                            'admin.payments.create',
                            'admin.payments.edit',
                            'admin.payments.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="billing" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Payments</span
                    >
                </Link>

                <!-- === REFUNDS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.refunds.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.refunds.index',
                            'admin.refunds.create',
                            'admin.refunds.edit',
                            'admin.refunds.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="refund" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Refunds</span
                    >
                </Link>

                <!-- === USERS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.users.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.users.index',
                            'admin.users.create',
                            'admin.users.edit',
                            'admin.users.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="users" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate">Users</span>
                </Link>

                <!-- === STAFF === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.staff.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.staff.index',
                            'admin.staff.create',
                            'admin.staff.edit',
                            'admin.staff.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="teamRole" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate">Staff</span>
                </Link>

                <!-- === REPORTS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.reports.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.reports.index',
                            'admin.reports.create',
                            'admin.reports.edit',
                            'admin.reports.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="report" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Reports</span
                    >
                </Link>

                <!-- === SETTINGS === -->
                <Link
                    v-if="hasRole('Admin')"
                    :href="route('admin.settings.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'admin.settings.index',
                            'admin.settings.create',
                            'admin.settings.edit',
                            'admin.settings.show'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="cog" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Settings</span
                    >
                </Link>

                <!-- admin end -->

                <!-- event management start -->

                <!-- === EVENTS === -->
                <Link
                    v-if="hasRole('Event Manager')"
                    :href="route('manager.events.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'manager.events.index',
                            'manager.events.create',
                            'manager.events.edit',
                            'manager.events.show',
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="calendar" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Events</span
                    >
                </Link>

                <!-- === VENUES === -->
                <Link
                    v-if="hasRole('Event Manager')"
                    :href="route('manager.venues.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'manager.venues.index'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="location" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Venues</span
                    >
                </Link>

                <!-- === TICKET TYPES === -->
                <Link
                    v-if="hasRole('Event Manager')"
                    :href="route('manager.ticket-types.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'manager.ticket-types.index'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="ticket" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Ticket Types</span
                    >
                </Link>

                <!-- === BOOKINGS === -->
                <Link
                    v-if="hasRole('Event Manager')"
                    :href="route('manager.bookings.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'manager.bookings.index'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="list" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Bookings</span
                    >
                </Link>

                <!-- === REPORTS === -->
                <Link
                    v-if="hasRole('Event Manager')"
                    :href="route('manager.reports.index')"
                    :class="{
                        'bg-cyan-700 text-white': isLinkActive(
                            'manager.reports.index'
                        ),
                    }"
                    class="flex items-center p-3 text-sm rounded-lg text-cyan-800 hover:bg-cyan-700 hover:text-white"
                >
                    <Icon name="report" class="w-5 h-5" />
                    <span v-if="!isMinimized" class="ml-3 truncate"
                        >Reports</span
                    >
                </Link>

                <!-- event management end -->
            </nav>
        </aside>
    </div>
</template>
