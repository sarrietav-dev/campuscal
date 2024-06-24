<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import SpaceCard from "@/Components/SpaceCard.vue";

const props = defineProps<{
    id: number;
}>();

const spaces = ref([
    {
        id: 1,
        title: "Campus 1",
        imageSrc: "https://picsum.photos/600/800",
    },
    {
        id: 2,
        title: "Campus 2",
        imageSrc: "https://picsum.photos/600/800",
    },
    {
        id: 3,
        title: "Campus 3",
        imageSrc: "https://picsum.photos/600/800",
    },
    {
        id: 4,
        title: "Campus 4",
        imageSrc: "https://picsum.photos/600/800",
    },
    {
        id: 5,
        title: "Campus 5",
        imageSrc: "https://picsum.photos/600/800",
    },
]);
</script>

<template>
    <AuthenticatedLayout>
        <div>
            <div
                class="space-y-5 sm:grid sm:grid-cols-2 sm:gap-5 sm:space-y-0 lg:grid-cols-3"
            >
                <Link v-for="campus in spaces" :href="`/space/${campus.id}`">
                    <SpaceCard
                        :title="campus.title"
                        :key="campus.id"
                        :image-src="campus.imageSrc"
                    />
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
