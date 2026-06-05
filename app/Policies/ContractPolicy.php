<?php

namespace App\Policies;

use Modules\Account\Models\User;
use App\Models\Contract;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
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
        return $user->hasAnyPermissionsTo(['read-contracts', 'write-contracts', 'delete-contracts']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Contract $model)
    {
        return $user->hasAnyPermissionsTo(['read-contracts']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-contracts']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Contract $model)
    {
        return $user->hasAnyPermissionsTo(['write-contracts']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Contract $model)
    {
        return $user->hasAnyPermissionsTo(['write-contracts']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Contract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-contracts']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Contract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-contracts']);
    }
}
