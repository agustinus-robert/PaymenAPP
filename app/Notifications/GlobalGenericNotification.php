<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GlobalGenericNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    protected $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function broadcastOn()
    {
        $targetId = $this->details['user_id_target'] ?? auth()->id();
        return new PrivateChannel('Modules.Account.Models.User.' . $targetId);
    }

    public function broadcastAs()
    {
        return 'notification.received';
    }

    public function broadcastWith()
    {
        $senderImage = auth()->user()->profile_avatar_path;

        return [
            'sender_name'  => auth()->user()->name,
            'sender_image' => $senderImage,
            'action'       => $this->details['title'] ?? 'Pembaruan',
            'message'      => $this->details['message'] ?? '',
            'link'         => $this->details['link'] ?? '#',
            'icon'         => $this->details['icon'] ?? 'bx bx-bell',
            'color'        => $this->details['color'] ?? 'primary',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->broadcastWith();
    }
}
