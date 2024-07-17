<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SpaceCard from "@/Components/SpaceCard.vue";
import { Link, Head, router } from "@inertiajs/vue3";
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
import { ref } from "vue";
import { toast } from "vue-sonner";
import { trans } from "laravel-vue-i18n";

const open = ref<boolean>(false);
const campusToDeleteId = ref<number | null>(null);

function onSpaceCardDeleteClick(campusId: number) {
    campusToDeleteId.value = campusId;
    open.value = true;
}

function handleDelete(campusId: number) {
    router.delete(route("campuses.destroy", { campus: campusId }), {
        onError: () => {
            toast.error(
                trans("Failed to delete :thing", {
                    thing: trans("campus"),
                }),
            );
            campusToDeleteId.value = null;
        },
        onSuccess: () => {
            toast.success(
                trans("Successfully deleted :thing", {
                    thing: trans("campus"),
                }),
            );
            campusToDeleteId.value = null;
        },
    });
}

function handleAlertDialogUpdate(isOpen: boolean) {
    open.value = isOpen;
}

const spaces = defineProps<{
    campuses: {
        id: number;
        name: string;
        image: string;
    }[];
}>();
</script>

<template>
    <Head title="Campus" />
    <AuthenticatedLayout>
        <div
            class="space-y-5 sm:grid sm:grid-cols-2 sm:gap-5 sm:space-y-0 lg:grid-cols-3"
        >
            <SpaceCard
                v-for="campus in spaces.campuses"
                @click="() => router.visit(`/campuses/${campus.id}`)"
                @delete="onSpaceCardDeleteClick(campus.id)"
                deletable
                :key="campus.id"
                :image-src="campus.image"
                :title="campus.name"
            />
        </div>
    </AuthenticatedLayout>
    <AlertDialog :open @update:open="handleAlertDialogUpdate($event)">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    {{
                        $t("Are you sure you want to delete this :thing?", {
                            thing: $t("campus"),
                        })
                    }}
                </AlertDialogTitle>
                <AlertDescription>
                    {{
                        $t(
                            "Once a :thing is deleted, all of its resources and data will be permanently deleted.",
                            { thing: $t("campus") },
                        )
                    }}
                </AlertDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>
                    {{ $t("Cancel") }}
                </AlertDialogCancel>
                <AlertDialogAction
                    @click="handleDelete(campusToDeleteId ?? -1)"
                >
                    {{ $t("Delete") }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
