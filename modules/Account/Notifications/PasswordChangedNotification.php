<?php

namespace Modules\Account\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Password has been changed')
            ->greeting('Password has been changed')
            ->line('You have changed your account password on ' . now()->isoFormat('LLL') . '.')
            ->line('If you feel you haven\'t changed your account password, please contact us immediately to follow up.')
            ->line('Thank you for using our service.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your password has been changed on ' . now()->isoFormat('lll'),
            'icon' => 'mdi mdi-lock-open-variant-outline',
            'color' => 'danger',
        ];
    }
}
