<?php

namespace Modules\Account\Http\Controllers\User;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;
use Modules\Account\Http\Requests\User\Avatar\UpdateRequest;
use Modules\Account\Repositories\User\AvatarRepository;

class AvatarController extends Controller
{
    use AvatarRepository;

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        if ($user = $this->updateAvatar($request->user(), $request->transformed()->toArray())) {

            return redirect()->back()->with('success', 'Foto profil ' . $user->display_name . ' telah berhasil diperbarui.');
        }

        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ($user = $this->removeAvatar($request->user())) {

            return redirect()->back()->with('success', 'Foto profil akun ' . $user->display_name . ' telah berhasil dihapus.');
        }

        return redirect()->fail();
    }
}
