<?php

namespace Modules\Account\Repositories\User;

use Arr;
use Auth;
use Modules\Account\Models\User;
use Modules\Account\Http\Requests\User\Username\UpdateRequest;

trait UsernameRepository
{
	/**
     * Update the specified resource in storage.
     */
    public function updateUsername(User $user, array $array)
    {
    	$user->fill(Arr::only($array, 'username'));

    	if($user->save()) {

    		Auth::user()->log('memperbarui username pengguna '.$user->name.' <strong>[ID: '.$user->id.']</strong>', User::class, $user->id);

    		return $user;

    	}

    	return false;
    }
}