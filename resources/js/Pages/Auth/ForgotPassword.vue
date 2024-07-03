<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Input } from "@/Components/ui/input";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import ErrorMessage from "@/Components/ErrorMessage.vue";

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <Card class="w-full max-w-md mx-auto justify-self-center">
            <CardHeader>
                <CardTitle>¿Olvidate tu contraseña?</CardTitle>
                <CardDescription>
                    Ingresa tu dirección de correo electrónico a continuación y
                    te enviaremos un enlace para restablecer tu contraseña.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit()" class="space-y-4">
                    <div>
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            placeholder="example@email.com"
                            v-model="form.email"
                            required
                        />
                        <ErrorMessage class="mt-2" :show="form.errors.email">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Cambiar contraseña
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
