<script setup lang="ts">
import { useMediaQuery } from "@vueuse/core";
import { Dialog, DialogContent, DialogTitle, DialogTrigger } from "./ui/dialog";
import { Drawer, DrawerContent, DrawerTrigger } from "@/Components/ui/drawer";
import { createReusableTemplate } from "@vueuse/core";

const [DefineTemplate, ReuseTemplate] = createReusableTemplate();

const isDesktop = useMediaQuery("(min-width: 768px)");
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
        <DrawerContent class="max-h-[95%]">
            <ReuseTemplate />
        </DrawerContent>
    </Drawer>
</template>
