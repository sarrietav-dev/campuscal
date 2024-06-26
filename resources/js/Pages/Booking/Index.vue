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
import { ref } from "vue";
import Text from "@/Components/ui/Text.vue";
import Chip from "@/Components/Chip.vue";
import SelectedSpaceCard from "@/Components/SelectedSpaceCard.vue";
import ObservationForm from "@/Components/ObservationForm.vue";

const request = ref({
    details: "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
    audience: ["Students"],
    externalAudienceDetails:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
    areMinorsIncluded: true,
    hasAgreementContract: true,
    agreementContractFilePath: "https://via.placeholder.com/800x600",
    assistanceCount: 10,
    appointments: [
        {
            spaceId: 1,
            spaceName: "Salón 1",
            date: {
                from: "2022-12-12",
                to: "2022-12-12",
            },
            startTime: "12:00",
            endTime: "14:00",
            imageUrl: "https://via.placeholder.com/800x600",
        },
        {
            spaceId: 2,
            spaceName: "Salón 2",
            date: {
                from: "2022-12-12",
                to: "2022-12-12",
            },
            startTime: "12:00",
            endTime: "14:00",
            imageUrl: "https://via.placeholder.com/800x600",
        },
    ],
    requester: {
        name: "John Doe",
        identityNumber: "123456789",
        phoneNumber: "123456789",
        email: "sdjk@gmail.com",
        companyName: "Company",
        companyRole: "Role",
        academicUnit: "Unit",
    },
    state: "Pending",
    observations: "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
});

const audienceList = [
    {
        label: "Estudiantes",
        value: "Students",
    },
    {
        label: "Docentes",
        value: "Teachers",
    },
    {
        label: "Administrativos",
        value: "AdministrativeStaff",
    },
    {
        label: "Egresados",
        value: "Graduates",
    },
    {
        label: "Personal externo",
        value: "External",
    },
];
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
                            <p>{{ request.details }}</p>
                        </li>

                        <li class="space-y-3">
                            <p class="font-semibold">
                                <UsersRound class="inline" />
                                Público dirigido de la actividad
                            </p>
                            <div class="flex flex-wrap gap-5">
                                <Chip v-for="audience in request.audience">
                                    {{
                                        audienceList.find(
                                            (item) => item.value === audience,
                                        )?.label
                                    }}
                                </Chip>
                            </div>
                        </li>
                        <li
                            v-if="request.externalAudienceDetails"
                            class="space-y-3"
                        >
                            <template>
                                <p class="font-semibold">
                                    <UsersRound class="inline" />
                                    Detalle del personal externo
                                </p>
                                <p>{request.externalAudienceDetails}</p>
                            </template>
                        </li>
                        <li>
                            <p
                                class="font-semibold"
                                :class="{
                                    'text-neutral-300 dark:text-muted':
                                        !request.areMinorsIncluded,
                                }"
                            >
                                <Baby class="inline" />
                                Este evento
                                {{ request.areMinorsIncluded ? "sí" : "no" }}
                                contará con la presencia de menores de edad
                            </p>
                        </li>
                        <li>
                            <p
                                class="font-semibold"
                                :class="{
                                    'text-neutral-300 dark:text-muted':
                                        !request.areMinorsIncluded,
                                }"
                            >
                                <ReceiptText class="inline" />
                                Esta actividad
                                {{ request.areMinorsIncluded ? "sí" : "no" }}
                                se llevará acabo dentro del marco de un convenio
                                o contrato interadministrativo:
                                <a
                                    :href="request.agreementContractFilePath"
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
                                    {{ request.assistanceCount }}
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
                            v-for="appointment in request.appointments"
                            :key="appointment.spaceId"
                        >
                            <SelectedSpaceCard
                                :date="appointment.date"
                                :image-url="appointment.imageUrl"
                                :space-name="appointment.spaceName"
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
                                {{ request.requester.name }}
                            </li>

                            <li>
                                <Fingerprint class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">
                                    Numero de identificación:
                                </p>
                                : {{ request.requester.identityNumber }}
                            </li>

                            <li>
                                <Phone class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">Celular:</p>
                                {{ request.requester.phoneNumber }}
                            </li>

                            <li>
                                <Mail class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">
                                    Correo institucional:
                                </p>
                                <a :href="`mailto:${request.requester.email}`">
                                    {{ request.requester.email }}
                                </a>
                            </li>

                            <li>
                                <Building2 class="inline" />
                                <p class="inline font-semibold">
                                    Entidad o empresa:
                                </p>
                                {{ request.requester.companyName }}
                            </li>

                            <li>
                                <BriefcaseBusiness class="inline" />
                                {{ " " }}
                                <p class="inline font-semibold">Cargo:</p>
                                {{ request.requester.companyRole }}
                            </li>
                            <li>
                                <BriefcaseBusiness class="inline" />
                                <p class="inline font-semibold">
                                    Unidad académica:
                                </p>
                                {{ request.requester.academicUnit }}
                            </li>
                        </ul>
                    </div>
                </section>
                <section>
                    <ObservationForm v-if="request.state === 'Pending'" />
                    <BookingStateIndicator
                        v-else
                        :status="request.state as any"
                        :observations="request.observations"
                    />
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
