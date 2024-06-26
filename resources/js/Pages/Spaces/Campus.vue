<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import SpaceCard from "@/Components/SpaceCard.vue";

const spaces = defineProps<{
    spaces: {
        id: number;
        name: string;
        images: { path: string }[];
    }[];
}>();
</script>

<template>
    <AuthenticatedLayout>
        <div>
            <div
                class="space-y-5 sm:grid sm:grid-cols-2 sm:gap-5 sm:space-y-0 lg:grid-cols-3"
            >
                <Link
                    v-for="space in spaces.spaces"
                    :href="`/spaces/${space.id}`"
                >
                    <SpaceCard
                        :title="space.name"
                        :key="space.id"
                        :image-src="space.images[0].path"
                    />
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
