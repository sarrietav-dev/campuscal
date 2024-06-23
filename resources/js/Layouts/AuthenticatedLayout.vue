<script setup lang="ts">
import Links from "@/Components/Links.vue";
import ThemeToggle from "@/Components/ThemeToggle.vue";
import { Button } from "@/Components/ui/button";
import { Sheet, SheetContent, SheetTrigger } from "@/Components/ui/sheet";
import { Menu } from "lucide-vue-next";
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
                    <nav
                        className="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6"
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
                                <Menu className="h-5 w-5" />
                                <span className="sr-only"
                                    >Toggle navigation menu</span
                                >
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left">
                            <nav className="grid gap-6 text-lg font-medium">
                                <Links />
                            </nav>
                        </SheetContent>
                        <div className="ml-auto flex items-center gap-5">
                            <CreateActionButton />
                            <ThemeToggle />
                            <LogoutButton />
                        </div>
                    </Sheet>
                </header>
                <main className="flex flex-1 flex-col gap-4 p-4 md:gap-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
