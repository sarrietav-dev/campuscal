<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import FormItem from "@/Components/FormItem.vue";
import { Button } from "@/Components/ui/button";
import FileInput from "@/Components/FileInput.vue";

const form = useForm<{
    name: string;
    images: FileList | null;
}>({
    name: "",
    images: null,
});

function handleSubmit() {
    form.post(route("spaces.store"));
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <form @submit.prevent="handleSubmit">
                <FormItem class="mb-4">
                    <Label for="name">Nombre del espacio</Label>
                    <Input id="name" type="text" v-model="form.name" />
                </FormItem>

                <FormItem class="mb-4">
                    <Label for="image">Imágenes</Label>
                    <FileInput
                        multiple
                        id="image"
                        type="file"
                        v-model="form.images"
                    />
                </FormItem>

                <div class="mb-4">
                    <Button type="submit">Crear</Button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
