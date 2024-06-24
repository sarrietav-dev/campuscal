<script setup lang="ts">
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";

const observations = defineModel<string>();

const emit = defineEmits(["reject", "approve"]);
</script>

<template>
    <form>
        <Label for="observations"> Observaciones </Label>
        <Textarea
            placeholder="Este comentario se va a adjuntar en la respuesta de la solicitud"
            v-model="observations"
            label="Observaciones"
            class="mt-2"
        />
        <div class="mt-5 flex justify-end gap-5">
            <Button type="button" @click="emit('reject')" variant="secondary">
                Rechazar solicitud
            </Button>
            <Button type="button" @click="emit('approve')">
                Aceptar solicitud
            </Button>
        </div>
    </form>
</template>
