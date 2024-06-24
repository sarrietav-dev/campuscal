<script setup lang="ts">
import { cva, VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

const textVariants = cva("text-sm font-medium", {
    variants: {
        variant: {
            default: "leading-7 [&:not(:first-child)]:mt-6",
            heading1:
                "scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl",
            heading2:
                "scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0",
            heading3: "scroll-m-20 text-2xl font-semibold tracking-tight",
            heading4: "scroll-m-20 text-xl font-semibold tracking-tight",
        },
    },
    defaultVariants: {
        variant: "default",
    },
});

interface Props extends /* @vue-ignore */ VariantProps<typeof textVariants> {}

const props = defineProps<Props>();
</script>

<template>
    <p
        :class="
            cn(textVariants({ variant: props.variant }), $props.class as string)
        "
    >
        <slot />
    </p>
</template>
