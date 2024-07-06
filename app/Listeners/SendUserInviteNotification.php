<?php

namespace App\Listeners;

use App\Events\UserInvited;
use App\Notifications\TeamInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendUserInviteNotification implements ShouldQueue
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
    public function handle(UserInvited $event): void
    {
        Notification::locale('es')->send($event->user, new TeamInvite());
    }
}
