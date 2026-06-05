<?php

namespace Modules\Portal\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Account\Models\UserBalance;
use Modules\Web\Models\PayTransaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        $balanceQuery = UserBalance::with(['logs' => function($query) {
                $query->latest();
             }, 'user'])
            ->where('user_balance_id', auth()->id())
            ->whereHas('logs');

        $transactionQuery = PayTransaction::with(['logs', 'sender', 'receiver'])
            ->where(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $balanceQuery->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });

            $transactionQuery->where(function($q) use ($search) {
                $q->where('transaction_code', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhereHas('sender', function($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('receiver', function($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('start_date')) {
            $date = Carbon::parse($request->start_date);
            $balanceQuery->whereDate('created_at', '>=', $date);
            $transactionQuery->whereDate('created_at', '>=', $date);
        }

        if ($request->filled('end_date')) {
            $date = Carbon::parse($request->end_date);
            $balanceQuery->whereDate('created_at', '<=', $date);
            $transactionQuery->whereDate('created_at', '<=', $date);
        }

        $balances = $balanceQuery->orderBy('created_at', 'desc')->get();
        $transactions = $transactionQuery->orderBy('created_at', 'desc')->get();

        return view('portal::dashboard', compact('user', 'balances', 'transactions'));
    }
}
