<?php

namespace Modules\Account\Http\Controllers\User;

use Modules\Account\Models\User;
use Modules\Account\Http\Controllers\Controller;
use Modules\Account\Http\Requests\User\Profile\UpdateRequest;
use Modules\Account\Repositories\User\ProfileRepository;

class ProfileController extends Controller
{
    use ProfileRepository;

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        if ($user = $this->updateProfile($request->user(), $request->transformed()->toArray())) {
            return redirect()->back()->with('success', 'Informasi profil akun ' . ' telah berhasil diperbarui.');
        }
        return redirect()->fail();
    }
}
