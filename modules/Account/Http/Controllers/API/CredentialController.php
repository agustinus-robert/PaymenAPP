<?php

namespace Modules\Account\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Http\Controllers\Controller;

class CredentialController extends Controller
{
    public function login(Request $request)
    {
        $request->headers->set('Accept', 'application/json');

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.'
            ], 401);
        }

        $user = Auth::guard('web')->user();
        $tokenString = $user->token ? $user->token->token : '';

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'x-api-token' => $tokenString,
            ]
        ], 200);
    }
}
