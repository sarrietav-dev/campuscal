<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, Head, router } from "@inertiajs/vue3";
import SpaceCard from "@/Components/SpaceCard.vue";
import { ref } from "vue";
import { toast } from "vue-sonner";
import { trans } from "laravel-vue-i18n";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/Components/ui/alert-dialog";
import { AlertDescription } from "@/Components/ui/alert";

const open = ref<boolean>(false);
const spaceToDeleteId = ref<number | null>(null);

function onSpaceCardDeleteClick(campusId: number) {
    spaceToDeleteId.value = campusId;
    open.value = true;
}

function handleDelete(spaceId: number) {
    router.delete(route("spaces.destroy", { space: spaceId }), {
        onError: () => {
            toast.error(
                trans("Failed to delete :thing", {
                    thing: trans("space"),
                }),
            );
            spaceToDeleteId.value = null;
        },
        onSuccess: () => {
            toast.success(
                trans("Successfully deleted :thing", {
                    thing: trans("space"),
                }),
            );
            spaceToDeleteId.value = null;
        },
    });
}

function handleAlertDialogUpdate(isOpen: boolean) {
    open.value = isOpen;
}

const spaces = defineProps<{
    spaces: {
        id: number;
        name: string;
        image: string;
    }[];
}>();
</script>

<template>
    <Head title="Campus" />
    <AuthenticatedLayout>
        <div>
            <div
                class="space-y-5 sm:grid sm:grid-cols-2 sm:gap-5 sm:space-y-0 lg:grid-cols-3"
            >
                <SpaceCard
                    v-for="space in spaces.spaces"
                    @click="
                        () =>
                            router.visit(
                                route('spaces.show', { space: space.id }),
                            )
                    "
                    @delete="onSpaceCardDeleteClick(space.id)"
                    deletable
                    :key="space.id"
                    :image-src="space.image"
                    :title="space.name"
                />
            </div>
        </div>
    </AuthenticatedLayout>
    <AlertDialog :open @update:open="handleAlertDialogUpdate($event)">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    {{
                        $t("Are you sure you want to delete this :thing?", {
                            thing: $t("space"),
                        })
                    }}
                </AlertDialogTitle>
                <AlertDescription>
                    {{
                        $t(
                            "Once a :thing is deleted, all of its resources and data will be permanently deleted.",
                            {
                                thing: $t("space"),
                            },
                        )
                    }}
                </AlertDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>
                    {{ $t("Cancel") }}
                </AlertDialogCancel>
                <AlertDialogAction @click="handleDelete(spaceToDeleteId ?? -1)">
                    {{ $t("Delete") }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
