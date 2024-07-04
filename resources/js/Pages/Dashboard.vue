<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import LineChart from "@/Components/LineChart.vue";
import { Link } from "@inertiajs/vue3";
import { UseImage } from "@vueuse/components";

interface Stat {
    title: string;
    value: number;
    icon: string;
    color: string;
}

const props = defineProps<{
    total_bookings_current_month: number;
    pending_bookings: number;
    approved_bookings: number;
    rejected_bookings: number;
    most_requested_spaces: MostRequestedSpace[];
}>();

const stats = ref<Stat[]>([
    {
        title: "Total de solicitudes",
        value: props.total_bookings_current_month,
        icon: "list",
        color: "bg-blue-500",
    },
    {
        title: "Solicitudes pendientes",
        value: props.pending_bookings,
        icon: "clock",
        color: "bg-yellow-500",
    },
    {
        title: "Solicitudes aceptadas",
        value: props.approved_bookings,
        icon: "check",
        color: "bg-green-500",
    },
    {
        title: "Solicitudes rechazadas",
        value: props.rejected_bookings,
        icon: "times",
        color: "bg-red-500",
    },
]);

interface MostRequestedSpace {
    id: number;
    name: string;
    appointments_count: number;
    images: { path: string }[];
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container max-w-5xl mx-auto grid grid-cols-12">
            <div
                class="grid rounded-lg shadow-lg grid-cols-1 gap-4 bg-accent sm:grid-cols-2 md:grid-cols-4 col-span-12"
            >
                <template v-for="stat in stats">
                    <div class="p-6 text-accent-foreground">
                        <div class="flex items center justify-between">
                            <div class="flex items center">
                                <i
                                    class="mr-2 text-2xl"
                                    :class="`fa fa-${stat.icon}`"
                                ></i>
                                <div>
                                    <div class="text-sm font-semibold">
                                        {{ stat.title }}
                                    </div>
                                    <div class="text-2xl font-bold">
                                        {{ stat.value }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-span-12 grid grid-cols-subgrid">
                <div class="col-span-3">
                    <div class="py-6 text-accent-foreground">
                        <div class="text-sm font-semibold">
                            Espacios más solicitados
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <template
                                v-for="space in props.most_requested_spaces"
                            >
                                <Link :href="`/spaces/${space.id}`">
                                    <div
                                        class="flex items center justify-between shadow-lg bg-accent rounded-xl p-4 hover:shadow-md hover:shadow-muted transition hover:-translate-y-1 active:translate-y-0"
                                    >
                                        <div class="flex items center">
                                            <UseImage
                                                class="size-12 rounded-lg"
                                                :src="space.images[0].path"
                                                alt="space.name"
                                            >
                                                <template #loading>
                                                    <div
                                                        class="animate-pulse bg-gray-200 size-12 aspect-square rounded-lg"
                                                    ></div>
                                                </template>
                                                <template #error>
                                                    <span
                                                        class="bg-red-500 absolute size-12 aspect-square"
                                                    ></span>
                                                </template>
                                            </UseImage>
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-semibold"
                                                >
                                                    {{ space.name }}
                                                </div>
                                                <div
                                                    class="text-sm font-semibold"
                                                >
                                                    Solicitudes:
                                                    {{
                                                        space.appointments_count
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
                <div
                    class="col-start-5 col-end-13 col-span-8 content-center py-6"
                >
                    <LineChart />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
