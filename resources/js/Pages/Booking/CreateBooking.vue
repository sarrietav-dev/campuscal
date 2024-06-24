<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    details: "",
});
</script>

<template>
    <AuthenticatedLayout> </AuthenticatedLayout>
</template>
