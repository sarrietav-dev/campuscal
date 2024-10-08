<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { UseImage } from "@vueuse/components";
import { Calendar } from "v-calendar";
import axios from "axios";
import { useColorMode } from "@vueuse/core";

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

const mode = useColorMode();

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
    images: { url: string }[];
}

interface Appointment {
    id: number;
    booking_id: number;
    date_start: string;
    date_end: string;
    booking: { id: number; details: string };
}

const appointments = ref<Appointment[]>([]);

onMounted(() => {
    getMonthlyAppointments().then((res) => {
        appointments.value = res.data;
    });
});

async function getMonthlyAppointments(
    date?: { month: number; year: number }[],
) {
    const currentDate = date ? date[0] : undefined;

    return await axios.get<Appointment[]>(route("appointments.index"), {
        params: {
            month: currentDate?.month,
            year: currentDate?.year,
        },
    });
}

function handlePageChange({ month, year }: { month: number; year: number }) {
    getMonthlyAppointments([{ month, year }]).then((res) => {
        appointments.value = res.data;
    });
}

const calendarAttributes: (typeof Calendar)["attributes"] = computed(() => {
    return appointments.value.map((appointment) => {
        return {
            key: appointment.id,
            highlight: {
                start: { color: "yellow", fillMode: "outline" },
                base: { color: "yellow", fillMode: "light" },
                end: { color: "yellow", fillMode: "outline" },
            },
            popover: {
                label:
                    `#${appointment.booking_id} ` + appointment.booking.details,
            },
            dates: {
                start: new Date(appointment.date_start),
                end: new Date(appointment.date_end),
            },
        };
    });
});
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
            <div class="col-span-12 flex flex-col md:grid grid-cols-subgrid">
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
                                                :src="space.images[0].url"
                                                alt="space.name"
                                            >
                                                <template #loading>
                                                    <div
                                                        class="animate-pulse bg-gray-200 size-12 aspect-square rounded-lg"
                                                    ></div>
                                                </template>
                                                <template #error>
                                                    <span
                                                        class="bg-red-500 size-12 aspect-square rounded-lg"
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
                    <Calendar
                        expanded
                        locale="es"
                        :attributes="calendarAttributes"
                        @did-move="handlePageChange($event[0])"
                        :is-dark="{ selector: ':root', darkClass: 'dark' }"
                        transparent
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
