<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPassword extends Notification
{
    use Queueable;

    public function __construct(public string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset hasła — Alluc Cleaning')
            ->greeting('Cześć ' . $notifiable->name . ',')
            ->line('Otrzymaliśmy prośbę o zresetowanie hasła do Twojego konta w panelu Alluc Cleaning.')
            ->action('Zresetuj hasło', $url)
            ->line('Link wygaśnie za 60 minut.')
            ->line('Jeśli to nie Ty prosiłeś o zmianę hasła, zignoruj tę wiadomość.');
    }
}
