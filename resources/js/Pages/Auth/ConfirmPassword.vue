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
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";
import ErrorMessage from "@/Components/ErrorMessage.vue";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <Card class="mx-auto max-w-sm">
            <CardHeader>
                <CardTitle>Confirma tu contraseña</CardTitle>
                <CardDescription>
                    Esta es un área segura de la aplicación. Por favor confirma
                    tu contraseña antes de continuar.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit()" class="space-y-4">
                    <div class="space-y-2">
                        <Label htmlFor="password">Contraseña</Label>
                        <Input
                            id="password"
                            type="password"
                            placeholder="Ingresa tu contraseña"
                            required
                            v-model="form.password"
                        />
                        <ErrorMessage
                            v-show="form.errors.password"
                            class="mt-2"
                        >
                            {{ form.errors.password }}
                        </ErrorMessage>
                    </div>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Confirmar
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
