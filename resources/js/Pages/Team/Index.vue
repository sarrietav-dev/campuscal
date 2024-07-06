<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Text from "@/Components/ui/Text.vue";
import { Button } from "@/Components/ui/button";
import { CircleUserRound, Ellipsis } from "lucide-vue-next";
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
    AlertDialogContent,
    AlertDialogTrigger,
    AlertDialogDescription,
    AlertDialogTitle,
    AlertDialogAction,
    AlertDialogFooter,
    AlertDialogCancel,
    AlertDialogHeader,
} from "@/Components/ui/alert-dialog";
import axios from "axios";

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

const display_names: { [k: string]: string } = {
    admin: "Administrador",
    super_admin: "Super Administrador",
    developer: "Desarrollador",
    requester: "Solicitante",
};

const roles = computed(() =>
    props.roles.map((role) => ({
        value: role.name,
        label: display_names[role.name],
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
    inviteMemberForm.post(route("teams.invite"), {
        preserveScroll: true,
        onSuccess: () => {
            inviteDialogOpen.value = false;
            inviteMemberForm.reset();
        },
    });
}

function submitChangeRole(userId: number) {
    changeMemberRoleForm.post(route("teams.change-role", { user: userId }), {
        preserveScroll: true,
        onSuccess: () => {
            changeRoleDialogOpen.value = false;
            changeMemberRoleForm.reset();
            router.reload();
        },
    });
}

async function handleDelete(userId: number) {
    await axios.delete(route("teams.remove", { user: userId }));
    router.reload();
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container max-w-4xl">
            <div class="flex align-center mb-6">
                <Text variant="heading4" class="text-center mr-auto">
                    Equipo
                </Text>
                <ResponsiveModal
                    :open="inviteDialogOpen"
                    @update:open="inviteDialogOpen = $event"
                >
                    <template #trigger>
                        <Button>Invitar miembro</Button>
                    </template>
                    <template #title>Invitar a un miembro</template>
                    <template #default>
                        <form
                            @submit.prevent="submitInvitation()"
                            id="invite-member-form"
                            class="flex *:grow gap-5"
                        >
                            <div class="flex flex-col gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    type="email"
                                    id="email"
                                    v-model="inviteMemberForm.email"
                                />
                                <ErrorMessage
                                    v-show="inviteMemberForm.errors.email"
                                >
                                    {{ inviteMemberForm.errors.email }}
                                </ErrorMessage>
                            </div>
                            <div class="flex flex-col gap-2">
                                <Label for="role">Rol</Label>
                                <Combobox
                                    :options="roles"
                                    placeholder="Seleccionar rol"
                                    v-model="inviteMemberForm.role"
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
                            Enviar invitación
                        </Button>
                    </template>
                </ResponsiveModal>
            </div>
            <div class="border rounded-lg">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Rol</TableHead>
                            <TableHead>Acciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(user, i) in users" :key="user.email">
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <CircleUserRound />
                                    {{ user.name }}
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
                                    {{ display_names[user.roles[0].name] }}
                                </Badge>
                                <ResponsiveModal
                                    v-else
                                    :open="changeRoleDialogOpen"
                                    @update:open="changeRoleDialogOpen = $event"
                                    disabled
                                >
                                    <template #trigger>
                                        <Badge
                                            variant="secondary"
                                            class="cursor-pointer select-none"
                                        >
                                            {{
                                                display_names[
                                                    user.roles[0].name
                                                ]
                                            }}
                                        </Badge>
                                    </template>
                                    <template #title>
                                        Cambiar rol de {{ user.name }}
                                    </template>
                                    <template #default>
                                        <form
                                            @submit.prevent="
                                                submitChangeRole(user.id)
                                            "
                                            id="change-role-form"
                                            class="flex *:grow gap-5"
                                        >
                                            <div class="flex flex-col gap-2">
                                                <Label for="role">Rol</Label>
                                                <Combobox
                                                    :options="roles"
                                                    placeholder="Seleccionar rol"
                                                    v-model="
                                                        changeMemberRoleForm.role
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
                                            Cambiar rol
                                        </Button>
                                    </template>
                                </ResponsiveModal>
                            </TableCell>
                            <TableCell>
                                <AlertDialog>
                                    <AlertDialogTrigger>
                                        <Button
                                            :disabled="
                                                $page.props.auth.user.email ===
                                                user.email
                                            "
                                            variant="destructive"
                                            class="select-none"
                                        >
                                            Eliminar
                                        </Button>
                                    </AlertDialogTrigger>
                                    <AlertDialogContent>
                                        <AlertDialogHeader>
                                            <AlertDialogTitle>
                                                Eliminar miembro
                                            </AlertDialogTitle>
                                        </AlertDialogHeader>
                                        <AlertDialogDescription>
                                            ¿Estás seguro de que deseas eliminar
                                            a {{ user.name }}?
                                        </AlertDialogDescription>
                                        <AlertDialogFooter>
                                            <AlertDialogAction
                                                @click="handleDelete(user.id)"
                                            >
                                                Sí
                                            </AlertDialogAction>
                                            <AlertDialogCancel
                                                >No
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
