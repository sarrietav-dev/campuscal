<script setup lang="ts">
import { Card, CardContent } from "@/Components/ui/card";
import { UseImage } from "@vueuse/components";

const props = defineProps<{
    image: string;
}>();
</script>

<template>
    <div class="p-1">
        <Card>
            <CardContent class="aspect-square p-0 relative">
                <UseImage
                    :src="props.image"
                    class="object-cover absolute size-full rounded-lg"
                    alt="Space image"
                    loading="lazy"
                >
                    <template #loading>
                        <span
                            class="animate-pulse bg-gray-200 absolute size-full"
                        ></span>
                    </template>
                    <template #error>
                        <span class="bg-red-500 absolute size-full"></span>
                    </template>
                </UseImage>
            </CardContent>
        </Card>
    </div>
</template>
