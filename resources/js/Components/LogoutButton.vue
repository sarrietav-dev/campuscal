<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import { LogOut } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Button as-child variant="outline" size="icon">
        <Link :href="route('logout')" method="post" as="button">
            <LogOut className="h-5 w-5" />
        </Link>
    </Button>
</template>
