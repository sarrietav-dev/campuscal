<script lang="ts" setup>
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
        :class="{
            'font-bold':
                $page.component === 'Campus/Index' ||
                $page.component === 'Campus/Show' ||
                $page.component === 'Spaces/Show',
        }"
        :href="route('campuses.index')"
        class="text-muted-foreground transition-colors hover:text-foreground"
    >
        Espacios
    </Link>
    <Link
        :class="{ 'font-bold': $page.component === 'Booking/Index' }"
        :href="route('bookings.index')"
        class="text-muted-foreground transition-colors hover:text-foreground [&.active]:font-bold"
    >
        Solicitudes
    </Link>
    <Link
        v-if="$page.props.can.viewTeam"
        :class="{ 'font-bold': $page.component === 'Team/Index' }"
        :href="route('team.index')"
        class="text-muted-foreground transition-colors hover:text-foreground [&.active]:font-bold"
    >
        Equipo
    </Link>
</template>
