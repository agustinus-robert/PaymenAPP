<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Account\Models\UserSession;
use Illuminate\Http\Request;

class LoginSessionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('administrator');

        $sessions = UserSession::with('user')
            ->when(!$isAdmin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->when($isAdmin && $request->user_id, function ($query) use ($request) {
                return $query->where('user_id', $request->user_id);
            })
            ->orderBy('last_activity', 'desc')
            ->paginate(15);

        return view('account::user.session', compact('sessions', 'isAdmin'));
    }
}
