<script setup lang="ts">
import {useColorMode} from "@vueuse/core";
import {computed} from "vue";

const mode = useColorMode();
const image = computed(() => mode.value === 'dark' ? '/images/logo-dark.png' : '/images/logo-light.png');
</script>

<template>
    <img class="max-w-28 h-auto" :src="image" alt="Institutional logo">
</template>

<style scoped>

</style>
