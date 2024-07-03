<script setup lang="ts">
import { computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Button } from "@/Components/ui/button";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { Card } from "@/Components/ui/card";

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent",
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div
            class="flex flex-col items-center justify-center bg-background p-6 sm:p-10"
        >
            <card
                class="mx-auto w-full max-w-md space-y-4 rounded-lg bg-card p-6 shadow-lg sm:p-8"
            >
                <div class="space-y-2 text-center">
                    <h1 class="text-2xl font-bold">Gracias por registrarte!</h1>
                    <p class="text-muted-foreground">
                        Antes de comenzar, ¿podrías verificar tu dirección de
                        correo electrónico haciendo clic en el enlace que
                        acabamos de enviarte por correo electrónico? Si no
                        recibiste el correo electrónico, con gusto te enviaremos
                        otro.
                    </p>
                </div>
                <form @submit.prevent="submit()">
                    <Button class="w-full" :disabled="form.processing">
                        Reenviar correo de verificación
                    </Button>
                </form>
                <div
                    v-if="verificationLinkSent"
                    class="text-center text-sm text-muted-foreground"
                >
                    Se ha enviado un nuevo enlace de verificación a la dirección
                    de correo electrónico que proporcionaste durante el
                    registro.
                </div>
                <div class="text-center text-sm text-muted-foreground">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline hover:text-primary"
                        prefetch="{false}"
                    >
                        Cerrar sesión
                    </Link>
                </div>
            </card>
        </div>
    </GuestLayout>
</template>
