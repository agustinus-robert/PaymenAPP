<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Modules\Account\Models\User;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('administrator');

        $logs = AuditLog::with(['auditable', 'user'])
            ->when(!$isAdmin, function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->when($isAdmin && $request->user_id, function ($query) use ($request) {
                return $query->where('user_id', $request->user_id);
            })
            ->when($request->event, function ($query) use ($request) {
                return $query->where('event', $request->event);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = $isAdmin ? User::orderBy('name', 'asc')->get(['id', 'name']) : collect();
        return view('account::user.audit-log', compact('logs', 'users', 'isAdmin'));
    }
}
