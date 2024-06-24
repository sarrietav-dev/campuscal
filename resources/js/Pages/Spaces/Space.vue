<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
    id: number;
}>();
</script>

<template>
    <AuthenticatedLayout>
        <h1>space {{ props.id }}</h1>
    </AuthenticatedLayout>
</template>
