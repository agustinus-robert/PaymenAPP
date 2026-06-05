<?php

namespace Modules\Web\Repositories;

use Modules\Account\Models\User;
use Modules\Web\Models\PayTransaction;
use Modules\Account\Models\UserBalance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

trait PaymentRepositories
{
    public function storePayment(array $data): PayTransaction
    {
        return DB::transaction(function () use ($data) {
            $userIds = [$data['sender_id'], $data['recipient_id']];
            sort($userIds);

            $users = User::whereIn('id', $userIds)->lockForUpdate()->get()->keyBy('id');

            $sender = $users->get($data['sender_id']);
            $recipient = $users->get($data['recipient_id']);

            if (!$sender || !$recipient) {
                throw new Exception('Data pengirim atau penerima tidak ditemukan.');
            }

            $senderCurrentBalance = $sender->balance?->amount ?? 0;
            $senderNewAmount = $senderCurrentBalance - $data['amount'];

            if ($senderNewAmount < 0) {
                throw new Exception('Saldo pengirim tidak mencukupi.');
            }

            $recipientCurrentBalance = $recipient->balance?->amount ?? 0;
            $recipientNewAmount = $recipientCurrentBalance + $data['amount'];
            $transactionCode = 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $transaction = PayTransaction::create([
                'transaction_code' => $transactionCode,
                'sender_id'        => $sender->id,
                'receiver_id'      => $recipient->id,
                'amount'           => $data['amount'],
                'description'      => $data['note'] ?? null,
                'status'           => $data['status'] ?? 'success',
            ]);

            $formattedAmount = number_format($data['amount'], 0, ',', '.');
            $this->createBalanceSnapshotAndLog(
                $transaction,
                $sender,
                $senderNewAmount,
                2,
                'Anda mengirimkan transfer ke ' . $recipient->name . ' sebesar ' . $formattedAmount
            );

            $this->createBalanceSnapshotAndLog(
                $transaction,
                $recipient,
                $recipientNewAmount,
                1,
                'Anda mendapatkan transfer dari ' . $sender->name . ' sebesar ' . $formattedAmount
            );

            return $transaction;
        });
    }

    private function createBalanceSnapshotAndLog(
        PayTransaction $transaction,
        User $user,
        int $newAmount,
        int $adjustmentStatus,
        string $logMessage
    ): void {
        $balanceSnapshot = UserBalance::create([
            'user_balance_id' => $user->id,
            'amount'          => $newAmount,
        ]);

        $transaction->logs()->create([
            'user_balance_id'   => $balanceSnapshot->id,
            'adjustment_status' => $adjustmentStatus,
            'log_user'          => $logMessage,
        ]);
    }
}
