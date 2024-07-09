<script lang="ts" setup>
import { Button } from "./ui/button";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Button v-if="$page.component === 'Campus/Index'">
        <Link :href="route('campuses.create')" as="button">
            Crear un campus
        </Link>
    </Button>
    <Button v-if="$page.component === 'Campus/Show'" as-child>
        <Link
            :href="
                route('campuses.spaces.create', {
                    campus: route().params.campus,
                })
            "
            as="button"
        >
            Crear un espacio
        </Link>
    </Button>
</template>
