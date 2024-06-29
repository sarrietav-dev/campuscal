<script setup lang="ts">
import { Textarea } from "@/Components/ui/textarea";
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    observations: "",
});

function approve() {
    form.patch(route("bookings.approve", { booking: route().params.booking }), {
        preserveScroll: true,
    });
}

function reject() {
    form.patch(route("bookings.reject", { booking: route().params.booking }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <form>
        <Label for="observations"> Observaciones </Label>
        <Textarea
            placeholder="Este comentario se va a adjuntar en la respuesta de la solicitud"
            v-model="form.observations"
            label="Observaciones"
            class="mt-2"
        />
        <div class="mt-5 flex justify-end gap-5">
            <Button type="button" @click="reject()" variant="secondary">
                Rechazar solicitud
            </Button>
            <Button type="button" @click="approve()"> Aceptar solicitud</Button>
        </div>
    </form>
</template>
