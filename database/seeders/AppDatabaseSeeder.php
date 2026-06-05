<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Setting;
use App\Models\Permission;
use App\Models\Role;

class AppDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            'app_short_name'   => 'Mini Payment',
            'app_name'         => 'Mini Payment',
            'app_long_name'    => 'Mini Payment System',
            'meta_author'      => 'agustinus-robert',
            'meta_keywords'    => 'payment',
            'meta_image'       => '/img/logo/logo-icon-sq-512.png',
            'meta_description' => config('app.url'),
            'theme'            => 'payment'
        ];


        foreach ($settings as $key => $value) {
            Setting::create([
                'key'      => $key,
                'value'    => $value,
            ]);
        }


        $permissions = [
            'Account' => [
                'User' => ['read', 'write', 'delete', 'cross-login'],
                'UserLog' => ['read', 'delete'],
            ],
        ];

        foreach ($permissions as $module => $models) {
            foreach ($models as $model => $actions) {
                foreach ($actions as $permission) {
                    Permission::create([
                        'module' => $module,
                        'name' => ucfirst(str($permission)->append(' ' . str(str()->snake($model, ' '))->plural())),
                        'model' => $model,
                        'description' => 'Allow user to ' . strtolower(str($permission)->append(' ' . str(str()->snake($model, ' '))->plural())),
                        'key' => str()->slug(str($permission)->append(' ' . str(str()->snake($model))->plural()))
                    ]);
                }
            }
        }
    }
}
