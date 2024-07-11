<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Text from "@/Components/ui/Text.vue";
import { Button } from "@/Components/ui/button";
import { CircleUserRound } from "lucide-vue-next";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import ResponsiveModal from "@/Components/ResponsiveModal.vue";
import { computed, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import Combobox from "@/Components/Combobox.vue";
import { Badge } from "@/Components/ui/badge";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";
import { toast } from "vue-sonner";
import { trans } from "laravel-vue-i18n";

const inviteDialogOpen = ref(false);
const changeRoleDialogOpen = ref(false);

const props = defineProps<{
    roles: { name: string }[];
    users: {
        id: number;
        name: string;
        email: string;
        roles: { name: string }[];
    }[];
}>();

const roles = computed(() =>
    props.roles.map((role) => ({
        value: role.name,
        label: trans(role.name),
    })),
);

const inviteMemberForm = useForm({
    email: "",
    role: "",
});

const changeMemberRoleForm = useForm({
    role: "",
});

function submitInvitation() {
    inviteMemberForm.post(route("team.store"), {
        preserveScroll: true,
        onSuccess: () => {
            inviteDialogOpen.value = false;
            inviteMemberForm.reset();
            router.reload();
            toast.success(trans("Invite sent successfully"));
        },
    });
}

function submitChangeRole(userId: number) {
    changeMemberRoleForm.patch(route("team.update", { user: userId }), {
        preserveScroll: true,
        onSuccess: () => {
            changeRoleDialogOpen.value = false;
            changeMemberRoleForm.reset();
            router.reload();
            toast.success(trans("User role updated successfully"));
        },
    });
}

async function handleDelete(userId: number) {
    router.delete(route("team.destroy", { user: userId }), {
        preserveScroll: true,
        onSuccess: () => {
            router.reload();
            toast.success(trans("User removed from the team successfully"));
        },
        onError: () => {
            toast.error("No se pudo eliminar al miembro");
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container max-w-4xl">
            <div class="flex align-center mb-6">
                <Text class="text-center mr-auto" variant="heading4">
                    {{ $t("Team") }}
                </Text>
                <ResponsiveModal
                    :open="inviteDialogOpen"
                    @update:open="inviteDialogOpen = $event"
                >
                    <template #trigger>
                        <Button>{{ $t("Invite member") }}</Button>
                    </template>
                    <template #title
                        >{{ $t("Invite a member to join the team") }}
                    </template>
                    <template #default>
                        <form
                            id="invite-member-form"
                            class="flex *:grow gap-5"
                            @submit.prevent="submitInvitation()"
                        >
                            <div class="flex flex-col gap-2">
                                <Label for="email">{{ $t("Email") }}</Label>
                                <Input
                                    id="email"
                                    v-model="inviteMemberForm.email"
                                    type="email"
                                />
                                <ErrorMessage
                                    v-show="inviteMemberForm.errors.email"
                                >
                                    {{ inviteMemberForm.errors.email }}
                                </ErrorMessage>
                            </div>
                            <div class="flex flex-col gap-2">
                                <Label for="role">{{ $t("Role") }}</Label>
                                <Combobox
                                    v-model="inviteMemberForm.role"
                                    :options="roles"
                                    :placeholder="trans('Select a role')"
                                />
                                <ErrorMessage
                                    v-show="inviteMemberForm.errors.role"
                                >
                                    {{ inviteMemberForm.errors.role }}
                                </ErrorMessage>
                            </div>
                        </form>
                    </template>
                    <template #footer>
                        <Button form="invite-member-form" type="submit">
                            {{ $t("Send invite") }}
                        </Button>
                    </template>
                </ResponsiveModal>
            </div>
            <div class="border rounded-lg">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>{{ $t("Name") }}</TableHead>
                            <TableHead>{{ $t("Email") }}</TableHead>
                            <TableHead>{{ $t("Role") }}</TableHead>
                            <TableHead>{{ $t("Actions") }}</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(user, i) in users" :key="user.email">
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <CircleUserRound class="size-6" />
                                    <span class="truncate">
                                        {{ user.name }}
                                    </span>
                                </div>
                            </TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell>
                                <Badge
                                    v-if="
                                        $page.props.auth.user.email ===
                                        user.email
                                    "
                                    class="cursor-default select-none"
                                    variant="outline"
                                >
                                    {{ $t(user.roles[0].name) }}
                                </Badge>
                                <ResponsiveModal
                                    v-else
                                    :open="changeRoleDialogOpen"
                                    @update:open="changeRoleDialogOpen = $event"
                                >
                                    <template #trigger>
                                        <Badge
                                            class="cursor-pointer select-none"
                                            variant="secondary"
                                        >
                                            {{ $t(user.roles[0].name) }}
                                        </Badge>
                                    </template>
                                    <template #title>
                                        {{
                                            $t("Change role of the :user", {
                                                user: user.name,
                                            })
                                        }}
                                    </template>
                                    <template #default>
                                        <form
                                            id="change-role-form"
                                            class="flex *:grow gap-5"
                                            @submit.prevent="
                                                submitChangeRole(user.id)
                                            "
                                        >
                                            <div class="flex flex-col gap-2">
                                                <Label for="role">
                                                    {{ $t("Role") }}
                                                </Label>
                                                <Combobox
                                                    v-model="
                                                        changeMemberRoleForm.role
                                                    "
                                                    :options="roles"
                                                    :placeholder="
                                                        trans('Select a role')
                                                    "
                                                />
                                                <ErrorMessage
                                                    v-show="
                                                        changeMemberRoleForm
                                                            .errors.role
                                                    "
                                                >
                                                    {{
                                                        changeMemberRoleForm
                                                            .errors.role
                                                    }}
                                                </ErrorMessage>
                                            </div>
                                        </form>
                                    </template>
                                    <template #footer>
                                        <Button
                                            form="change-role-form"
                                            type="submit"
                                        >
                                            {{ $t("Change role") }}
                                        </Button>
                                    </template>
                                </ResponsiveModal>
                            </TableCell>
                            <TableCell>
                                <AlertDialog>
                                    <AlertDialogTrigger as-child>
                                        <Button
                                            :disabled="
                                                $page.props.auth.user.email ===
                                                user.email
                                            "
                                            class="select-none"
                                            variant="destructive"
                                        >
                                            {{ $t("Remove") }}
                                        </Button>
                                    </AlertDialogTrigger>
                                    <AlertDialogContent>
                                        <AlertDialogHeader>
                                            <AlertDialogTitle>
                                                {{ $t("Remove member") }}
                                            </AlertDialogTitle>
                                        </AlertDialogHeader>
                                        <AlertDialogDescription>
                                            {{
                                                $t(
                                                    "Are you sure you want to remove :user from the team?",
                                                    { user: user.name },
                                                )
                                            }}
                                        </AlertDialogDescription>
                                        <AlertDialogFooter>
                                            <AlertDialogAction
                                                @click="handleDelete(user.id)"
                                            >
                                                {{ $t("Yes") }}
                                            </AlertDialogAction>
                                            <AlertDialogCancel>
                                                {{ $t("No") }}
                                            </AlertDialogCancel>
                                        </AlertDialogFooter>
                                    </AlertDialogContent>
                                </AlertDialog>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
