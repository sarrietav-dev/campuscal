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
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import CarouselImage from "@/Components/CarouselImage.vue";
import { Button } from "@/Components/ui/button";
import { Link } from "@inertiajs/vue3";

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
        <div class="lg:grid lg:grid-cols-2 flex flex-col gap-5">
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
            <div class="lg:flex lg:flex-col lg:justify-center">
                <Card>
                    <CardHeader>
                        <div class="flex justify-between">
                            <div>
                                <CardTitle>
                                    {{ props.space.name }}
                                </CardTitle>
                                <CardDescription>
                                    Capacidad: {{ props.space.capacity }}
                                </CardDescription>
                            </div>
                            <Link
                                :href="
                                    route('spaces.edit', { space: space.id })
                                "
                            >
                                <Button>{{ $t('Edit')}}</Button>
                            </Link>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div class="flex flex-col space-y-2">
                            <div v-if="props.space.resources.length > 0">
                                <h3 class="text-lg font-semibold">Recursos</h3>
                                <ul class="list-disc list-inside">
                                    <li
                                        v-for="resource in props.space
                                            .resources"
                                        :key="resource.name"
                                    >
                                        {{ resource.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
