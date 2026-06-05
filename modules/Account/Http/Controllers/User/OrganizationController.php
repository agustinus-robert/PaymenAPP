<?php

namespace Modules\Account\Http\Controllers\User;

use Storage;
use Modules\Account\Models\User;
use Modules\Account\Models\UserOrganization;
use Modules\Account\Http\Requests\User\Organization\StoreRequest;
use Modules\Account\Http\Requests\User\Organization\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    /**
     * Create the user organizations.
     */
    public function createOrganization(User $user, StoreRequest $request)
    {
        $data = $request->validated();
        $data['file'] = null;

        if($request->has('file')) {
            $data['file'] = $request->file('file')->store('users/organizations');
        }

        $user->organizations()->create($data);

        return $user;
    }

    /**
     * Update the user organizations.
     */
    public function updateOrganization(User $user, UserOrganization $organization, UpdateRequest $request)
    {
        $data = $request->validated();
        $data['file'] = null;

        if($request->has('file')) {
            Storage::delete($organization->file);
            $data['file'] = $request->file('file')->store('users/organizations');
        }

        $user->organizations()->find($organization->id)->fill($data)->save();

        return $user;
    }

    /**
     * Remove organizations.
     */
    public function deleteOrganization(User $user, UserOrganization $organization)
    {
        Storage::delete($organization->file);
        
        $user->organizations()->find($organization->id)->delete();

        return $user;
    }
}