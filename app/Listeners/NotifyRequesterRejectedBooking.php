<?php

namespace App\Listeners;

use App\Events\BookingRejected;
use App\Notifications\RejectedBooking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyRequesterRejectedBooking implements ShouldQueue
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
    public function handle(BookingRejected $event): void
    {
        Notification::route('mail', $event->booking->requester->email)
            ->notify((new RejectedBooking($event->booking))->locale('es'));
    }
}
