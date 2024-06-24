<script lang="ts" setup>
import { computed, ref } from "vue";

const props = defineProps<{
    title: string;
    imageSrc?: string;
}>();

const spaceImage = computed(() => {
    return props.imageSrc || "https://via.placeholder.com/800x600";
});

function handleClick() {
    console.log("Hey");
}
</script>

<template>
    <button class="size-full" @click="handleClick">
        <div>
            <div
                class="group relative max-h-64 cursor-pointer overflow-hidden rounded-md"
            >
                <img
                    :src="spaceImage"
                    height="600"
                    width="800"
                    :alt="props.title"
                    class="w-full h-auto transform object-cover bg-center transition-transform group-hover:scale-105"
                />
            </div>
        </div>
        <p class="mt-3 text-lg font-semibold">{{ props.title }}</p>
    </button>
</template>
