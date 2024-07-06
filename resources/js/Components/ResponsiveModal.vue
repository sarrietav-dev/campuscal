<script setup lang="ts">
import { useMediaQuery } from "@vueuse/core";
import {
    Dialog,
    DialogContent,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from "./ui/dialog";
import {
    Drawer,
    DrawerContent,
    DrawerFooter,
    DrawerTrigger,
} from "@/Components/ui/drawer";
import { createReusableTemplate } from "@vueuse/core";

const [DefineTemplate, ReuseTemplate] = createReusableTemplate();

const isDesktop = useMediaQuery("(min-width: 640px)");

const props = defineProps<{
    open?: boolean;
    class?: string;
}>();

const emit = defineEmits<{
    "update:open": [boolean];
}>();

defineSlots<{
    default: void;
    trigger: void;
    title: void;
    footer: void;
}>();
</script>

<template>
    <DefineTemplate>
        <slot />
    </DefineTemplate>
    <Dialog
        :open="props.open"
        @update:open="emit('update:open', $event)"
        v-if="isDesktop"
    >
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>
        <DialogContent :class="props.class">
            <DialogTitle>
                <slot name="title" />
            </DialogTitle>
            <ReuseTemplate />
            <DialogFooter>
                <slot name="footer" />
            </DialogFooter>
        </DialogContent>
    </Dialog>
    <Drawer
        :open="props.open"
        @update:open="emit('update:open', $event)"
        v-else
    >
        <DrawerTrigger as-child>
            <slot name="trigger" />
        </DrawerTrigger>
        <DrawerContent class="max-h-[95%]" :class="props.class">
            <ReuseTemplate />
            <DrawerFooter>
                <slot name="footer" />
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
