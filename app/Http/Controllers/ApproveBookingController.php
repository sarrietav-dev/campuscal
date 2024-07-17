<?php

namespace App\Http\Controllers;

use App\Events\BookingApproved;
use App\Models\Booking;
use Illuminate\Http\Request;

class ApproveBookingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            abort(409, __('Booking is not pending'));
        }

        $validated = $request->validate([
            'observations' => ['string', 'max:255', 'nullable'],
        ]);

        $booking->approve($validated['observations'] ?? null);

        $booking->save();

        BookingApproved::dispatch($booking);
    }
}
