<?php

namespace App\Listeners;

use App\Events\BookingApproved;
use App\Notifications\ApprovedBookingForRequester;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyRequesterBookingApproved implements ShouldQueue
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
        \Notification::route('mail', $event->booking->requester->email)
            ->notify((new ApprovedBookingForRequester($event->booking))->locale('es'));

        Log::info('Requester notified about booking approval', [
            'booking_id' => $event->booking->id,
            'requester_id' => $event->booking->requester->id,
        ]);
    }
}
