<script setup lang="ts">
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
    email: "",
    password: "",
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
        <Head title="Register" />

        <Card class="w-full mx-auto max-w-md">
            <CardHeader>
                <CardTitle class="text-xl">Sign Up</CardTitle>
                <CardDescription>
                    Enter your information to create an account
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit()" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label htmlFor="name">Name</Label>
                        <Input
                            id="name"
                            placeholder="Max"
                            required
                            v-model="form.name"
                        />
                        <ErrorMessage v-show="form.errors.name" class="mt-2">
                            {{ form.errors.name }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <Label htmlFor="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            placeholder="m@example.com"
                            required
                            v-model="form.email"
                        />
                        <ErrorMessage v-show="form.errors.email" class="mt-2">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <Label htmlFor="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            v-model="form.password"
                        />
                        <ErrorMessage
                            v-show="form.errors.password"
                            class="mt-2"
                        >
                            {{ form.errors.password }}
                        </ErrorMessage>
                    </div>
                    <div class="grid gap-2">
                        <Label htmlFor="password_confirmation"
                            >Confirm Password</Label
                        >
                        <Input
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                        />
                        <ErrorMessage
                            v-show="form.errors.password_confirmation"
                            class="mt-2"
                        >
                            {{ form.errors.password_confirmation }}
                        </ErrorMessage>
                    </div>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Create an account
                    </Button>
                    <Button
                        as-child
                        variant="outline"
                        class="w-full"
                        type="button"
                    >
                        <a href="/auth/redirect"> Login with Google </a>
                    </Button>
                </form>
                <div class="mt-4 text-center text-sm">
                    Already have an account?
                    <Link :href="route('login')" class="underline">
                        Sign in
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
