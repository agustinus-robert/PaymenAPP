<?php

namespace Modules\Account\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;
use Modules\Account\Models\User;

class UserController extends Controller
{
    /**
     * Get the current user data.
     */
    public function me(Request $request)
    {
        return response()->success([
            'message' => 'Berikut adalah informasi akun Anda.',
            'id' => $request->user()->id ?? null,
            'displayName' => $request->user()->name,
            'username' => $request->user()->username,
            'user' => $request->user()
        ]);
    }

    /**
     * Search users.
     */
    public function search(Request $request)
    {
        return response()->success([
            'message' => 'Berikut adalah daftar pengguna berdasarkan kueri Anda.',
            'users' => User::search($request->get('q'))->limit(8)->get()->map(fn ($v) => [
                'id' => $v->id,
                'text' => $v->name
            ])
        ]);
    }
}
