<script lang="ts" setup>
import {
    ColumnFiltersState,
    FlexRender,
    getCoreRowModel,
    getFacetedRowModel,
    getFacetedUniqueValues,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    useVueTable,
    VisibilityState,
} from "@tanstack/vue-table";
import { ChevronDown } from "lucide-vue-next";

import { ref } from "vue";
import { Button } from "./ui/button";
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from "./ui/dropdown-menu";
import { Input } from "./ui/input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "./ui/table";
import { valueUpdater } from "@/lib/utils";
import { columns, statusES } from "@/Components/columnDef";
import { BookingProps } from "@/Pages/Booking/Index.vue";
import DataTableFacetedFilter from "@/Components/DataTableFacetedFilter.vue";
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
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

const { bookings: data } = defineProps<BookingProps>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});

const table = useVueTable({
    data,
    columns,
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
    },
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) =>
        valueUpdater(updaterOrValue, rowSelection),
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFacetedRowModel: getFacetedRowModel(),
    getFacetedUniqueValues: getFacetedUniqueValues(),
});

const statuses = Object.keys(statusES).map((key) => ({
    value: key,
    label: statusES[key],
}));

const page = usePage();

function handleExport() {
    router.post(
        route("bookings.export"),
        {},
        {
            onSuccess: () => {
                toast.success("Éxito!", {
                    description: page.props.flash.message,
                });
            },
        },
    );
}
</script>

<template>
    <div class="w-full">
        <div class="flex gap-2 items-center py-4">
            <Input
                :model-value="
                    table.getColumn('Email')?.getFilterValue() as string
                "
                class="max-w-sm"
                placeholder="Buscar por email"
                @update:model-value="
                    table.getColumn('Email')?.setFilterValue($event)
                "
            />
            <DataTableFacetedFilter
                v-if="table.getColumn('Estado')"
                :column="table.getColumn('Estado') as any"
                :options="statuses"
                title="Estado"
            />
            <div class="ml-auto flex gap-3">
                <!-- Export button -->
                <AlertDialog>
                    <AlertDialogTrigger>
                        <Button variant="outline">Exportar</Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle> Exportar datos</AlertDialogTitle>
                            <AlertDialogDescription>
                                El archivo Excel se enviará a tu correo
                                electrónico.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel> Cancelar</AlertDialogCancel>
                            <AlertDialogAction @click="handleExport()">
                                Exportar
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>

                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline">
                            Columnas
                            <ChevronDown class="ml-2 h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuCheckboxItem
                            v-for="column in table
                                .getAllColumns()
                                .filter((column) => column.getCanHide())"
                            :key="column.id"
                            :checked="column.getIsVisible()"
                            class="capitalize"
                            @update:checked="
                                (value) => {
                                    column.toggleVisibility(!!value);
                                }
                            "
                        >
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow
                        v-for="headerGroup in table.getHeaderGroups()"
                        :key="headerGroup.id"
                    >
                        <TableHead
                            v-for="header in headerGroup.headers"
                            :key="header.id"
                        >
                            <FlexRender
                                v-if="!header.isPlaceholder"
                                :props="header.getContext()"
                                :render="header.column.columnDef.header"
                            />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows"
                            :key="row.id"
                            :data-state="row.getIsSelected() && 'selected'"
                        >
                            <TableCell
                                v-for="cell in row.getVisibleCells()"
                                :key="cell.id"
                            >
                                <FlexRender
                                    :props="cell.getContext()"
                                    :render="cell.column.columnDef.cell"
                                />
                            </TableCell>
                        </TableRow>
                    </template>

                    <TableRow v-else>
                        <TableCell
                            :colspan="columns.length"
                            class="h-24 text-center"
                        >
                            No hay datos disponibles.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="flex items-center justify-end space-x-2 py-4">
            <div class="space-x-2">
                <Button
                    :disabled="!table.getCanPreviousPage()"
                    size="sm"
                    variant="outline"
                    @click="table.previousPage()"
                >
                    Anterior
                </Button>
                <Button
                    :disabled="!table.getCanNextPage()"
                    size="sm"
                    variant="outline"
                    @click="table.nextPage()"
                >
                    Siguiente
                </Button>
            </div>
        </div>
    </div>
</template>
