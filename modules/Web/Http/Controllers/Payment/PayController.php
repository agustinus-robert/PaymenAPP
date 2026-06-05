<?php

namespace Modules\Web\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Web\Http\Controllers\Controller;
use Modules\Web\Models\PayTransaction;
use Modules\Web\Http\Requests\Payment\StoreRequest;
use Modules\Web\Repositories\PaymentRepositories;


class PayController extends Controller {

    use PaymentRepositories;

    protected $themeConfig;
    protected $prefix;

    public function __construct() {
        parent::__construct();

        $configPath = base_path('modules/Web/Http/Controllers/Payment/Config.php');
        if (file_exists($configPath)) {
            $this->themeConfig = require $configPath;
        }
        $this->prefix = 'web::payment.pay';
    }

    public function index(Request $request)
    {
        $activities = PayTransaction::with(['sender', 'receiver', 'logs'])
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $customers = User::where('id', '!=', auth()->id())
        ->get()
        ->map(function ($user) {
            return [
                'id'    => $user->id,
                'label' => $user->name,
            ];
        });

        $allSections = [
            $this->prefix.'.section-content' => [
                'order' => 1,
                'data'  => [
                    'user' => $customers,
                    'activities' => $activities,
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
        $transaction = $this->storePayment($data);
        if($transaction){
            return response()->json([
                'status'  => 'success',
                'message' => 'Transfer berhasil diproses.',
                'transaction_code' => $transaction->transaction_code,
                'data'    => $data
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Transfer gagal diproses.',
            'data'    => $data
        ]);
    }
}
