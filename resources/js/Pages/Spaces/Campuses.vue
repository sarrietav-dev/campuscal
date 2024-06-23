<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
    id: number;
}>();
</script>

<template>
    <AuthenticatedLayout>
        <h1>Campus {{ props.id }}</h1>
    </AuthenticatedLayout>
</template>
