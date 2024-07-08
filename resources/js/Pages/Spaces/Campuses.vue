<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SpaceCard from "@/Components/SpaceCard.vue";
import { Link } from "@inertiajs/vue3";

const spaces = defineProps<{
    campuses: {
        id: number;
        name: string;
        image: string;
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
                :href="`/campuses/${campus.id}`"
            >
                <SpaceCard
                    :key="campus.id"
                    :image-src="campus.image"
                    :title="campus.name"
                />
            </Link>
        </div>
    </AuthenticatedLayout>
</template>
