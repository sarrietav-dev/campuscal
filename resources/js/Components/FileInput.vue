<script setup lang="ts">
import { useDark } from "@vueuse/core";

const props = defineProps<{
    multiple?: boolean;
    maxFiles?: number;
}>();

const modelValue = defineModel<FileList | null>();

const isDark = useDark();

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    modelValue.value = target.files;
}
</script>

<template>
    <input
        :data-dark="isDark"
        type="file"
        :multiple="props.multiple"
        @change="handleFileChange"
        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    />
</template>

<style scoped>
input[type="file"][data-dark="true"]::file-selector-button {
    color: white;
}

input[type="file"][data-dark="false"]::file-selector-button:hover {
    color: black;
}
</style>
