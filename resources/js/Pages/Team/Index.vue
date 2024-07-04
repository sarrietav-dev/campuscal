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
</script>

<template>
    <AuthenticatedLayout>
        <div class="container max-w-4xl">
            <div class="flex justify-between align-center mb-6">
                <Text variant="heading4" class="text-center"> Equipo</Text>
                <Button>Invitar miembro</Button>
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
                        <TableRow v-for="i in 5" :key="i">
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <CircleUserRound />
                                    John Doe
                                </div>
                            </TableCell>
                            <TableCell> john.doe@example.com</TableCell>
                            <TableCell>Admin</TableCell>
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
