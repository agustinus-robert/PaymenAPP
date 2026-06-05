<?php

namespace Modules\Web\Repositories;

use Modules\Account\Models\User;
use Modules\Account\Models\UserBalance;
use Illuminate\Support\Facades\DB;
use Exception;

trait FundRepositories
{
    public function storeFundMutation(array $data): UserBalance
    {
        return DB::transaction(function () use ($data) {
            $userId = $data['user_balance_id'];
            $latestBalanceRecord = UserBalance::where('user_balance_id', $userId)
                ->latest('id')
                ->lockForUpdate()
                ->first();

            $currentBalance = $latestBalanceRecord ? (float) $latestBalanceRecord->amount : 0;
            $mutationAmount = (int) $data['amount'];

            if ($data['adjustment_status'] === 1) {
                $finalBalance = $currentBalance + $mutationAmount;
            } else {
                $finalBalance = $currentBalance - $mutationAmount;
                if ($finalBalance < 0) {
                    throw new Exception('Saldo Anda tidak mencukupi untuk melakukan penarikan ini.');
                }
            }

            $newBalanceSnapshot = UserBalance::create([
                'user_balance_id' => $userId,
                'amount'          => $finalBalance,
            ]);

            $newBalanceSnapshot->logs()->create([
                'adjustment_status' => $data['adjustment_status'],
                'log_user'          => $data['log_user'],
            ]);

            return $newBalanceSnapshot;
        });
    }
}
