<script setup lang="ts">
import ResponsiveModal from "@/Components/ResponsiveModal.vue";
import { computed, ref } from "vue";
import { Button } from "@/Components/ui/button";
import SpaceCard from "@/Components/SpaceCard.vue";
import DatePicker from "@/Components/DatePicker.vue";

const campusId = ref<string | undefined>(undefined);
const spaceId = ref<string | undefined>(undefined);
const date = ref();

const campuses = ref([
    {
        id: 1,
        name: "Campus 1",
        imageUrl: "https://via.placeholder.com/150",
    },
    {
        id: 2,
        name: "Campus 2",
        imageUrl: "https://via.placeholder.com/150",
    },
]);

const spaces = ref([
    {
        id: 1,
        name: "Space 1",
        imageUrl: "https://via.placeholder.com/150",
    },
    {
        id: 2,
        name: "Space 2",
        imageUrl: "https://via.placeholder.com/150",
    },
]);

function handleCampusSelection(campusIdValue: string) {
    campusId.value = campusIdValue;
}

function handleSpaceSelection(spaceIdValue: string) {
    spaceId.value = spaceIdValue;
}

const isCampusSelected = computed(() => campusId.value !== undefined);
const isSpaceSelected = computed(
    () => spaceId.value !== undefined && campusId.value !== undefined,
);
</script>

<template>
    <ResponsiveModal>
        <template #trigger>
            <Button>Open Space Dialog</Button>
        </template>
        <template #title v-if="!isCampusSelected">Campuses</template>
        <template #title v-else-if="!isSpaceSelected"> Spaces</template>
        <div>
            <div
                class="sm:grid grid-cols-2 gap-5"
                v-show="campusId === undefined"
            >
                <SpaceCard
                    v-for="campus in campuses"
                    :image-src="campus.imageUrl"
                    :title="campus.name"
                    alt="Campus Image"
                    :key="campus.id"
                    @click="handleCampusSelection"
                />
            </div>
        </div>
        <div
            class="sm:grid grid-cols-2 gap-5"
            v-show="campusId !== undefined && spaceId === undefined"
        >
            <div
                class="flex items-center gap-2"
                v-for="space in spaces"
                :key="space.id"
            >
                <SpaceCard
                    :image-src="space.imageUrl"
                    :title="space.name"
                    alt="Space Image"
                    @click="handleSpaceSelection"
                />
            </div>
        </div>
        <div v-show="isSpaceSelected">
            <DatePicker :range="true" v-model="date" />
        </div>
    </ResponsiveModal>
</template>
