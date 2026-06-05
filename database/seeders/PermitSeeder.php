<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Account\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PermitSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $menus = ['portal'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($menus as $menu) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $action . '_' . $menu,
                    'guard_name' => 'web'
                ]);
            }
        }

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        $allPermissions = Permission::where('guard_name', 'web')->get();
        $userRole->syncPermissions($allPermissions);

        $names = [
            'Maria Aminah',
            'Robert Santoso',
            'Nadia Suryati'
        ];

        foreach ($names as $key => $name) {

            $username = strtolower(str_replace(' ', '', substr($name, 0, 8))) . ($key + 1);
            $email = strtolower(str_replace(' ', '', $name)) . '@mail.com';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'username' => $username,
                    'name' => $name,
                    'password' => 'password',
                    'current_team_id' => 1,
                ]
            );

            $user->syncRoles([$userRole]);

            $user->setMeta('profile_sex', ($key % 2 == 0) ? 'male' : 'female');
            $user->setMeta('profile_mariage', 'single');
            $user->setMeta('profile_child', 0);
            $randomToken = Str::random(60);

            $user->token()->updateOrCreate(
                ['user_id' => $user->id],
                ['token' => $randomToken]
            );

            $this->command->comment("\tUser: {$username} | Token: {$randomToken} telah dibuat");
        }

        $this->command->info("\tSeeder berhasil berjalan");
    }
}
