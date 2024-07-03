<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Input } from "@/Components/ui/input";
import { Head, useForm } from "@inertiajs/vue3";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import ErrorMessage from "@/Components/ErrorMessage.vue";

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <Card class="w-full max-w-md mx-auto">
            <CardHeader>
                <CardTitle>Cambiar contraseña</CardTitle>
                <CardDescription>
                    Ingresa tu correo electrónico y una nueva contraseña para
                    restablecer la contraseña de tu cuenta.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit()" class="space-y-4">
                    <div class="space-y-2">
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            placeholder="m@example.com"
                            v-model="form.email"
                            required
                        />
                        <ErrorMessage class="mt-2" v-show="form.errors.email">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>
                    <div class="space-y-2">
                        <Label htmlFor="newPassword">Nueva contraseña</Label>
                        <Input
                            id="newPassword"
                            type="password"
                            placeholder="Ingresa tu nueva contraseña"
                            v-model="form.password"
                            required
                        />
                        <ErrorMessage
                            class="mt-2"
                            v-show="form.errors.password"
                        >
                            {{ form.errors.password }}
                        </ErrorMessage>
                    </div>
                    <div class="space-y-2">
                        <Label htmlFor="confirmPassword">
                            Confirmar contraseña
                        </Label>
                        <Input
                            id="confirmPassword"
                            type="password"
                            placeholder="Confirma tu nueva contraseña"
                            v-model="form.password_confirmation"
                            required
                        />
                        <ErrorMessage
                            class="mt-2"
                            v-show="form.errors.password_confirmation"
                        >
                            {{ form.errors.password_confirmation }}
                        </ErrorMessage>
                    </div>
                </form>
            </CardContent>
            <CardFooter>
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full"
                >
                    Cambiar contraseña
                </Button>
            </CardFooter>
        </Card>
    </GuestLayout>
</template>
