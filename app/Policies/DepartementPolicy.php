<?php

namespace App\Policies;

use Modules\Account\Models\User;
use App\Models\Departement;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartementPolicy
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
        return $user->hasAnyPermissionsTo(['read-departements', 'write-departements', 'delete-departements']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Departement $model)
    {
        return $user->hasAnyPermissionsTo(['read-departements']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-departements']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Departement $model)
    {
        return $user->hasAnyPermissionsTo(['write-departements']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Departement $model)
    {
        return $user->hasAnyPermissionsTo(['write-departements']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Departement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-departements']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Departement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-departements']);
    }
}
