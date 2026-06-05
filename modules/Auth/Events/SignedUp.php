<?php

namespace Modules\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Account\Models\User;

class SignedUp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $auth;

    public $remember = false;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->auth = [
            'type' => 'Bearer',
            'access_token' => $user->createToken('SignedUp')->accessToken
        ];
    }
}
