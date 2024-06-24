<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from "@/Components/ui/carousel";
import { Card, CardContent } from "@/Components/ui/card";
import { ref } from "vue";

const props = defineProps<{
    id: number;
}>();

const images = ref<string[]>([
    "https://picsum.photos/500/500",
    "https://picsum.photos/500/500",
    "https://picsum.photos/500/500",
]);
</script>

<template>
    <AuthenticatedLayout>
        <div class="lg:grid lg:grid-cols-2 lg:gap-5">
            <div class="px-12 lg:px-5">
                <Carousel class="mx-auto max-w-full lg:max-w-lg">
                    <CarouselContent>
                        <template v-if="images.length > 0">
                            <CarouselItem v-for="image in images" :key="image">
                                <div class="p-1">
                                    <Card>
                                        <CardContent
                                            class="aspect-square p-0 relative"
                                        >
                                            <img
                                                :src="image"
                                                alt="Space image"
                                                class="object-contain absolute inset-0 size-full rounded-lg"
                                            />
                                        </CardContent>
                                    </Card>
                                </div>
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
                <h2>Page {{ props.id }}</h2>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
