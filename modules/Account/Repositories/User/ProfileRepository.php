<?php

namespace Modules\Account\Repositories\User;

use Illuminate\Support\Arr;
use Auth;
use Modules\Account\Models\User;

trait ProfileRepository
{
    /**
     * Define the primary meta keys for resource
     */
    private $metaKeys = [
        'profile_prefix', 'profile_suffix', 'profile_sex', 'profile_pob', 'profile_dob', 'profile_blood', 'profile_religion'
    ];

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(User $user, array $array)
    {
        $user->fill(Arr::only($array, ['name']));

        if ($user->save()) {

            $user->setManyMeta(Arr::only($array, $this->metaKeys));

            Auth::user()->log('memperbarui informasi profil pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

            return $user;
        }

        return false;
    }
}
