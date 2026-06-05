<?php

namespace Modules\Web\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Modules\Account\Models\UserBalance;
use Modules\Web\Http\Controllers\Controller;
use Modules\Web\Http\Requests\Fund\StoreRequest;
use Modules\Web\Repositories\FundRepositories;


class FundController extends Controller {

    use FundRepositories;

    protected $themeConfig;
    protected $prefix;

    public function __construct() {
        parent::__construct();

        $configPath = base_path('modules/Web/Http/Controllers/Payment/Config.php');
        if (file_exists($configPath)) {
            $this->themeConfig = require $configPath;
        }
        $this->prefix = 'web::payment.fund';
    }

    public function index(Request $request)
    {
        $activities = UserBalance::with(['logs'])
            ->where('user_balance_id', auth()->id())
            ->latest()
            ->get();

        $allSections = [
            $this->prefix.'.section-content' => [
                'order' => 1,
                'data'  => [
                    'activities' => $activities,
                    'canEdit'    => false
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
        $fund = $this->storeFundMutation($data);
        if($fund){
            return response()->json([
                'status'  => 'success',
                'message' => 'Mutasi berhasil diproses.',
                'activity_id' => $fund->id,
                'data'    => $data
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Mutasi gagal diproses.',
            'data'    => $data
        ]);
    }
}
