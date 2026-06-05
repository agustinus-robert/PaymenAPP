<?php

namespace App\Policies;

use Modules\Account\Models\User;
use App\Models\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Can access page.
     */
    public function access(User $user)
    {
        return $user->hasAnyPermissionsTo(['read-positions', 'write-positions', 'delete-positions']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Position $model)
    {
        return $user->hasAnyPermissionsTo(['read-positions']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-positions']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Position $model)
    {
        return $user->hasAnyPermissionsTo(['write-positions']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Position $model)
    {
        return $user->hasAnyPermissionsTo(['write-positions']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Position $model)
    {
        return $user->hasAnyPermissionsTo(['delete-positions']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Position $model)
    {
        return $user->hasAnyPermissionsTo(['delete-positions']);
    }
}
