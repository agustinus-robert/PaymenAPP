<?php

namespace Modules\Account\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationLinkNotification extends Notification
{
    use Queueable;

    public $link;

    /**
     * Create a new notification instance.
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifikasi surel')
            ->greeting('Verifikasi surel')
            ->line('Silahkan klik tautan dibawah untuk verifikasi surel Anda.')
            ->action('Verifikasi', $this->link)
            ->line('Terima kasih telah menggunakan layanan kami.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            //
        ];
    }
}
