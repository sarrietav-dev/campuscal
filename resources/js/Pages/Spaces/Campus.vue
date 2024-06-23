<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
    id: number;
}>();
</script>

<template>
    <div>
        <h1>Campus {{ propsl.id }}</h1>
    </div>
</template>
