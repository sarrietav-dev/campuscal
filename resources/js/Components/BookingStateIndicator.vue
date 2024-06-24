<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from "@/Components/ui/alert";
import { CircleX, CircleCheck } from "lucide-vue-next";

const props = defineProps<{
    status: "Approved" | "Rejected";
    observations?: string;
}>();
</script>

<template>
    <Alert>
        <CircleCheck v-if="props.status === 'Approved'" className="h-4 w-4" />
        <CircleX v-else className="h-4 w-4" />

        <AlertTitle>
            {{
                status === "Approved"
                    ? "Solicitud aprobada"
                    : "Solicitud rechazada"
            }}
        </AlertTitle>
        <AlertDescription>
            {{ observations ? observations : "Sin observaciones" }}
        </AlertDescription>
    </Alert>
</template>
