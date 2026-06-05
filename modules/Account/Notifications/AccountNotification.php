<?php

namespace Modules\Account\Notifications;

use App\Channels\WhatsAppChannel;
use App\Notifications\WhatsAppNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountNotification extends WhatsAppNotification implements ShouldQueue
{
    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        return [
            'phone'   => $this->phone,
            'message' => $this->buildMessage(),
            'file'    => $this->file,
        ];
    }
}
