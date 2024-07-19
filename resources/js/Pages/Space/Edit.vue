<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import FileInput from "@/Components/FileInput.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import FormItem from "@/Components/FormItem.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import { UseImage } from "@vueuse/components";
import { computed } from "vue";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";
import { AlertDescription } from "@/Components/ui/alert";
import { toast } from "vue-sonner";
import { trans } from "laravel-vue-i18n";

const props = defineProps<{
    space: {
        id: number;
        name: string;
        capacity: number;
        resources: unknown[];
        images: {
            id: number;
            url: string;
        }[];
    };
}>();

const form = useForm({
    name: props.space.name,
    images: [],
    space_id: props.space.id,
    capacity: props.space.capacity,
});

function handleSubmit() {
    router.post(
        route("spaces.update", {
            space: props.space,
        }),
        {
            _method: "put",
            name: form.name,
            capacity: form.capacity,
            images: form.images,
        },
    );
}

function handleImageDelete(imageId: number) {
    router.delete(
        route("images.destroy", {
            space: props.space.id,
            image: imageId,
        }),
        {
            onError: () => {
                toast.error("Hubo un error al eliminar la imagen");
            },
            onSuccess: () => {
                toast.success(
                    trans("Successfully deleted :thing", {
                        thing: "imagen",
                    }),
                );
            },
        },
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
                    <Label for="image">Nuevas imágenes</Label>
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

                <FormItem class="flex-row">
                    <div
                        v-for="image in space.images"
                        class="flex items-center justify-between max-w-xs px-3 py-2 rounded-md bg-accent"
                    >
                        <UseImage class="rounded size-14" :src="image.url">
                            <template #loading>
                                <div
                                    class="bg-gray-200 rounded-lg animate-pulse size-12 aspect-square"
                                ></div>
                            </template>
                            <template #error>
                                <span
                                    class="bg-red-500 rounded-lg size-12 aspect-square"
                                ></span>
                            </template>
                        </UseImage>
                        <div>
                            <AlertDialog>
                                <AlertDialogTrigger>
                                    <Button variant="destructive"
                                        >{{ $t("Delete") }}
                                    </Button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>
                                            ¿Estás seguro de que deseas eliminar
                                            esta imagen?
                                        </AlertDialogTitle>
                                        <AlertDescription>
                                            Esta acción no se puede deshacer.
                                        </AlertDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>
                                            {{ $t("Cancel") }}
                                        </AlertDialogCancel>
                                        <AlertDialogAction
                                            @click="handleImageDelete(image.id)"
                                        >
                                            {{ $t("Delete") }}
                                        </AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </div>
                    </div>
                </FormItem>
                <div class="my-4">
                    <Button type="submit">Actualizar</Button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
