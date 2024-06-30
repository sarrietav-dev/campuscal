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
                    <h1 class="text-2xl font-bold">Thanks for signing up!</h1>
                    <p class="text-muted-foreground">
                        Before getting started, could you verify your email
                        address by clicking on the link we just emailed to you?
                        If you didn't receive the email, we will gladly send you
                        another.
                    </p>
                </div>
                <form @submit.prevent="submit()">
                    <Button class="w-full" :disabled="form.processing">
                        Resend verification email
                    </Button>
                </form>
                <div
                    v-if="verificationLinkSent"
                    class="text-center text-sm text-muted-foreground"
                >
                    A new verification link has been sent to the email address
                    you provided during registration.
                </div>
                <div class="text-center text-sm text-muted-foreground">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline hover:text-primary"
                        prefetch="{false}"
                    >
                        Logout
                    </Link>
                </div>
            </card>
        </div>
    </GuestLayout>
</template>
