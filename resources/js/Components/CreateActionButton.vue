<script setup lang="ts">
import { Button } from "./ui/button";
</script>

<template>
    <Button v-if="$page.component === 'Spaces/Campuses'">
        Crear un campus
    </Button>
    <Button v-if="$page.component === 'Spaces/Campus'">Crear un espacio</Button>
</template>
