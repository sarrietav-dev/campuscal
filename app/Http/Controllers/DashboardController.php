<?php

namespace App\Http\Controllers;

use App\Services\BookingStatisticsService;
use App\Services\SpaceStatisticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private readonly BookingStatisticsService $bookingService, private readonly SpaceStatisticsService $spaceService) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'total_bookings_current_month' => $this->bookingService->getTotalBookingsForCurrentMonth(),
            'pending_bookings' => $this->bookingService->getTotalPendingBookings(),
            'approved_bookings' => $this->bookingService->getTotalApprovedBookings(),
            'rejected_bookings' => $this->bookingService->getTotalRejectedBookings(),
            'most_requested_spaces' => $this->spaceService->getMostRequestedSpaces(),
        ]);
    }
}
