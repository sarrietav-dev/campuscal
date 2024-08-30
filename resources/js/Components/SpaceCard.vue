<script lang="ts" setup>
import { computed } from "vue";
import { Trash } from "lucide-vue-next";
import { useImage } from "@vueuse/core";

const props = defineProps<{
    title: string;
    imageSrc?: string;
    height?: number;
    width?: number;
    deletable?: boolean;
}>();

const { isLoading, error, isReady } = useImage({ src: props.imageSrc ?? "" });

const emit = defineEmits(['delete', 'click']);

const spaceImage = computed(() => {
    return props.imageSrc || "https://via.placeholder.com/800x600";
});

const sizeClasses = computed(() => {
    return `h-${props.height} w-${props.width}`;
});
</script>

<template>
    <button class="relative group">
        <button
            v-if="deletable"
            @click="emit('delete')"
            class="invisible absolute -right-3 -top-3 z-10 flex size-7 scale-0 cursor-pointer items-center justify-center rounded-full border border-input bg-background text-foreground transition group-hover:visible group-hover:scale-100"
        >
            <Trash class="h-4 w-4" />
        </button>
        <div @click="emit('click')">
            <div
                class="group relative max-h-64 cursor-pointer overflow-hidden rounded-md"
            >
                <img
                    :src="spaceImage"
                    :alt="props.title"
                    class="transform transition-transform group-hover:scale-105 aspect-square object-cover w-full"
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
