<?php

namespace Modules\Account\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Modules\Account\Models\User;

trait AvatarRepository
{
    /**
     * Define the primary meta keys for resource
     */
    private $metaKeys = [
        'profile_avatar'
    ];

    /**
     * Update the specified resource in storage.
     */
    public function updateAvatar(User $user, array $array)
    {
        if ($user) {

            $user->setManyMeta(Arr::only($array, $this->metaKeys));

            $user->log('memperbarui foto profil pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

            return $user;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeAvatar(User $user)
    {
        Storage::delete($user->getMeta('profile_avatar', 0));

        if ($user) {

            $user->removeManyMeta($this->metaKeys);

            $user->log('menghapus foto profil pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

            return $user;
        }

        return false;
    }
}
