<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { BookMarked } from "lucide-vue-next";
</script>

<template>
    <Link
        :href="route('dashboard')"
        className="flex items-center gap-2 text-lg font-semibold md:text-base"
    >
        <BookMarked className="h-6 w-6" />
        <span className="sr-only">CampusCal</span>
    </Link>
    <Link
        :href="route('campus')"
        className="text-muted-foreground transition-colors hover:text-foreground"
        :class="{ 'font-bold': $page.component === 'Spaces/Campuses' }"
    >
        Espacios
    </Link>
    <Link
        href="/admin/requests"
        className="text-muted-foreground transition-colors hover:text-foreground [&.active]:font-bold"
        :class="{ 'font-bold': $page.component === 'Admin/Requests' }"
    >
        Solicitudes
    </Link>
</template>
