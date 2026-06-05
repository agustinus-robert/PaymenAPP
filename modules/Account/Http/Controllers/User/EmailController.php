<?php

namespace Modules\Account\Http\Controllers\User;

use Modules\Account\Models\User;
use Modules\Account\Models\UserEmail;
use Modules\Account\Http\Requests\User\Email\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class EmailController extends Controller
{
    /**
     * index.
     */
    public function index()
    {
    	$user = auth()->user();

        $this->authorize('update', $user);

        return view('account::user.email.edit', compact('user'));
    }

    /**
     * Update data.
     */
    public function update(UpdateRequest $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $newEmail = $request->input('email');

        if ($newEmail !== $user->email) {
            $updated = $user->update([
                'email' => $newEmail,
                'email_verified_at' => null
            ]);

            if ($updated) {
                return redirect()->route('account::user.email.reverify', [
                    'uid' => encrypt($user->id),
                    'next' => route('account::index')
                ]);
            }

            return redirect()->back()
                ->withInput()
                ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
        }

        return redirect($request->get('next', route('account::index')));
    }


    /**
     * Reverifyig email.
     */
    public function reverify(Request $request)
    {
        $email = UserEmail::with('user')->whereNull('verified_at')->findOrFail(decrypt($request->get('uid')));

        if($email->sendEmailVerification()) {

            return redirect($request->get('next', route('account::index')))
                        ->with(['success' => 'Kami telah mengirimkan tautan verifikasi ke <strong>'.$email->address.'</strong>.']);
        
        }

        return redirect()->back()
                         ->with(['danger' => 'Mohon maaf, terjadi kegagalan, silahkan ulangi beberapa saat lagi!']);
    }

    /**
     * Verify email address.
     */
    public function verify(Request $request)
    {
        $email = UserEmail::whereNull('verified_at')->findOrFail(decrypt($request->get('token')));

        $email->update([
            'verified_at' => now()
        ]);
        
        return view('account::user.email.verified', compact('email'));
    }
}
