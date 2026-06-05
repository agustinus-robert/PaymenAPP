<?php

namespace Modules\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auth;

    public $remember;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($auth, $remember = false)
    {
        $this->auth = $auth;
        $this->remember = $remember;
    }
}
