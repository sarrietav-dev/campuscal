<?php

namespace App\Listeners;

use App\Events\BookingApproved;
use App\Notifications\ApprovedBookingForRequester;
use Illuminate\Contracts\Queue\ShouldQueue;

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
            ->notify(new ApprovedBookingForRequester($event->booking));
    }
}
