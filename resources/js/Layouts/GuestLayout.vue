<script setup lang="ts">
import { BookMarked } from "lucide-vue-next";
</script>

<template>
    <div class="font-sans text-foreground bg-background">
        <div
            className="flex min-h-screen items-center justify-center font-sans"
        >
            <div className="flex min-h-screen w-full flex-col">
                <header
                    className="sticky top-0 z-10 flex h-16 w-full items-center gap-4 border-b bg-background px-4 md:px-6"
                >
                    <div
                        class="flex items-center gap-2 text-lg font-semibold md:text-base"
                    >
                        <BookMarked class="h-6 w-6" />
                        <span class="sr-only">CampusCal</span>
                    </div>
                </header>
                <main className="flex flex-1 flex-col gap-4 p-4 md:gap-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
