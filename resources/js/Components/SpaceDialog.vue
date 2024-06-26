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
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import CarouselImage from "@/Components/CarouselImage.vue";
import { Card, CardContent } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";

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

const space = ref({
    id: "1",
    name: "Space 1",
    capacity: 10,
    availableResources: ["Proyector", "Pizarra"],
    images: [
        "https://via.placeholder.com/500",
        "https://via.placeholder.com/500",
    ],
});

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
            <Button class="w-full border-dashed py-10" variant="outline">
                Elige aquí el espacio que quieres usar
            </Button>
        </template>
        <template #title v-if="!isCampusSelected">Campuses</template>
        <template #title v-else-if="!isSpaceSelected"> Spaces</template>
        <div class="overflow-y-auto">
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
            class="sm:grid grid-cols-2 gap-5 overflow-y-auto"
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
        <div
            class="flex flex-col gap-10 overflow-y-auto"
            v-show="isSpaceSelected"
        >
            <div
                class="flex flex-col md:flex-row md:justify-between md:px-10 items-center"
            >
                <Carousel class="mx-auto w-full max-w-full lg:max-w-lg">
                    <CarouselContent>
                        <template v-if="space.images.length > 0">
                            <CarouselItem
                                v-for="image in space.images"
                                :key="image"
                            >
                                <CarouselImage :image="image" />
                            </CarouselItem>
                        </template>
                        <CarouselItem v-else>
                            <div class="p-1">
                                <Card>
                                    <CardContent
                                        class="flex aspect-square items-center justify-center p-6"
                                    >
                                        <img
                                            src="https://picsum.photos/300/300"
                                            alt="Space image"
                                            class="object-contain absolute size-full"
                                        />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
                <ul>
                    <li>Nombre: {{ space?.name }}</li>
                    <li>Capacidad: {{ space?.capacity }}</li>
                    <li v-if="space.availableResources.length > 0">
                        Recursos disponibles:
                        <ul>
                            <li
                                v-for="resource in space.availableResources"
                                :key="resource"
                            >
                                <Badge>{{ resource }}</Badge>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div
                className="col-span-3 flex flex-col items-stretch md:flex-row gap-5 md:gap-0 justify-between mb-5 md:mb-0"
            >
                <DatePicker
                    :range="true"
                    v-model="date"
                    v-model:start-time="startTime"
                    v-model:end-time="endTime"
                />
                <Button @click="handleCreate"> Seleccionar</Button>
            </div>
        </div>
    </ResponsiveModal>
</template>
