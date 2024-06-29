<script lang="ts" setup>
import { computed } from "vue";
import { UseImage } from "@vueuse/components";
import { useImage } from "@vueuse/core";

const props = defineProps<{
    title: string;
    imageSrc?: string;
    height?: number;
    width?: number;
}>();

const { isLoading, error, isReady } = useImage({ src: props.imageSrc ?? "" });

const spaceImage = computed(() => {
    return props.imageSrc || "https://via.placeholder.com/800x600";
});

const sizeClasses = computed(() => {
    return `h-${props.height} w-${props.width}`;
});
</script>

<template>
    <button class="size-full">
        <div>
            <div
                class="group relative max-h-64 cursor-pointer overflow-hidden rounded-md"
            >
                <img
                    :src="spaceImage"
                    :alt="props.title"
                    class="transform transition-transform group-hover:scale-105 aspect-square"
                    :height="props.height"
                    :width="props.width"
                    v-show="isReady"
                />

                <span
                    class="animate-pulse block bg-gray-200 aspect-square"
                    :class="sizeClasses"
                    v-show="isLoading"
                >
                </span>

                <span
                    v-show="error"
                    class="bg-red-500 block absolute"
                    :class="sizeClasses"
                ></span>
            </div>
        </div>
        <p class="mt-3 text-lg font-semibold truncate">{{ props.title }}</p>
    </button>
</template>
