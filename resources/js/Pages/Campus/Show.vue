<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import SpaceCard from "@/Components/SpaceCard.vue";

const spaces = defineProps<{
    spaces: {
        id: number;
        name: string;
        image: string;
    }[];
}>();
</script>

<template>
    <Head title="Campus" />
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
                        :key="space.id"
                        :image-src="space.image"
                        :title="space.name"
                    />
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
