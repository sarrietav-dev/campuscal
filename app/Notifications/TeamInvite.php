<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInvite extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $email, public string $role)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->generateInvitationUrl($this->email, $this->role);

        return (new MailMessage)
            ->subject(__('mail.invite_subject'))
            ->greeting(__('mail.invite_hello'))
            ->line(__('mail.invite_subject'))
            ->action(__('mail.accept_invite'), url($url))
            ->line(__('mail.invite_disclaimer'));
    }

    private function generateInvitationUrl(string $email, string $role): string
    {
        return url()->temporarySignedRoute('register', now()->addDay(), [
            'email' => $email,
            'role' => $role,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
