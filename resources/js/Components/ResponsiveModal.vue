<script setup lang="ts">
import { useMediaQuery } from "@vueuse/core";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
import { Drawer, DrawerContent, DrawerTrigger } from "@/Components/ui/drawer";
import { createReusableTemplate } from "@vueuse/core";

const [DefineTemplate, ReuseTemplate] = createReusableTemplate();

const isDesktop = useMediaQuery("(min-width: 1024px)");
</script>

<template>
    <DefineTemplate>
        <slot />
    </DefineTemplate>
    <Dialog v-if="isDesktop">
        <DialogTrigger as-child>
            <slot name="trigger" />
        </DialogTrigger>
        <DialogContent>
            <DialogTitle>
                <slot name="title" />
            </DialogTitle>
            <ReuseTemplate />
        </DialogContent>
    </Dialog>
    <Drawer v-else>
        <DrawerTrigger as-child>
            <slot name="trigger" />
        </DrawerTrigger>
        <DrawerContent>
            <ReuseTemplate />
        </DrawerContent>
    </Drawer>
</template>
