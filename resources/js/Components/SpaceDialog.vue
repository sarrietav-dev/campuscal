<script setup lang="ts">
import ResponsiveModal from "@/Components/ResponsiveModal.vue";
import { computed, ref } from "vue";
import { Button } from "@/Components/ui/button";
import SpaceCard from "@/Components/SpaceCard.vue";
import DatePicker from "@/Components/DatePicker.vue";
import { DateRange } from "radix-vue";
import {
    getLocalTimeZone,
    parseTime,
    toCalendarDateTime,
} from "@internationalized/date";

const campusId = ref<string | undefined>(undefined);
const spaceId = ref<string | undefined>(undefined);
const date = ref<DateRange>();
const startTime = ref<string | undefined>();
const endTime = ref<string | undefined>();

const emit = defineEmits<{
    create: [
        {
            spaceId: string;
            date: {
                start: Date;
                end: Date;
            };
        },
    ];
}>();

const campuses = ref([
    {
        id: "1",
        name: "Campus 1",
        imageUrl: "https://via.placeholder.com/150",
    },
    {
        id: "2",
        name: "Campus 2",
        imageUrl: "https://via.placeholder.com/150",
    },
]);

const spaces = ref([
    {
        id: "1",
        name: "Space 1",
        imageUrl: "https://via.placeholder.com/150",
    },
    {
        id: "23",
        name: "Space 2",
        imageUrl: "https://via.placeholder.com/150",
    },
]);

const isCampusSelected = computed(() => campusId.value !== undefined);
const isSpaceSelected = computed(
    () => spaceId.value !== undefined && campusId.value !== undefined,
);

function handleCreate() {
    console.log(spaceId.value, date.value, startTime.value, endTime.value);
    if (
        !spaceId.value ||
        !date.value ||
        !startTime.value ||
        !endTime.value ||
        date.value.start === undefined
    ) {
        return;
    }

    emit("create", {
        spaceId: spaceId.value,
        date: {
            start: toCalendarDateTime(
                date.value.start,
                parseTime(startTime.value!),
            ).toDate(getLocalTimeZone()),
            end: toCalendarDateTime(
                date.value.end ?? date.value.start,
                parseTime(endTime.value!),
            ).toDate(getLocalTimeZone()),
        },
    });
}
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
                    @click="campusId = campus.id"
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
                    @click="spaceId = space.id"
                />
            </div>
        </div>
        <div v-show="isSpaceSelected">
            <DatePicker
                :range="true"
                v-model="date"
                v-model:start-time="startTime"
                v-model:end-time="endTime"
            />
            <Button @click="handleCreate"> Seleccionar</Button>
        </div>
    </ResponsiveModal>
</template>
