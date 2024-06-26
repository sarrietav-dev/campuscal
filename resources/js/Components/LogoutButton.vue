<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import { LogOut } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link :href="route('logout')" method="post">
        <Button variant="outline" size="icon">
            <LogOut className="h-5 w-5" />
        </Button>
    </Link>
</template>
