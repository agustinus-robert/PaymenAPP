<?php

namespace Modules\HRMS\Models\Traits;

use Illuminate\Support\Facades\Log;
use Modules\Account\Enums\MariageEnum;
use Modules\Account\Enums\ReligionEnum;
use Modules\Account\Enums\SexEnum;
use Modules\Account\Models\User;
use Modules\HRMS\Models\Employee;

trait EmployeeTrait
{
    /**
     * Complete insert.
     */
    public static function updateEmployeeViaImport($data)
    {
        if (!$data['id_karyawan']) {
            Log::warning("Skipping row: Employee with with empty ID.");
            return; // Exit the function for this row
        }
        // Attempt to find the employee by ID
        $employee = Employee::find($data['id_karyawan'] ?? null);

        // Skip if the employee is not found
        if (!$employee) {
            Log::warning("Skipping row: Employee with ID {$data['id_karyawan']} not found.");
            return; // Exit the function for this row
        }

        // Find the user associated with the employee
        $user = User::find($employee->user_id);

        // Skip if the user is not found
        if (!$user) {
            Log::warning("Skipping row: User associated with employee ID {$data['id_karyawan']} not found.");
            return; // Exit the function for this row
        }

        // Enum parsing
        $sex = SexEnum::forceTryFrom(trim($data['jenis_kelamin'] ?? ''));
        $status = MariageEnum::forceTryFrom(trim($data['status'] ?? ''));
        $religion = ReligionEnum::forceTryFrom(trim($data['agama'] ?? ''));

        // Update user attributes
        $user->fill([
            'name' => trim($data['nama'] ?? $user->name),
            'email_address' => trim($data['email'] ?? $user->email_address),
        ]);

        if ($user->save()) {
            // Update user meta data only if values are not null
            if (!is_null($sex)) {
                $user->setMeta('profile_sex', $sex->value);
            }
            if (!empty(trim($data['alamat'] ?? ''))) {
                $user->setMeta('profile_address', trim($data['alamat']));
            }
            if (!empty(trim($data['nik'] ?? ''))) {
                $user->setMeta('profile_nik', trim($data['nik']));
            }
            if (!empty(trim($data['npwp'] ?? ''))) {
                $user->setMeta('tax_number', trim($data['npwp']));
            }
            if (!is_null($status)) {
                $user->setMeta('profile_mariage', $status->value);
            }
            if (!is_null($data['jumlah_tanggungan'] ?? null)) {
                $user->setMeta('profile_child', (int) $data['jumlah_tanggungan']);
            }
            if (!is_null($religion)) {
                $user->setMeta('profile_religion', $religion->value);
            }
            if (!empty(trim($data['no_hp'] ?? ''))) {
                $user->setMeta('phone_number', trim($data['no_hp']));
            }
        } else {
            Log::warning("Failed to save user with ID {$user->id}.");
        }
    }
}
