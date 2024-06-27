<script setup lang="ts">
import { Button } from "./ui/button";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Button v-if="$page.component === 'Spaces/Campuses'">
        <Link :href="route('campuses.create')" as="button">
            Crear un campus
        </Link>
    </Button>
    <Button as-child v-if="$page.component === 'Spaces/Campus'">
        <Link :href="route('spaces.create')" as="button">
            Crear un espacio
        </Link>
    </Button>
</template>
