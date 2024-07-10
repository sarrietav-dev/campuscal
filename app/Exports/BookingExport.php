<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection(): Collection
    {
        return Booking::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Details',
            'Assistance',
            'Minors',
            'Status',
            'External Details',
            'Observations',
        ];
    }

    /**
     * @param  Booking  $row
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->details,
            $row->assistance,
            $row->minors,
            $row->status,
            $row->external_details,
            $row->observations,
        ];
    }
}
