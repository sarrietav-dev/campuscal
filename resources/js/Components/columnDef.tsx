import { ColumnDef } from "@tanstack/vue-table";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "./ui/tooltip";
import { Button } from "./ui/button";
import { Link } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import { BookingProps } from "@/Pages/Booking/Bookings.vue";

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

const statusES: { [k: string]: string } = {
    pending: "Pendiente",
    approved: "Aprobado",
    rejected: "Rechazado",
};

export const columns: ColumnDef<BookingProps["bookings"][0]>[] = [
    { accessorKey: "id", header: "ID" },
    {
        accessorKey: "details",
        header: "Detalles",
        cell: ({ cell }) => (
            <div class="max-w-[300px] line-clamp-3">
                {cell.getValue() as string}
            </div>
        ),
    },
    { accessorKey: "assistance", header: "Asistencias" },
    {
        accessorFn: ({ created_at }) =>
            new Date(created_at).toLocaleDateString(),
        header: "Creado",
    },
    {
        accessorFn: ({ requester }) => `${requester.name} ${requester.surname}`,
        header: "Nombre del solicitante",
    },
    {
        accessorKey: "status",
        header: "Estado",
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
        header: "Email",
        cell: ({ cell }) => (
            <a href={`mailto:${cell.getValue() as string}`}>
                {cell.getValue() as string}
            </a>
        ),
    },
    {
        id: "actions",
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
                        <TooltipContent>
                            <p>View request</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>
            );
        },
    },
];
