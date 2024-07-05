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
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/Components/ui/alert-dialog";
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Input } from "@/Components/ui/input";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import Combobox from "@/Components/Combobox.vue";

const inviteDialogOpen = ref(false);
const alertDialogOpen = ref(false);

const props = defineProps<{
    roles: { id: number; name: string; display_name: string }[];
}>();

const roles = computed(() =>
    props.roles.map((role) => ({
        value: role.name,
        label: role.display_name,
    })),
);

const form = useForm({
    email: "",
    role: "",
});

const users = ref([
    {
        id: 1,
        name: "John Doe",
        email: "john@doe.com",
        role: "admin",
    },
    {
        id: 2,
        name: "Jane Doe",
        email: "jsakdljs@aklsdj.com",
        role: "admin",
    },
    {
        id: 3,
        name: "John Smith",
        email: "kasld@asjd",
        role: "developer",
    },
]);

function submit() {
    form.post(route("teams.invite"), {
        preserveScroll: true,
        onSuccess: () => {
            inviteDialogOpen.value = false;
            form.reset();
        },
    });
}

function changeRole(userIndex: number, role: string) {
    alertDialogOpen.value = true;
    users.value[userIndex].role = role;
}
</script>

<template>
    <AlertDialog :open="alertDialogOpen">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    Confirma que deseas cambiar el rol de este miembro
                </AlertDialogTitle>
                <AlertDialogDescription>
                    Al cambiar el rol de este miembro, se le enviará una
                    notificación.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel> Cancelar</AlertDialogCancel>
                <AlertDialogAction @click="alertDialogOpen = false">
                    Cambiar rol
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
    <AuthenticatedLayout>
        <div class="container max-w-4xl">
            <div class="flex align-center mb-6">
                <Text variant="heading4" class="text-center mr-auto">
                    Equipo
                </Text>
                <ResponsiveModal
                    :inviteDialogOpen
                    @update:open="inviteDialogOpen = $event"
                >
                    <template #trigger>
                        <Button>Invitar miembro</Button>
                    </template>
                    <template #title>Invitar a un miembro</template>
                    <template #default>
                        <form
                            @submit.prevent="submit()"
                            id="invite-member-form"
                            class="flex *:grow gap-5"
                        >
                            <div class="flex flex-col gap-2">
                                <Label for="email">Email</Label>
                                <Input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                />
                                <ErrorMessage v-show="form.errors.email">
                                    {{ form.errors.email }}
                                </ErrorMessage>
                            </div>
                            <div class="flex flex-col gap-2">
                                <Label for="role">Rol</Label>
                                <Combobox
                                    :options="roles"
                                    placeholder="Seleccionar rol"
                                    v-model="form.role"
                                />
                                <ErrorMessage v-show="form.errors.role">
                                    {{ form.errors.role }}
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
                                <Combobox
                                    :options="roles"
                                    :model-value="user.role"
                                    @update:model-value="
                                        changeRole(i, $event.value)
                                    "
                                />
                            </TableCell>
                            <TableCell>
                                <Button variant="ghost" size="icon">
                                    <Ellipsis />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
