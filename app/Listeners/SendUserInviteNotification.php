<?php

namespace App\Listeners;

use App\Events\UserInvited;
use App\Notifications\TeamInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $event->user->notify(new TeamInvite());
    }
}
