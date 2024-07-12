<script setup lang="ts">
import { BookMarked } from "lucide-vue-next";
import ThemeToggle from "@/Components/ThemeToggle.vue";
import { Button } from "@/Components/ui/button";
import { LogInIcon } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/Components/ui/tooltip";
import LogoutButton from "@/Components/LogoutButton.vue";
import Logo from "@/Components/Logo.vue";
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
                        <Logo />
                        <span class="sr-only">CampusCal</span>
                    </div>
                    <div className="ml-auto flex items-center gap-5">
                        <ThemeToggle />
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <Button
                                        as-child
                                        variant="outline"
                                        size="icon"
                                    >
                                        <logout-button
                                            v-if="$page.props.auth.user"
                                        />
                                        <Link v-else :href="route('login')">
                                            <LogInIcon class="h-6 w-6" />
                                        </Link>
                                    </Button>
                                </TooltipTrigger>
                                <TooltipContent>
                                    {{
                                        $page.props.auth.user
                                            ? "Cerrar sesión"
                                            : "Iniciar sesión"
                                    }}
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </div>
                </header>
                <main className="flex flex-1 flex-col gap-4 p-4 md:gap-8">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
