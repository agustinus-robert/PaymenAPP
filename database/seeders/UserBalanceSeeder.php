<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Account\Models\UserBalance;
use Modules\Account\Models\UserLogBalance;
use Illuminate\Support\Facades\DB;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        DB::transaction(function () use ($users) {
            foreach ($users as $user) {
                $initialAmount = 100000;
                $balance = UserBalance::create([
                    'user_balance_id' => $user->id,
                    'amount'          => $initialAmount,
                ]);

                UserLogBalance::create([
                    'modelable_id'      => $balance->id,
                    'modelable_type'    => UserBalance::class,
                    'adjustment_status' => 1,
                    'log_user'          => "Penambahan saldo awal sebesar Rp " . number_format($initialAmount, 0, ',', '.'),
                ]);
            }
        });
    }
}
