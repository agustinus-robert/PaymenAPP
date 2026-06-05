<?php

namespace Modules\Account\Http\Controllers\User;

use Storage;
use Modules\Account\Models\User;
use Modules\Account\Models\UserAppreciation;
use Modules\Account\Http\Requests\User\Appreciation\StoreRequest;
use Modules\Account\Http\Requests\User\Appreciation\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class AppreciationController extends Controller
{
    /**
     * Create the user appreciations.
     */
    public function createAppreciation(User $user, StoreRequest $request)
    {
        $data = $request->validated();
        $data['file'] = null;

        if($request->has('file')) {
            $data['file'] = $request->file('file')->store('users/appreciations');
        }

        $user->appreciations()->create($data);

        return $user;
    }

    /**
     * Update the user appreciations.
     */
    public function updateAppreciation(User $user, UserAppreciation $appreciation, UpdateRequest $request)
    {
        $data = $request->validated();
        $data['file'] = null;

        if($request->has('file')) {
            Storage::delete($appreciation->file);
            $data['file'] = $request->file('file')->store('users/appreciations');
        }

        $user->appreciations()->find($appreciation->id)->fill($data)->save();

        return $user;
    }

    /**
     * Remove appreciations.
     */
    public function deleteAppreciation(User $user, UserAppreciation $appreciation)
    {
        Storage::delete($appreciation->file);
        
        $user->appreciations()->find($appreciation->id)->delete();

        return $user;
    }
}
