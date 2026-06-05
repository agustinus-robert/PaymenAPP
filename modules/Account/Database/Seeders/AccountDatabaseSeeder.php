<?php

namespace Modules\Account\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('TENANT_PACK') == true){

            $user = User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin System',
                    'username' => 'admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            $team = Team::create([
                'user_id' => $user->id,
                'name' => 'Admin System',
                'personal_team' => true,
            ]);

            $user->teams()->attach($team->id);
            $user->switchTeam($team);
        } else {
            $user = User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin System',
                    'username' => 'admin',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            $team = Team::create([
                'user_id' => $user->id,
                'name' => 'Admin System',
                'personal_team' => true,
            ]);

            $user->teams()->attach($team->id);
            $user->switchTeam($team);

            // DB::insert('insert into cmp_role_users (role_id, user_id) values (?, ?)', [1, $user->first()->id]);
        }
    }
}
