<?php

namespace Modules\Account\Repositories\User;

use Modules\HRMS\Models\Employee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Models\User;

trait TaxRepository
{
    /**
     * Define the primary meta keys for resource
     */
    private $metaKeys = [
        'tax_status'
    ];

    /**
     * Update the specified resource in storage.
     */
    public function updateTax(Employee $employee, array $array)
    {
        if ($employee) {

            $employee->setManyMeta(Arr::only($array, $this->metaKeys));

            Auth::user()->log('memperbarui perhitungan pajak pengguna ' . $employee->user->name . ' <strong>[ID: ' . $employee->user->id . ']</strong>', Employee::class, $employee->id);

            return $employee;
        }

        return false;
    }
}
