<?php
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


if (!function_exists('cfg')) {
    /*
     * Get config
     */
    function cfg($kd)
    {
        return \App\Models\Config::where('kd', $kd)->first();
    }
}


if (!function_exists('isLevelOne')) {
    /**
     * Cek apakah user memiliki posisi level 1
     *
     * @param  Authenticatable|null $user
     * @return bool
     */
    function isLevelOne(?Authenticatable $user): bool
    {
        return $user
            && $user->employee
            && $user->employee->position
            && $user->employee->position->position_id == 1;
    }
}

if (!function_exists('isSuperUser')) {
    /**
     * Cek apakah user adalah superuser
     *
     * @param  Authenticatable|null $user
     * @return bool
     */
    function isSuperUser(?Authenticatable $user): bool
    {
        // return $user
        //     && $user->roles->first()->id == 1;

        return $user && $user->roles()->where('id', 1)->exists();
    }
}

if (!function_exists('cfgval') && function_exists('cfg')) {
    /*
     * Get config value
     */
    function cfgval($kd)
    {
        return cfg($kd)->val ?? null;
    }
}

if (!function_exists('cfgupd') && function_exists('cfg')) {
    /*
     * Update config value
     */
    function cfgupd($kd, $val)
    {
        return cfg($kd)->update(['val' => $val]);
    }
}

if (!function_exists('cutoff')) {
    function cmp_cutoff($index)
    {
        return Carbon::parse(
            array_reduce(setting('cmp_cutoff_date')[$index] ?? [], fn ($result, $time) => strtotime($time, $result ?? null))
        );
    }
}



if (!function_exists('getGrade')) {
    /*
     * getGrade
     */
    function getGrade()
    {
        $gradeId = Auth::user()?->employee?->grade_id ?? 0;
        return \App\Models\References\Grade::find($gradeId);
    }
}

if (!function_exists('hexToRgba')) {
    function hexToRgba($hex, $alpha = 0.03) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) === 3) {
            $r = hexdec(str_repeat($hex[0], 2));
            $g = hexdec(str_repeat($hex[1], 2));
            $b = hexdec(str_repeat($hex[2], 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "rgba($r, $g, $b, $alpha)";
    }
}


if (!function_exists('parseJsonColumn')) {
    function parseJsonColumn($column)
    {
        if (!str_contains($column, '->')) {
            return $column;
        }

        $parts = preg_split('/(->>|->)/', $column);
        $operators = [];
        preg_match_all('/(->>|->)/', $column, $operators);

        $sql = "{$parts[0]}::jsonb";

        foreach ($operators[0] as $i => $op) {
            $key = trim($parts[$i + 1]);
            $sql .= " $op '$key'";
        }

        return DB::raw("($sql)::numeric");
    }
}
