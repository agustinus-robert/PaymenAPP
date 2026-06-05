<?php

namespace Modules\Account\Http\Controllers\User;

use Modules\Account\Models\User;
use Modules\Account\Models\UserStudy;
use Modules\Account\Http\Requests\User\Study\StoreRequest;
use Modules\Account\Http\Requests\User\Study\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class StudyController extends Controller
{
    /**
     * Create the user studies.
     */
    public function createStudy(User $user, StoreRequest $request)
    {
        $user->studies()->create($request->validated());

        return $user;
    }

    /**
     * Update the user studies.
     */
    public function updateStudy(User $user, UserStudy $study, UpdateRequest $request)
    {
        $user->studies()->find($study->id)->fill($request->validated())->save();

        return $user;
    }

    /**
     * Remove studies.
     */
    public function deleteStudy(User $user, UserStudy $study)
    {
        $user->studies()->find($study->id)->delete();

        return $user;
    }
}