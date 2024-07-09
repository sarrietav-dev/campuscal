import { ColumnDef } from "@tanstack/vue-table";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "./ui/tooltip";
import { Button } from "./ui/button";
import { Link } from "@inertiajs/vue3";
import { ArrowRight, ArrowUpDown } from "lucide-vue-next";
import { BookingProps } from "@/Pages/Booking/Index.vue";

export type Request = {
    id: string;
    details: string;
    assistanceCount: number;
    createdAt: string;
    status: string;
    requester: {
        id: string;
        name: string;
        surname: string;
        email: string;
    };
};

export const statusES: { [k: string]: string } = {
    pending: "Pendiente",
    approved: "Aprobado",
    rejected: "Rechazado",
};

export const columns: ColumnDef<BookingProps["bookings"][0]>[] = [
    { accessorKey: "id", header: "ID" },
    {
        accessorKey: "details",
        header: "Detalles",
        id: "Detalles",
        cell: ({ cell }) => (
            <div class="max-w-[300px] line-clamp-3">
                {cell.getValue() as string}
            </div>
        ),
    },
    {
        accessorKey: "assistance",
        id: "Asistentes",
        header: ({ column }) => (
            <div
                onClick={() =>
                    column.toggleSorting(column.getIsSorted() === "asc")
                }
            >
                <Button variant={"ghost"}>
                    Asistentes
                    <ArrowUpDown class="ml-2 h-4 w-4" />
                </Button>
            </div>
        ),
        cell: ({ cell }) => {
            const count = cell.getValue() as number;
            return count === 1 ? `${count} asistente` : `${count} asistentes`;
        },
    },
    {
        accessorKey: "created_at",
        header: ({ column }) => (
            <div
                onClick={() =>
                    column.toggleSorting(column.getIsSorted() === "asc")
                }
            >
                <Button variant={"ghost"}>
                    Creado
                    <ArrowUpDown class="ml-2 h-4 w-4" />
                </Button>
            </div>
        ),
        id: "Creado",
        cell: ({ cell }) => {
            const date = new Date(cell.getValue() as string);
            return date.toLocaleDateString("es-ES", {
                year: "numeric",
                month: "long",
                day: "numeric",
            });
        },
    },
    {
        accessorFn: ({ requester }) => `${requester.name} ${requester.surname}`,
        id: "Nombre del solicitante",
        header: "Nombre del solicitante",
    },
    {
        accessorKey: "status",
        header: "Estado",
        id: "Estado",
        filterFn: (row, columnId, filterValue: string[]) => {
            return filterValue.includes(row.getValue(columnId));
        },
        cell: ({ cell }) => {
            const status = cell.getValue() as string;
            return (
                <span
                    class={[
                        "px-2 py-1 text-xs font-semibold rounded-full",
                        status === "pending"
                            ? "bg-yellow-100 text-yellow-800"
                            : status === "approved"
                              ? "bg-green-100 text-green-800"
                              : "bg-red-100 text-red-800",
                    ]}
                >
                    {statusES[status]}
                </span>
            );
        },
    },
    {
        accessorFn: ({ requester }) => requester.email,
        accessorKey: "email",
        id: "Email",
        header: "Email",
        cell: ({ cell }) => (
            <a href={`mailto:${cell.getValue() as string}`}>
                {cell.getValue() as string}
            </a>
        ),
    },
    {
        id: "Acciones",
        enableHiding: false,
        cell: ({ row }) => {
            return (
                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Button asChild variant="default" size="icon">
                                <Link href={`/bookings/${row.getValue("id")}`}>
                                    <ArrowRight />
                                </Link>
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>Ver detalles</TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            );
        },
    },
];
