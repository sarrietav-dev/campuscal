<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";

export interface BookingProps {
    bookings: {
        assistance: number;
        created_at: Date;
        details: string;
        id: number;
        requester: {
            booking_id: number;
            email: string;
            id: number;
            name: string;
            surname: string;
        };
        status: "approved" | "pending" | "rejected";
    }[];
}

const props = defineProps<BookingProps>();
</script>

<template>
    <AuthenticatedLayout>
        <DataTable :bookings="props.bookings" />
    </AuthenticatedLayout>
</template>

<style scoped></style>
