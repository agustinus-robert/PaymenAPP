<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function call(Request $request, $controller = 'home', $method = 'index', $param = null)
    {
        $theme = ucfirst(setting_gett('theme', 'payment')->value);

        $class = "\\Modules\\Web\\Http\\Controllers\\{$theme}\\" . ucfirst($controller) . "Controller";

        if (!class_exists($class)) {
            abort(404);
        }

        $instance = app($class);

        if (!method_exists($instance, $method)) {
            abort(404);
        }

        return app()->call([$instance, $method], [
            'request' => $request,
            'param'   => $param
        ]);
    }
}
