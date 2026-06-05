<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Account\Models\User;

class WhatsAppNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $user;
    protected $file;
    protected $phone;

    public function __construct($message, User $user, $file = null)
    {
        $this->message = $message;
        $this->user = $user;
        $this->file = $file;
        $this->phone = $this->user->getMeta('phone_code') . $this->user->getMeta('phone_number');
    }

    public function via($notifiable)
    {
        return [];
    }

    /**
     * Override buildMessage untuk mengatur pesan default jika tidak diberikan.
     */
    public function buildMessage()
    {
        $message = $this->message ?: $this->getDefaultWhatsAppMessage();

        return "Halo, {$this->user->name},\n\n" . $message . "\n\n" .
            "Jika Anda membutuhkan informasi lebih lanjut, segera hubungi kami untuk menindak lanjuti. \n\n" .
            "Terima kasih telah menggunakan layanan kami. \n\n";
    }

    /**
     * Pesan default khusus untuk WhatsApp.
     */
    protected function getDefaultWhatsAppMessage()
    {
        return "Ini adalah pesan notifikasi WhatsApp default.";
    }
}
