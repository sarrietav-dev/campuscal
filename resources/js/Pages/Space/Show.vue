<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import CarouselImage from "@/Components/CarouselImage.vue";
import { Button } from "@/Components/ui/button";
import { Link } from "@inertiajs/vue3";
import { DonutChart } from "@/Components/ui/chart-donut";
import { computed } from "vue";
import { trans } from "laravel-vue-i18n";

const props = defineProps<{
    space: {
        id: number;
        name: string;
        images: { url: string }[];
        resources: { name: string }[];
        campus_id: number;
        capacity: string;
    };
    peak_usage: { hour: string }[];
    times_booked: number;
    average_usage_time: number;
    shifts: {
        [key: string]: number;
    };
}>();

console.log(props.shifts);

const shiftsForChart = computed(() => {
    return Object.entries(props.shifts).map(([key, value]) => ({
        category: Math.round((value / props.times_booked) * 100),
        name: trans(key),
    }));
});

function hourTo12HourFormat(hour: string) {
    const ampm = +hour >= 12 ? "pm" : "am";
    const hours12 = +hour % 12 || 12;
    return `${hours12} ${ampm}`;
}
</script>

<template>
    <Head :title="space.name" />
    <AuthenticatedLayout>
        <div class="lg:grid lg:grid-cols-2 flex flex-col gap-5">
            <div class="px-12 lg:px-5">
                <Carousel class="mx-auto max-w-full lg:max-w-lg">
                    <CarouselContent>
                        <template v-if="props.space.images.length > 0">
                            <CarouselItem
                                v-for="image in props.space.images"
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
            <div class="lg:flex lg:flex-col lg:justify-center">
                <Card>
                    <CardHeader>
                        <div class="flex justify-between">
                            <div>
                                <CardTitle>
                                    {{ props.space.name }}
                                </CardTitle>
                                <CardDescription>
                                    Capacidad: {{ props.space.capacity }}
                                </CardDescription>
                            </div>
                            <Link
                                :href="
                                    route('spaces.edit', { space: space.id })
                                "
                            >
                                <Button>{{ $t("Edit") }}</Button>
                            </Link>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="flex">
                            <div>
                                <div class="mt-4">
                                    <h3 class="text-lg font-semibold">
                                        {{ $t("Peak usage hours") }}:
                                    </h3>
                                    <ul class="list-disc list-inside">
                                        <li
                                            v-for="peak in props.peak_usage"
                                            :key="peak.hour"
                                        >
                                            {{ hourTo12HourFormat(peak.hour) }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-4">
                                    <h3 class="text-lg font-semibold">
                                        {{ $t("Total bookings") }}:
                                    </h3>
                                    <p>{{ props.times_booked }}</p>
                                </div>

                                <div class="mt-4">
                                    <h3 class="text-lg font-semibold">
                                        {{ $t("Average usage time") }}:
                                    </h3>
                                    <p>
                                        {{
                                            Math.abs(
                                                props.average_usage_time / 60,
                                            ).toFixed(2)
                                        }}
                                        horas
                                    </p>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold my-4">
                                    {{ $t("Shifts distribution") }}:
                                </h3>
                                <DonutChart
                                    :data="shiftsForChart"
                                    :colors="['#FFD700', '#FFC400', '#FF8F00']"
                                    index="name"
                                    category="category"
                                    type="pie"
                                    show-legend
                                    :value-formatter="
                                        (tick, i) => {
                                            return `${tick}%`;
                                        }
                                    "
                                />
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
