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
                <CardTitle>Confirm Password</CardTitle>
                <CardDescription>
                    This is a secure area of the application. Please confirm
                    your password before continuing.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit()" class="space-y-4">
                    <div class="space-y-2">
                        <Label htmlFor="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            placeholder="Enter your password"
                            required
                            v-model="form.password"
                        />
                        <ErrorMessage
                            v-show="form.errors.password"
                            class="mt-2"
                        >
                            {form.errors.password}
                        </ErrorMessage>
                    </div>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Confirm</Button
                    >
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
