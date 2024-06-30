<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BookingStatisticsService
{
    public function getBookingsForCurrentMonth(): Booking|Builder
    {
        return Booking::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
    }

    public function getTotalBookingsForCurrentMonth(): int
    {
        return Cache::remember('total_bookings_current_month', 60, function () {
            return $this->getBookingsForCurrentMonth()->count();
        });
    }

    public function getTotalPendingBookings(): int
    {
        return Cache::remember('total_pending_bookings', 60, function () {
            return $this->getBookingsForCurrentMonth()->where('status', 'pending')->count();
        });
    }

    public function getTotalApprovedBookings(): int
    {
        return Cache::remember('total_approved_bookings', 60, function () {
            return $this->getBookingsForCurrentMonth()->where('status', 'approved')->count();
        });
    }

    public function getTotalRejectedBookings(): int
    {
        return Cache::remember('total_rejected_bookings', 60, function () {
            return $this->getBookingsForCurrentMonth()->where('status', 'rejected')->count();
        });
    }
}
