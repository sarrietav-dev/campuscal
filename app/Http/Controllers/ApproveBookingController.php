<?php

namespace App\Http\Controllers;

use App\Events\BookingApproved;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        Log::info('Booking approved', ['booking' => $booking->id, 'by' => auth()->id()]);

        BookingApproved::dispatch($booking);
    }
}
