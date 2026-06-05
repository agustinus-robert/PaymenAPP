<?php

use Carbon\Carbon;
use Modules\Core\Models\CompanyVacationCategory;

function getQuotaNow($employee, $year)
{
    $diffYears  = $year - (Carbon::parse($employee->joined_at)->format('Y'));
    $diffMonth = $employee->joined_at
        ? $employee->joined_at->diffInMonths(Carbon::create($year, 1)->startOfMonth())
        : 0;

    if ($diffMonth < 6 && $diffYears <= 1) {
        return [
            'quota_id' => 1,
            'value'    => 0
        ];
    } else if ($diffMonth >= 6 && $diffYears <= 1) {
        return [
            'quota_id' => 1,
            'value'    => $year == now()->format('Y') ? (12 - ($employee->joined_at->format('m')) - 1) : CompanyVacationCategory::find(1)->meta?->quota
        ];
    } else if ($diffMonth >= 12 && $diffYears == 1) {
        return [
            'quota_id' => 1,
            'value'    => CompanyVacationCategory::find(1)->meta?->quota
        ];
    } else if ($diffMonth > 24 || $diffYears >= 2) {
        return ($diffYears <= 4)
            ? ['quota_id' => CompanyVacationCategory::find(1)->id, 'value' => CompanyVacationCategory::find(1)->meta?->quota]
            : (in_array($diffYears, [6, 11, 15, 21, 26, 31, 36])
                ? ['quota_id' => CompanyVacationCategory::find(3)->id, 'value' => CompanyVacationCategory::find(3)->meta?->quota]
                : ['quota_id' => CompanyVacationCategory::find(2)->id, 'value' => CompanyVacationCategory::find(2)->meta?->quota]);
    }
}
