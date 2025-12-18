<script setup>
import { ref } from "vue";
import axios from "axios";
import Icon from "../Icon.vue";

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["update:modelValue"]);

const query = ref("");
const results = ref([]);
const loading = ref(false);

const search = async () => {
    if (query.value.length < 2) {
        results.value = [];
        return;
    }

    loading.value = true;

    const res = await axios.get(route("admin.artists.search"), {
        params: { q: query.value },
    });

    results.value = res.data;
    loading.value = false;
};

const addArtist = (artist) => {
    if (props.modelValue.some((a) => a.id === artist.id)) return;

    emit("update:modelValue", [
        ...props.modelValue,
        {
            id: artist.id,
            name: artist.name,
            event_role: artist.primary_role,
        },
    ]);

    query.value = "";
    results.value = [];
};

const removeArtist = (id) => {
    emit(
        "update:modelValue",
        props.modelValue.filter((a) => a.id !== id)
    );
};
</script>

<template>
    <div class="space-y-2">
        <!-- Search -->
        <input
            v-model="query"
            @input="search"
            placeholder="Search artist..."
            class="w-full border rounded px-3 py-2"
        />

        <!-- Results -->
        <div v-if="results.length" class="border rounded bg-cyan-50 shadow">
            <div
                v-for="artist in results"
                :key="artist.id"
                @click="addArtist(artist)"
                class="px-3 py-2 cursor-pointer hover:bg-cyan-100"
            >
                {{ artist.name }}
                <span class="text-xs text-gray-500">
                    ({{ artist.primary_role }})
                </span>
            </div>
        </div>

        <!-- Selected Artists -->
        <div v-if="modelValue.length" class="space-y-2 mt-4">
            <div
                v-for="artist in modelValue"
                :key="artist.id"
                class="flex items-center gap-3 bg-cyan-50 border p-3 rounded"
            >
                <div class="flex-1">
                    <p class="font-medium capitalize">{{ artist.name }}</p>
                </div>

                <input
                    v-model="artist.event_role"
                    placeholder="Event Role"
                    class="border rounded px-2 text-sm py-1 w-40"
                />

                <button
                    type="button"
                    @click="removeArtist(artist.id)"
                    class="text-red-600 text-lg my-auto"
                >
                    <Icon name="close" />
                </button>
            </div>
        </div>
    </div>
</template>
