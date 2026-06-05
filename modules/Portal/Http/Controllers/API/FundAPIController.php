<?php

namespace Modules\Portal\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Account\Models\UserBalance;
use Modules\Web\Http\Requests\Fund\StoreRequest;
use Modules\Web\Repositories\FundRepositories;
use Exception;

class FundAPIController extends Controller
{
    use FundRepositories;

    /**
     * Menampilkan daftar semua saldo user dengan paginasi.
     * * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $balances = UserBalance::with(['user', 'logs'])
            ->where('user_balance_id', auth()->id())
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar saldo user berhasil diambil berdasarkan token.',
            'data'    => $balances->items(),
            'meta'    => [
                'current_page' => $balances->currentPage(),
                'last_page'    => $balances->lastPage(),
                'per_page'     => $balances->perPage(),
                'total'        => $balances->total(),
            ],
            'links'   => [
                'first' => $balances->url(1),
                'last'  => $balances->url($balances->lastPage()),
                'prev'  => $balances->previousPageUrl(),
                'next'  => $balances->nextPageUrl(),
            ]
        ], 200);
    }

    /**
     * Memproses mutasi saldo baru (Top Up / Withdraw) via API.
     *  @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->transformed();

        if (isset($data['status']) && $data['status'] === false) {
            return response()->json([
                'success' => false,
                'message' => $data['message']
            ], 401);
        }

        try {
            $fund = $this->storeFundMutation($data);

            return response()->json([
                'success'     => true,
                'message'     => 'Mutasi berhasil diproses.',
                'activity_id' => $fund->id,
                'data'        => [
                    'amount'            => $data['amount'],
                    'mutation_type'     => $data['mutation_type'],
                    'adjustment_status' => $data['adjustment_status'],
                    'log_user'          => $data['log_user']
                ]
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


   /**
     * Menampilkan total saldo saat ini beserta seluruh rincian riwayat transaksi user.
     * * @return JsonResponse
     */
    public function showUserBalance(): JsonResponse
    {
        $userId = auth()->id();
        $latestBalanceRecord = UserBalance::where('user_balance_id', $userId)
            ->latest('id')
            ->first();

        $totalSaldo = $latestBalanceRecord ? (float) $latestBalanceRecord->amount : 0;
        $activities = UserBalance::with(['logs'])
            ->where('user_balance_id', $userId)
            ->latest('id')
            ->get();

        if ($activities->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki riwayat transaksi aktif.'
            ], 404);
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Rincian saldo dan riwayat transaksi berhasil diambil.',
            'total_saldo' => $totalSaldo,
            'data'        => $activities
        ], 200);
    }

    /**
     * Menampilkan detail saldo berdasarkan ID tertentu.
     *  @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $balance = UserBalance::with(['user', 'logs'])->find($id);

        if (!$balance) {
            return response()->json([
                'success' => false,
                'message' => 'Data saldo tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail saldo user berhasil diambil.',
            'data'    => $balance
        ], 200);
    }
}
