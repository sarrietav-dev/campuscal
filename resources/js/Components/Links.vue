<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { BookMarked } from "lucide-vue-next";
</script>

<template>
    <Link
        :href="route('dashboard')"
        class="flex items-center gap-2 text-lg font-semibold md:text-base"
    >
        <BookMarked class="h-6 w-6" />
        <span class="sr-only">CampusCal</span>
    </Link>
    <Link
        :href="route('campuses.index')"
        class="text-muted-foreground transition-colors hover:text-foreground"
        :class="{
            'font-bold':
                $page.component === 'Spaces/Campuses' ||
                $page.component === 'Spaces/Campus' ||
                $page.component === 'Spaces/Space',
        }"
    >
        Espacios
    </Link>
    <Link
        :href="route('bookings.index')"
        class="text-muted-foreground transition-colors hover:text-foreground [&.active]:font-bold"
        :class="{ 'font-bold': $page.component === 'Booking/Bookings' }"
    >
        Solicitudes
    </Link>
</template>
