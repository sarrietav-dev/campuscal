<script setup lang="ts">
import ResponsiveModal from "@/Components/ResponsiveModal.vue";
import { computed, ref, watch } from "vue";
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
import { useQuery } from "@tanstack/vue-query";
import { getCampuses, getSpaces, Space } from "@/lib/api";
import ErrorMessage from "@/Components/ErrorMessage.vue";

const date = ref<DateRange>();
const startTime = ref<string | undefined>();
const endTime = ref<string | undefined>();
const props = defineProps<{
    open?: boolean;
}>();

const emit = defineEmits<{
    create: [
        {
            id: number;
            name: string;
            imageUrl: string;
            date: {
                start: Date;
                end: Date;
            };
        },
    ];
    "update:open": [boolean];
}>();

const { data: campuses } = useQuery({
    queryKey: ["campuses"],
    queryFn: () => getCampuses(),
});
const campusId = ref<number | undefined>(undefined);
const isCampusSelected = computed(() => campusId.value !== undefined);

const spaces = ref<Space[]>([]);
const isSpacesLoading = ref(false);
const calendarErrorMessage = ref<string | null>(null);

const spaceId = ref<number | undefined>(undefined);
const isSpaceSelected = computed(
    () => spaceId.value !== undefined && campusId.value !== undefined,
);

watch(campusId, async () => {
    if (isCampusSelected) {
        isSpacesLoading.value = true;
        const newSpaces = await getSpaces(campusId.value ?? 0);
        spaces.value = newSpaces ?? [];
        isSpacesLoading.value = false;
    }
});

const space = computed(() => {
    return spaces.value?.find((s) => s.id === spaceId.value);
});

function handleModalOpen(open: boolean) {
    setTimeout(() => {
        campusId.value = undefined;
        spaceId.value = undefined;
        date.value = undefined;
        startTime.value = undefined;
        endTime.value = undefined;
        spaces.value = [];
        isSpacesLoading.value = false;
    }, 100);
    emit("update:open", open);
}

function handleCreate() {
    if (!spaceId.value) {
        calendarErrorMessage.value = "Selecciona un espacio";
        return;
    } else if (!date.value) {
        console.warn("Date is not selected", date.value);
        calendarErrorMessage.value = "Selecciona una fecha";
        return;
    } else if (!startTime.value) {
        console.warn("Start time is not selected", startTime.value);
        calendarErrorMessage.value = "Selecciona una hora de inicio";
        return;
    } else if (!endTime.value) {
        console.warn("End time is not selected", endTime.value);
        calendarErrorMessage.value = "Selecciona una hora de fin";
        return;
    }

    if (!date.value?.start || !date.value?.end) {
        console.warn("Date is not selected", date.value);
        calendarErrorMessage.value = "Selecciona una fecha";
        return;
    }

    emit("create", {
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
        id: spaceId.value,
        imageUrl: space.value?.images[0].url ?? "",
        name: space.value?.name ?? "",
    });
    emit("update:open", false);
}
</script>

<template>
    <ResponsiveModal :open="props.open" @update:open="handleModalOpen($event)">
        <template #trigger>
            <Button class="w-full border-dashed py-10" variant="outline">
                Elige aquí los espacios que quieres usar
            </Button>
        </template>
        <template #title v-if="!isCampusSelected">Campuses</template>
        <template #title v-else-if="!isSpaceSelected">Spaces</template>
        <div class="overflow-y-auto">
            <div
                class="sm:grid sm:grid-cols-4 gap-5"
                v-show="campusId === undefined"
            >
                <SpaceCard
                    v-for="campus in campuses"
                    :image-src="campus.image"
                    :title="campus.name"
                    :key="campus.id"
                    :height="100"
                    :width="100"
                    alt="Campus Image"
                    @click="campusId = campus.id"
                />
            </div>
        </div>
        <div
            class="sm:flex gap-5"
            v-show="
                campusId !== undefined &&
                spaceId === undefined &&
                isSpacesLoading
            "
        >
            <template v-for="_ in 3">
                <div class="inline">
                    <div
                        class="animate-pulse bg-gray-200 aspect-square w-[100px] h-[100px] rounded-lg"
                    ></div>
                    <div
                        class="w-[100px] mt-2 h-4 animate-pulse bg-gray-200 rounded-md"
                    ></div>
                </div>
            </template>
        </div>
        <div
            class="sm:grid grid-cols-4 gap-5 overflow-y-auto"
            v-show="
                campusId !== undefined &&
                spaceId === undefined &&
                !isSpacesLoading
            "
        >
            <div
                class="flex items-center gap-2"
                v-for="space in spaces"
                :key="space.id"
            >
                <SpaceCard
                    :image-src="space.images[0].url"
                    :title="space.name"
                    alt="Space Image"
                    :height="100"
                    :width="100"
                    @click="spaceId = space.id"
                />
            </div>
        </div>
        <div
            class="flex flex-col gap-10 overflow-y-auto align-center max-w-[368px] sm:max-w-full self-center w-full"
            v-if="space"
            v-show="isSpaceSelected"
        >
            <div
                class="flex flex-col sm:flex-row sm:justify-between sm:px-12 items-center"
            >
                <div class="w-6/12 p-12 sm:p-0">
                    <Carousel class="mx-auto w-full max-w-full lg:max-w-lg">
                        <CarouselContent>
                            <template v-if="space.images.length > 0">
                                <CarouselItem
                                    v-for="image in space.images"
                                    :key="image.url"
                                >
                                    <CarouselImage :image="image.url" />
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
                </div>
                <ul class="ml-16 grow">
                    <li>Nombre: {{ space?.name }}</li>
                    <li>Capacidad: {{ space?.capacity }}</li>
                    <li v-if="space.resources?.length > 0">
                        Recursos disponibles:
                        <ul>
                            <li
                                v-for="resource in space.resources"
                                :key="resource"
                            >
                                <Badge>{{ resource }}</Badge>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div
                className="col-span-3 flex flex-col items-stretch md:flex-row gap-5 md:gap-3 justify-between mb-5 md:mb-0 self-stretch"
            >
                <div class="w-full">
                    <DatePicker
                        :range="true"
                        v-model="date"
                        v-model:start-time="startTime"
                        v-model:end-time="endTime"
                    />
                    <ErrorMessage v-if="calendarErrorMessage">
                        {{ calendarErrorMessage }}
                    </ErrorMessage>
                </div>
                <Button @click="handleCreate"> Seleccionar</Button>
            </div>
        </div>
    </ResponsiveModal>
</template>
