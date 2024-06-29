<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from "@/Components/ui/alert";
import { CircleX, CircleCheck } from "lucide-vue-next";

const props = defineProps<{
    status: "approved" | "rejected";
    observations?: string;
}>();
</script>

<template>
    <Alert>
        <CircleCheck v-if="props.status === 'approved'" class="size-5 mr-4" />
        <CircleX v-else class="size-5 mr-4" />

        <AlertTitle>
            {{
                status === "approved"
                    ? "Solicitud aprobada"
                    : "Solicitud rechazada"
            }}
        </AlertTitle>
        <AlertDescription>
            {{ observations ? observations : "Sin observaciones" }}
        </AlertDescription>
    </Alert>
</template>
