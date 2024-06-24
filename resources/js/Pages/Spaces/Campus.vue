<script setup lang="ts">

const props = defineProps<{
    id: number;
}>();
</script>

<template>
    <div>
        <h1>Campus {{ props.id }}</h1>
    </div>
</template>
