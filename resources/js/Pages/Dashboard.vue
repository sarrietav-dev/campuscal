<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import LineChart from "@/Components/LineChart.vue";

interface Stat {
    title: string;
    value: number;
    icon: string;
    color: string;
}

const stats = ref<Stat[]>([
    {
        title: "Total de solicitudes",
        value: 0,
        icon: "list",
        color: "bg-blue-500",
    },
    {
        title: "Solicitudes pendientes",
        value: 0,
        icon: "clock",
        color: "bg-yellow-500",
    },
    {
        title: "Solicitudes aceptadas",
        value: 0,
        icon: "check",
        color: "bg-green-500",
    },
    {
        title: "Solicitudes rechazadas",
        value: 0,
        icon: "times",
        color: "bg-red-500",
    },
]);

interface MostRequestedSpace {
    name: string;
    requests: number;
    image: string;
}

const mostRequestedSpaces = ref<MostRequestedSpace[]>([
    {
        name: "Sala de juntas",
        requests: 0,
        image: "https://picsum.photos/200/300",
    },
    {
        name: "Sala de capacitación",
        requests: 0,
        image: "https://picsum.photos/200/300",
    },
    {
        name: "Sala de conferencias",
        requests: 0,
        image: "https://picsum.photos/200/300",
    },
    {
        name: "Sala de juntas",
        requests: 0,
        image: "https://picsum.photos/200/300",
    },
    {
        name: "Sala de juntas",
        requests: 0,
        image: "https://picsum.photos/200/300",
    },
]);
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
                            <template v-for="space in mostRequestedSpaces">
                                <div
                                    class="flex items center justify-between bg-accent rounded-lg p-4"
                                >
                                    <div class="flex items center">
                                        <img
                                            class="w-12 h-12 rounded-lg"
                                            :src="space.image"
                                            alt="space.name"
                                        />
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold">
                                                {{ space.name }}
                                            </div>
                                            <div class="text-sm font-semibold">
                                                Solicitudes:
                                                {{ space.requests }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
