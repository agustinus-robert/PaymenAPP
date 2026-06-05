<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        return '0.0.0.0';
        // return Request::ip();
        // return Http::acceptJson()->get('http://ipinfo.io')->object()->ip;
    }
}
