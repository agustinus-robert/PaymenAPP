<?php

namespace Modules\Web\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Modules\Web\Http\Controllers\Controller;
use Modules\Web\Http\Requests\Payment\StoreRequest;

class HomeController extends Controller {

    protected $themeConfig;
    protected $prefix;

    public function __construct() {
        parent::__construct();

        $configPath = base_path('modules/Web/Http/Controllers/Payment/Config.php');
        if (file_exists($configPath)) {
            $this->themeConfig = require $configPath;
        }
        $this->prefix = 'web::payment.home';
    }

    public function index(Request $request)
    {
        $allSections = [
            $this->prefix.'.section-content' => [
                'order' => 1,
                'data'  => [
                    'canEdit' => false
                ]
            ]
        ];

        $this->setSections($allSections);

        return view($this->prefix.'.init', [
            'sections' => $this->getPageSections()
        ]);
    }

    public function store(StoreRequest $request){
        $data = $request->transformed();

        return response()->json([
            'status'  => 'success',
            'message' => 'Transfer berhasil diproses.',
            'data'    => $data
        ]);
    }
}
