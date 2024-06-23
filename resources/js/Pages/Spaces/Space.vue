<script setup lang="ts">
const props = defineProps<{
    id: number;
}>();
</script>

<template>
    <h1>space {{ props.id }}</h1>
</template>
