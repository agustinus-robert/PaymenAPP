<?php

namespace Modules\Account\Notifications;

use Modules\Account\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifiedEmailNotification extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Terima kasih telah memverifikasi <strong>' . $this->user->email_address . '</strong>',
            'icon' => 'mdi mdi-email-check-outline',
            'color' => 'success',
        ];
    }
}
