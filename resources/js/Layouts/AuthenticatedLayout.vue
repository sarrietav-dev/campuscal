<script setup lang="ts">
import CreateActionButton from "@/Components/CreateActionButton.vue";
import Links from "@/Components/Links.vue";
import LogoutButton from "@/Components/LogoutButton.vue";
import ThemeToggle from "@/Components/ThemeToggle.vue";
import { Button } from "@/Components/ui/button";
import { Sheet, SheetContent, SheetTrigger } from "@/Components/ui/sheet";
import { Menu } from "lucide-vue-next";
import { Toaster } from "@/Components/ui/sonner";
</script>

<template>
    <Toaster />
    <div class="font-sans text-foreground bg-background">
        <div
            class="flex min-h-screen items-center justify-center font-sans"
        >
            <div class="flex min-h-screen w-full flex-col">
                <header
                    class="sticky top-0 z-10 flex h-16 w-full items-center gap-4 border-b bg-background px-4 md:px-6"
                >
                    <nav
                        class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6"
                    >
                        <Links />
                    </nav>
                    <Sheet>
                        <SheetTrigger asChild>
                            <Button
                                variant="outline"
                                size="icon"
                                class="shrink-0 md:hidden"
                            >
                                <Menu class="h-5 w-5" />
                                <span class="sr-only"
                                    >Toggle navigation menu</span
                                >
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left">
                            <nav class="grid gap-6 text-lg font-medium">
                                <Links />
                            </nav>
                        </SheetContent>
                        <div class="ml-auto flex items-center gap-5">
                            <CreateActionButton />
                            <ThemeToggle />
                            <LogoutButton />
                        </div>
                    </Sheet>
                </header>
                <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
