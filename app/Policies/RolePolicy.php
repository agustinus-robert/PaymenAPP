<?php

namespace App\Policies;

use Modules\Account\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
        return $user->hasAnyPermissionsTo(['read-roles', 'write-roles', 'delete-roles']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Role $model)
    {
        return $user->hasAnyPermissionsTo(['read-roles']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-roles']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Role $model)
    {
        return $user->hasAnyPermissionsTo(['write-roles']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Role $model)
    {
        return $user->hasAnyPermissionsTo(['write-roles']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Role $model)
    {
        return $user->hasAnyPermissionsTo(['delete-roles']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Role $model)
    {
        return $user->hasAnyPermissionsTo(['delete-roles']);
    }
}
