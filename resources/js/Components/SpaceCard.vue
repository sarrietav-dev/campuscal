<script lang="ts" setup>
import { computed, ref } from "vue";
import { UseImage } from "@vueuse/components";

const props = defineProps<{
    title: string;
    imageSrc?: string;
}>();

const spaceImage = computed(() => {
    return props.imageSrc || "https://via.placeholder.com/800x600";
});
</script>

<template>
    <button class="size-full">
        <div>
            <div
                class="group relative max-h-64 cursor-pointer overflow-hidden rounded-md"
            >
                <UseImage
                    :src="spaceImage"
                    :alt="props.title"
                    class="transform transition-transform group-hover:scale-105 w-full"
                >
                    <template #loading>
                        <span
                            class="animate-pulse block bg-gray-200 w-full h-64"
                        >
                        </span>
                    </template>
                    <template #error>
                        <span class="bg-red-500 absolute size-full"></span>
                    </template>
                </UseImage>
            </div>
        </div>
        <p class="mt-3 text-lg font-semibold">{{ props.title }}</p>
    </button>
</template>
