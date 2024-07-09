<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookingExport implements FromCollection
{
    use Exportable;

    public function collection(): Collection
    {
        return Booking::all();
    }
}
