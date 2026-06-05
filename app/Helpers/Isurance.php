<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('bpjs_template_options')) {

    function bpjs_template_options()
    {
        $conf = config('modules.hrms.features.benefit.insurance.bpjs');
        $output = [];

        foreach ($conf['kesehatan'] as $kelas => $rows) {
            $group = "BPJS Kesehatan - $kelas";
            foreach ($rows as $row) {
                $output[$group][] = [
                    'value' => $row['value'],
                    'label' => $row['label'],
                    'data' => json_encode($row['items']),
                ];
            }
        }

        foreach ($conf['ketenagakerjaan'] as $row) {
            $group = "BPJS Ketenagakerjaan";
            $output[$group][] = [
                'value' => $row['value'],
                'label' => $row['label'],
                'data' => json_encode($row['items']),
            ];
        }

        return $output;
    }
}


if (!function_exists('bpjs_max_salary')) {

    function bpjs_max_salary()
    {
        return Cache::remember('bpjs_max_salary', 86400, function () {
            return setting('cmp_insurance_max_salary')
                ?: (config('modules.hrms.features.benefit.insurance.maxSalary') ?? 0);
        });
    }
}

if (!function_exists('bpjs_min_salary')) {

    function bpjs_min_salary()
    {
        return Cache::remember('bpjs_min_salary', 86400, function () {
            return setting('cmp_insurance_min_salary')
                ?: (config('modules.hrms.features.benefit.insurance.minSalary') ?? 0);
        });
    }
}

if (!function_exists('bpjs_tk_max_salary')) {

    function bpjs_tk_max_salary()
    {
        return Cache::remember('bpjs_tk_max_salary', 86400, function () {
            return setting('cmp_insurance_tk_max_salary')
                ?: (config('modules.hrms.features.benefit.insurance.tkMaxSalary') ?? 0);
        });
    }
}

if (!function_exists('bpjs_tk_pensiun_max_salary')) {

    function bpjs_tk_pensiun_max_salary()
    {
        return Cache::remember('bpjs_tk_pensiun_max_salary', 86400, function () {
            return setting('cmp_insurance_tk_pensiun_max_salary')
                ?: (config('modules.hrms.features.benefit.insurance.tkPensiunMaxSalary') ?? 0);
        });
    }
}

if (!function_exists('bpjs_tk_min_salary')) {

    function bpjs_tk_min_salary()
    {
        return Cache::remember('bpjs_tk_min_salary', 86400, function () {
            return setting('cmp_insurance_tk_min_salary')
                ?: (config('modules.hrms.features.benefit.insurance.tkMinSalary') ?? 0);
        });
    }
}

if (!function_exists('bpjs_kes_limit')) {

    function bpjs_kes_limit()
    {
        return Cache::remember('bpjs_kes_limit', 86400, function () {
            return setting('cmp_insurance_kes_limit')
                ?: (config('modules.hrms.features.benefit.insurance.kesLimit') ?? 0);
        });
    }
}
