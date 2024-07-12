<script lang="ts" setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Button } from "@/Components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import ErrorMessage from "@/Components/ErrorMessage.vue";

const form = useForm({
    name: "",
    email: route().params.email ?? "",
    password: "",
    role: route().params.role ?? undefined,
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Regístrate" />

        <Card class="w-full mx-auto max-w-md">
            <CardHeader>
                <CardTitle class="text-xl">
                    Regístrate en nuestra plataforma
                </CardTitle>
                <CardDescription>
                    Ingresa tus datos para crear una cuenta
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form class="grid gap-4" @submit.prevent="submit()">
                    <div class="grid gap-2">
                        <Label htmlFor="name">Nombre</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            placeholder="Max"
                            required
                        />
                        <ErrorMessage v-show="form.errors.name" class="mt-2">
                            {{ form.errors.name }}
                        </ErrorMessage>
                    </div>
                    <div v-if="!route().params.email" class="grid gap-2">
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            placeholder="m@example.com"
                            required
                            type="email"
                        />
                        <ErrorMessage v-show="form.errors.email" class="mt-2">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <Label htmlFor="password">Contraseña</Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                        />
                        <ErrorMessage
                            v-show="form.errors.password"
                            class="mt-2"
                        >
                            {{ form.errors.password }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <Label htmlFor="password_confirmation">
                            Confirma tu contraseña
                        </Label>
                        <Input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                        />
                        <ErrorMessage
                            v-show="form.errors.password_confirmation"
                            class="mt-2"
                        >
                            {{ form.errors.password_confirmation }}
                        </ErrorMessage>
                    </div>
                    <Button
                        :disabled="form.processing"
                        class="w-full"
                        type="submit"
                    >
                        Regístrate
                    </Button>
                    <Button
                        as-child
                        class="w-full"
                        type="button"
                        variant="outline"
                    >
                        <a href="/auth/redirect">Entrar con Google</a>
                    </Button>
                </form>
                <div class="mt-4 text-center text-sm">
                    ¿Ya tienes una cuenta?
                    <Link :href="route('login')" class="underline">
                        Iniciar sesión
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
