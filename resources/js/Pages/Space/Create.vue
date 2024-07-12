<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm, Head } from "@inertiajs/vue3";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import FormItem from "@/Components/FormItem.vue";
import { Button } from "@/Components/ui/button";
import FileInput from "@/Components/FileInput.vue";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import { computed } from "vue";

const props = defineProps<{
    campus: string;
}>();

const form = useForm({
    name: "",
    images: [],
    campus_id: props.campus,
    capacity: 0,
});

function handleSubmit() {
    form.post(
        route("campuses.spaces.store", {
            campus: props.campus,
        }),
    );
}

const hasImageErrors = computed(() => {
    return Object.keys(form.errors).some((key) => key.startsWith("images."));
});
</script>

<template>
    <Head title="Crear espacio" />
    <AuthenticatedLayout>
        <div class="container">
            <form @submit.prevent="handleSubmit">
                <FormItem class="mb-4">
                    <Label for="name">Nombre del espacio</Label>
                    <Input id="name" type="text" v-model="form.name" />
                    <ErrorMessage v-show="form.errors.name">
                        {{ form.errors.name }}
                    </ErrorMessage>
                </FormItem>

                <FormItem class="mb-4">
                    <Label for="capacity">Capacidad</Label>
                    <Input
                        id="capacity"
                        type="text"
                        v-model.number="form.capacity"
                    />
                    <ErrorMessage v-show="form.errors.capacity">
                        {{ form.errors.capacity }}
                    </ErrorMessage>
                </FormItem>

                <FormItem class="mb-4">
                    <Label for="image">Imágenes</Label>
                    <FileInput
                        multiple
                        id="image"
                        type="file"
                        v-model="form.images"
                    />
                    <ErrorMessage v-show="form.errors.images">
                        {{ form.errors.images }}
                    </ErrorMessage>
                    <ErrorMessage v-show="hasImageErrors">
                        Al menos una imagen es requerida.
                    </ErrorMessage>
                </FormItem>

                <div class="mb-4">
                    <Button type="submit">Crear</Button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
