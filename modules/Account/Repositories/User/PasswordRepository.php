<?php

namespace Modules\Account\Repositories\User;

use Arr;
use Auth;
use Modules\Account\Models\User;
use Modules\Account\Notifications\PasswordChangedNotification;
use Modules\Account\Http\Requests\User\Password\UpdateRequest;

trait PasswordRepository
{
    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(User $user, array $array) : User
    {
        $user->fill(Arr::only($array, 'password'));

        if($user->save()) {

            $user->notify(new PasswordChangedNotification());

            Auth::user()->log('memperbarui sandi pengguna '.$user->name.' <strong>[ID: '.$user->id.']</strong>', User::class, $user->id);

            return $user;

        }

        return false;
    }
}