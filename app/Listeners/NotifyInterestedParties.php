<?php

namespace App\Listeners;

use App\Events\BookingApproved;
use App\Models\InterestedParty;
use App\Notifications\ApprovedBookingForInterestedParties;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyInterestedParties implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingApproved $event): void
    {
        InterestedParty::all()
            ->each(fn (InterestedParty $interestedParty) => $interestedParty
                ->notify((new ApprovedBookingForInterestedParties($event->booking))
                    ->locale('es')));

        Log::info('Notified interested parties about approved booking', [
            'booking' => $event->booking->id,
            'interested_parties' => InterestedParty::count(),
            'by' => auth()->id()
        ]);
    }
}
