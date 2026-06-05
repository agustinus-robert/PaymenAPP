<?php

use App\Models\Setting;
use Modules\Poz\Models\Outlet;
use Modules\Poz\Models\Category;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->first()?->value ?: $default;
    }
}

if (!function_exists('setting_set')) {
    function setting_set($key, $value)
    {
        Setting::updateOrCreate(compact('key'), compact('value'));
    }
}


if (!function_exists('outletList')) {
    function outletList($adminId)
    {
        return Outlet::whereNull('deleted_at')->where('admin_id', $adminId)->get();
    }
}

if (!function_exists('setting_list')) {
    function setting_gett($key, $value){
        return Setting::where('key', $key)
        ->where('value', $value)
        ->first();
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        $angka = floatval($angka);

        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if(!function_exists('categoryList')){
    function categoryList(){
        return Category::whereNull('deleted_at')->get();
    }
}
