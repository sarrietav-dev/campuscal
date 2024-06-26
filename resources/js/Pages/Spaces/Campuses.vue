<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SpaceCard from "@/Components/SpaceCard.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const spaces = defineProps<{
    campuses: {
        id: number;
        name: string;
        images: { path: string }[];
    }[];
}>();
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="space-y-5 sm:grid sm:grid-cols-2 sm:gap-5 sm:space-y-0 lg:grid-cols-3"
        >
            <Link
                v-for="campus in spaces.campuses"
                :href="`/campus/${campus.id}`"
            >
                <SpaceCard
                    :title="campus.name"
                    :key="campus.id"
                    :image-src="campus.images[0].path"
                />
            </Link>
        </div>
    </AuthenticatedLayout>
</template>
