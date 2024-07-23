<?php

namespace App\Listeners;

use App\Events\UserInvited;
use App\Notifications\TeamInvite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
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

        Notification::route('mail', $event->email)
            ->notify((new TeamInvite($event->email, $event->role))
                ->locale('es'));

        Log::info('User invite sent', [
            'email' => $event->email,
            'role' => $event->role,
            'by' => auth()->id(),
        ]);
    }
}
