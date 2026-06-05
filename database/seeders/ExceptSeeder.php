<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Setting;
use App\Models\Permission;
use App\Models\Role;

class ExceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Administration' => [
                'SchoolBillReference' => ['read','write','update'],
                'SchoolBillStudent' => ['read','write','update'],
            ]
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
