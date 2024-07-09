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
    images: File[];
}>({
    name: "",
    images: [],
});

function handleSubmit() {
    console.log(form);
    form.post(route("campuses.store"));
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container">
            <form @submit.prevent="handleSubmit">
                <FormItem class="mb-4">
                    <Label for="name">Nombre del campus</Label>
                    <Input id="name" type="text" v-model="form.name" />
                    <p
                        v-show="form.errors.name"
                        class="text-red-500 text-xs italic"
                    >
                        {{ form.errors.name }}
                    </p>
                </FormItem>

                <FormItem class="mb-4">
                    <Label for="image">Imagen</Label>
                    <FileInput id="image" type="file" v-model="form.images" />
                    <p
                        v-show="form.errors.images"
                        class="text-red-500 text-xs italic"
                    >
                        {{ form.errors.images }}
                    </p>
                </FormItem>

                <div class="mb-4">
                    <Button type="submit">Crear</Button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
input[type="file"][data-dark="true"]::file-selector-button {
    color: white;
}

input[type="file"][data-dark="false"]::file-selector-button:hover {
    color: black;
}
</style>
