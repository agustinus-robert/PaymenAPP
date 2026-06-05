<?php

namespace Modules\Account\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Models\User;
use Modules\Account\Http\Requests\User\Phone\UpdateRequest;

trait PhoneRepository
{
    /**
     * Define the primary meta keys for resource
     */
    private $metaKeys = [
        'phone_code', 'phone_number', 'phone_whatsapp'
    ];

    /**
     * Update the specified resource in storage.
     */
    public function updatePhone(User $user, array $array)
    {
        if ($user) {
            $user->setManyMeta(Arr::only($array, $this->metaKeys));
            return $user;
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removePhone(User $user)
    {
        if ($user) {
            $user->removeManyMeta($this->metaKeys);
            return $user;
        }
        return false;
    }
}
