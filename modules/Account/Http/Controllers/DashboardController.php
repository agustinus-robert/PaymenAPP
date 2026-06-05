<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Account\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $total_user    = User::count();
        $total_role    = Role::count();

        $total_admin   = User::role('administrator')->count();
        $total_staff   = User::role('outlet')->count();

        $recent_users  = User::with('roles')->latest()->take(5)->get();

        return view('account::user.dashboard', compact('total_user', 'total_role', 'total_admin', 'total_staff', 'recent_users'));
    }
}
