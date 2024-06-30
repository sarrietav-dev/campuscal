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
    <GuestLayout>
        <Head title="Log in" />
        <Card class="mx-auto w-full max-w-md">
            <CardHeader>
                <CardTitle class="text-2xl">Login</CardTitle>
                <CardDescription>
                    Enter your email below to login to your account
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
                            <Label htmlFor="password">Password</Label>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="ml-auto inline-block text-sm underline"
                            >
                                Forgot your password?
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
                                Remember me
                            </Label>
                        </div>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="w-auto grow"
                        >
                            Login
                        </Button>
                    </div>
                    <Button variant="outline" class="w-full">
                        Login with Google
                    </Button>
                </form>
                <div class="mt-4 text-center text-sm">
                    Don&apos;t have an account?
                    <Link :href="route('register')" class="underline">
                        Sign up
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
