<script setup lang="ts">
import { cva, VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";
import { computed } from "vue";

interface Props {
    variant?: "heading1" | "heading2" | "heading3" | "heading4";
}

const props = defineProps<Props>();

const classes = {
    "scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0":
        props.variant === "heading2",
    "scroll-m-20 text-2xl font-semibold tracking-tight":
        props.variant === "heading3",
    "scroll-m-20 text-xl font-semibold tracking-tight":
        props.variant === "heading4",
    "leading-7 [&:not(:first-child)]:mt-6": !props.variant,
};
</script>

<template>
    <p :class="classes">
        <slot />
    </p>
</template>
