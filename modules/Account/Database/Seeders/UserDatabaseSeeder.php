<?php

namespace Modules\Account\Database\Seeders;

use Carbon\Carbon;
use Modules\Account\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Modules\Account\Enums\ReligionEnum;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $dataUsersRaw = [
            ['name' => 'Administrator', 'pos' => 1, 'sex' => 'male', 'unit' => 1, 'rel' => 1, 'mar' => 'single', 'child' => 0],
            ['name' => 'Robert Webdev', 'pos' => 1, 'sex' => 'male', 'unit' => 1, 'rel' => 3, 'mar' => 'mariage', 'child' => 1],

            ['name' => 'Budi Santoso', 'pos' => 2, 'sex' => 'male', 'unit' => 2, 'rel' => 1, 'mar' => 'mariage', 'child' => 3],
            ['name' => 'Siti Aminah', 'pos' => 2, 'sex' => 'female', 'unit' => 2, 'rel' => 1, 'mar' => 'mariage', 'child' => 2],
            ['name' => 'Diana Putri', 'pos' => 2, 'sex' => 'female', 'unit' => 2, 'rel' => 2, 'mar' => 'single', 'child' => 0],

            ['name' => 'Anton Wijaya', 'pos' => 3, 'sex' => 'male', 'unit' => 11, 'rel' => 1, 'mar' => 'single', 'child' => 0],
            ['name' => 'Eko Prasetyo', 'pos' => 3, 'sex' => 'male', 'unit' => 11, 'rel' => 1, 'mar' => 'mariage', 'child' => 1],
            ['name' => 'Rina Lestari', 'pos' => 3, 'sex' => 'female', 'unit' => 11, 'rel' => 1, 'mar' => 'mariage', 'child' => 0],
            ['name' => 'Gerry Salim', 'pos' => 3, 'sex' => 'male', 'unit' => 12, 'rel' => 3, 'mar' => 'single', 'child' => 0],
            ['name' => 'Lusi Natalia', 'pos' => 3, 'sex' => 'female', 'unit' => 12, 'rel' => 2, 'mar' => 'mariage', 'child' => 2],
            ['name' => 'Andi Hermawan', 'pos' => 3, 'sex' => 'male', 'unit' => 13, 'rel' => 1, 'mar' => 'mariage', 'child' => 3],
            ['name' => 'Maya Sofia', 'pos' => 3, 'sex' => 'female', 'unit' => 13, 'rel' => 1, 'mar' => 'single', 'child' => 0],

            ['name' => 'Dedi Kurniawan', 'pos' => 4, 'sex' => 'male', 'unit' => 21, 'rel' => 1, 'mar' => 'mariage', 'child' => 2],
            ['name' => 'Sari Indah', 'pos' => 4, 'sex' => 'female', 'unit' => 21, 'rel' => 1, 'mar' => 'single', 'child' => 0],
            ['name' => 'Iwan Fals', 'pos' => 4, 'sex' => 'male', 'unit' => 21, 'rel' => 1, 'mar' => 'mariage', 'child' => 4],
            ['name' => 'Agus Kotak', 'pos' => 4, 'sex' => 'male', 'unit' => 22, 'rel' => 1, 'mar' => 'mariage', 'child' => 1],
            ['name' => 'Nina Bobo', 'pos' => 4, 'sex' => 'female', 'unit' => 22, 'rel' => 2, 'mar' => 'single', 'child' => 0],
            ['name' => 'Joko Widodo', 'pos' => 4, 'sex' => 'male', 'unit' => 23, 'rel' => 1, 'mar' => 'mariage', 'child' => 3],
            ['name' => 'Prabowo Subianto', 'pos' => 4, 'sex' => 'male', 'unit' => 23, 'rel' => 1, 'mar' => 'single', 'child' => 0],
            ['name' => 'Megawati', 'pos' => 4, 'sex' => 'female', 'unit' => 23, 'rel' => 1, 'mar' => 'mariage', 'child' => 2],
        ];

        foreach ($dataUsersRaw as $key => $value) {
            $user = User::create([
                'name' => $value['name'],
                'username' => $this->generateUsername($value['name']),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'current_team_id' => 1
            ]);

            $user->setMeta('profile_sex', $value['sex']);
            $user->setMeta('profile_religion', $value['rel']);
            $user->setMeta('profile_mariage', $value['mar']);
            $user->setMeta('profile_child', $value['child'] > 3 ? 3 : $value['child']);

            $empl = $user->employee()->create([
                'joined_at' => Carbon::parse('2024-01-01'),
                'grade_id' => $value['unit']
            ]);

            $creatorId = User::first()->id ?? $user->id;
            $contract = $empl->contract()->create([
                'kd' => ($key + 1) . '/SLCMS/' . $value['unit'] . '/' . date('Y'),
                'contract_id' => 2, // Tetap 2 sesuai seeder lama
                'work_location' => 1,
                'start_at' => '2024-01-01 00:00:00',
                'end_at' => null,
                'created_by' => $creatorId,
                'updated_by' => $creatorId
            ]);

            $contract->position()->create([
                'empl_id' => $empl->id,
                'position_id' => $value['pos'],
                'start_at' => $contract->start_at,
                'end_at' => $contract->end_at,
            ]);
        }
    }

    public function generateUsername($name)
    {
        $clean = strtolower(str_replace(' ', '', $name));
        return substr($clean, 0, 8) . rand(10, 99);
    }
}
