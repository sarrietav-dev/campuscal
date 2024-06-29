<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Baby,
    BookUser,
    BriefcaseBusiness,
    Building2,
    CircleUserRound,
    Fingerprint,
    Mail,
    Phone,
    ReceiptText,
    UsersRound,
} from "lucide-vue-next";
import BookingStateIndicator from "@/Components/BookingStateIndicator.vue";
import Text from "@/Components/ui/Text.vue";
import Chip from "@/Components/Chip.vue";
import SelectedSpaceCard from "@/Components/SelectedSpaceCard.vue";
import ObservationForm from "@/Components/ObservationForm.vue";

const { booking } = defineProps<{
    booking: {
        agreement_contract: boolean;
        agreement_contracts: {
            path: string;
        }[];
        appointments: {
            booking_id: number;
            date_end: string;
            date_start: string;
            space_id: number;
            space: { name: string; images: { path: string }[] };
        }[];
        assistance: number;
        audience: { name: string }[];
        details: string;
        id: number;
        external_details?: string;
        minors: boolean;
        status: string;
        observations: string;
        requester: {
            academic_unit: string;
            company_name: string;
            company_role: string;
            email: string;
            identification: string;
            name: string;
            surname: string;
            phone: string;
        };
    };
}>();
</script>

<template>
    <AuthenticatedLayout>
        <div class="container max-w-screen-md">
            <div class="space-y-16">
                <section>
                    <Text variant="heading2" class="mb-5 text-center">
                        Detalles de la actividad
                    </Text>

                    <ul class="space-y-5">
                        <li>
                            <p>{{ booking.details }}</p>
                        </li>

                        <li class="space-y-3">
                            <p class="font-semibold">
                                <UsersRound class="inline" />
                                Público dirigido de la actividad
                            </p>
                            <div class="flex flex-wrap gap-5">
                                <Chip v-for="audience in booking.audience">
                                    {{ audience.name }}
                                </Chip>
                            </div>
                        </li>
                        <li v-if="booking.external_details" class="space-y-3">
                            <template>
                                <p class="font-semibold">
                                    <UsersRound class="inline" />
                                    Detalle del personal externo
                                </p>
                                <p>{{ booking.external_details }}</p>
                            </template>
                        </li>
                        <li>
                            <p
                                class="font-semibold"
                                :class="{
                                    'text-neutral-300 dark:text-muted':
                                        !booking.minors,
                                }"
                            >
                                <Baby class="inline" />
                                Este evento
                                {{ booking.minors ? "sí" : "no" }}
                                contará con la presencia de menores de edad
                            </p>
                        </li>
                        <li>
                            <p
                                class="font-semibold"
                                :class="{
                                    'text-neutral-300 dark:text-muted':
                                        !booking.agreement_contract,
                                }"
                            >
                                <ReceiptText class="inline" />
                                Esta actividad
                                {{ booking.agreement_contract ? "sí" : "no" }}
                                se llevará acabo dentro del marco de un convenio
                                o contrato interadministrativo:
                                <a
                                    :href="booking.agreement_contracts[0].path"
                                    target="_blank"
                                >
                                    <strong class="font-semibold">
                                        Abrir archivo
                                    </strong>
                                </a>
                            </p>
                        </li>
                        <li>
                            <p class="font-semibold">
                                <BookUser class="inline" />
                                El numero de asistentes será
                                <span class="rounded bg-muted p-1">
                                    {{ booking.assistance }}
                                </span>
                            </p>
                        </li>
                    </ul>
                </section>
                <section>
                    <Text variant="heading2" class="mb-5 text-center">
                        Espacios escogidos
                    </Text>
                    <ul class="space-y-5">
                        <li
                            v-for="appointment in booking.appointments"
                            :key="appointment.space_id"
                        >
                            <SelectedSpaceCard
                                :date="{
                                    from: `${new Date(
                                        appointment.date_start,
                                    ).toLocaleDateString()} ${new Date(
                                        appointment.date_start,
                                    ).toLocaleTimeString()}`,
                                    to: `${new Date(
                                        appointment.date_end,
                                    ).toLocaleDateString()} ${new Date(
                                        appointment.date_end,
                                    ).toLocaleTimeString()}`,
                                }"
                                :image-url="appointment.space.images[0].path"
                                :space-name="appointment.space.name"
                            />
                        </li>
                    </ul>
                </section>
                <section>
                    <div class="rounded-lg bg-muted p-5">
                        <Text variant="heading4" class="mb-4 text-center">
                            Información del solicitador
                        </Text>
                        <ul class="space-y-5">
                            <li>
                                <CircleUserRound class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">Nombre:</p>
                                {{ booking.requester.name }}
                            </li>

                            <li>
                                <Fingerprint class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">
                                    Numero de identificación:
                                </p>
                                : {{ booking.requester.identification }}
                            </li>

                            <li>
                                <Phone class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">Celular:</p>
                                {{ booking.requester.phone }}
                            </li>

                            <li>
                                <Mail class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">
                                    Correo institucional:
                                </p>
                                <a :href="`mailto:${booking.requester.email}`">
                                    {{ booking.requester.email }}
                                </a>
                            </li>

                            <li>
                                <Building2 class="inline" />
                                <p class="inline font-semibold">
                                    Entidad o empresa:
                                </p>
                                {{ booking.requester.company_name }}
                            </li>

                            <li>
                                <BriefcaseBusiness class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">Cargo:</p>
                                {{ booking.requester.company_role }}
                            </li>
                            <li>
                                <BriefcaseBusiness class="inline" />
                                <p class="inline font-semibold">
                                    Unidad académica:
                                </p>
                                {{ booking.requester.academic_unit }}
                            </li>
                        </ul>
                    </div>
                </section>
                <section>
                    <ObservationForm v-if="booking.status === 'pending'" />
                    <BookingStateIndicator
                        v-else
                        :status="booking.status as any"
                        :observations="booking.observations"
                    />
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
