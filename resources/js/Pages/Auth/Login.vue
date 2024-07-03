<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { Checkbox } from "@/Components/ui/checkbox";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <Head title="Log in" />

    <GuestLayout>
        <Card class="mx-auto w-full max-w-md">
            <CardHeader>
                <CardTitle class="text-2xl"> Bienvenido de vuelta</CardTitle>
                <CardDescription>
                    Ingrese su correo electrónico a continuación para iniciar
                    sesión en su cuenta
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-green-600"
                >
                    {{ status }}
                </div>
                <form @submit.prevent="submit()" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            placeholder="m@example.com"
                            v-model="form.email"
                            required
                        />
                        <ErrorMessage v-show="form.errors.email" class="mt-2">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label htmlFor="password">Contraseña</Label>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="ml-auto inline-block text-sm underline"
                            >
                                ¿Olvidó su contraseña?
                            </Link>
                        </div>
                        <Input
                            id="password"
                            type="password"
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
                    <div className="flex items-center justify-between gap-10">
                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="remember-me"
                                v-model="form.remember"
                            />
                            <Label
                                htmlFor="remember-me"
                                class="text-sm font-medium"
                            >
                                Recuérdame
                            </Label>
                        </div>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="w-auto grow"
                        >
                            Iniciar sesión
                        </Button>
                    </div>
                    <Button
                        as-child
                        variant="outline"
                        class="w-full"
                        type="button"
                    >
                        <a href="/auth/redirect">Entrar con Google</a>
                    </Button>
                </form>
                <div class="mt-4 text-center text-sm">
                    ¿No tienes una cuenta?
                    <Link :href="route('register')" class="underline">
                        Regístrate
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
