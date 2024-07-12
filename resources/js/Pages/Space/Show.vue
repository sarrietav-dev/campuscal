<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import { Card, CardContent } from "@/Components/ui/card";
import CarouselImage from "@/Components/CarouselImage.vue";

const props = defineProps<{
    space: {
        id: number;
        name: string;
        images: { url: string }[];
        resources: { name: string }[];
        campus_id: number;
        capacity: string;
    };
}>();
</script>

<template>
    <Head :title="space.name" />
    <AuthenticatedLayout>
        <div class="lg:grid lg:grid-cols-2 lg:gap-5">
            <div class="px-12 lg:px-5">
                <Carousel class="mx-auto max-w-full lg:max-w-lg">
                    <CarouselContent>
                        <template v-if="props.space.images.length > 0">
                            <CarouselItem
                                v-for="image in props.space.images"
                                :key="image.url"
                            >
                                <CarouselImage :image="image.url" />
                            </CarouselItem>
                        </template>
                        <CarouselItem v-else>
                            <div class="p-1">
                                <Card>
                                    <CardContent
                                        class="flex aspect-square items-center justify-center p-6"
                                    >
                                        <img
                                            src="https://picsum.photos/300/300"
                                            alt="Space image"
                                            class="object-contain absolute size-full"
                                        />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>
            </div>
            <div>
                <h2>{{ props.space.name }}</h2>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
