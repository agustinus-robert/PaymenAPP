<?php

namespace Modules\Account\Http\Controllers\User;

use Storage;
use Modules\Account\Models\User;
use Modules\Account\Models\UserAchievement;
use Modules\Account\Http\Requests\User\Achievement\StoreRequest;
use Modules\Account\Http\Requests\User\Achievement\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class AchievementController extends Controller
{
    /**
     * Create the user achievements.
     */
    public function createAchievement(User $user, StoreRequest $request)
    {
        $data = $request->validated();

        $data['file'] = null;

        if($request->has('file')) {
            $data['file'] = $request->file('file')->store('users/achievements');
        }

        $user->achievements()->create($data);

        return $user;
    }

    /**
     * Update the user achievements.
     */
    public function updateAchievement(User $user, UserAchievement $achievement, UpdateRequest $request)
    {
        $data = $request->validated();
        $data['file'] = null;

        if($request->has('file')) {
            Storage::delete($achievement->file);
            $data['file'] = $request->file('file')->store('users/achievements');
        }

        $user->achievements()->find($achievement->id)->fill($data)->save();

        return $user;
    }

    /**
     * Remove achievements.
     */
    public function deleteAchievement(User $user, UserAchievement $achievement)
    {
        Storage::delete($achievement->file);
        
        $user->achievements()->find($achievement->id)->delete();

        return $user;
    }
}
