<?php

namespace Modules\Portal\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Web\Models\PayTransaction;
use Modules\Account\Models\User;
use Modules\Web\Http\Requests\Payment\StoreRequest;
use Modules\Web\Repositories\PaymentRepositories;
use Exception;

class PayAPIController extends Controller
{
    use PaymentRepositories;

    /**
     * Menampilkan riwayat transaksi (transfer) user sekaligus total saldo saat ini.
     * Dipasang paling atas luar data agar frontend mudah membacanya.
     * * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $userBalance = auth()->user()->balance->amount ?? 0;
        $activities = PayTransaction::with(['sender', 'receiver', 'logs'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        return response()->json([
            'success'     => true,
            'message'     => 'Riwayat transaksi transfer berhasil diambil.',
            'total_saldo' => (float) $userBalance,
            'data'        => $activities
        ], 200);
    }

    /**
     * Mengambil semua data user penerima/recipient
     * * @param StoreRequest $request
     * @return JsonResponse
     */
    public function getRecipients(): JsonResponse
    {
        try {
            $currentUserId = auth()->id();
            $recipients = User::where('id', '!=', $currentUserId)
                ->orderBy('name', 'asc')
                ->get()
                ->map(function ($user) {
                    return [
                        'id'    => $user->id,
                        'name'  => $user->name,
                        'email' => $user->email,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Daftar penerima transfer berhasil diambil.',
                'data'    => $recipients
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar penerima: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Memproses transaksi transfer antar-user baru via API.
     * * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        // Ambil data yang sudah ditransformasikan di StoreRequest
        $data = $request->transformed();

        // Antisipasi jika token tidak terbaca/invalid pada pengecekan Form Request
        if (isset($data['status']) && $data['status'] === false) {
            return response()->json([
                'success' => false,
                'message' => $data['message']
            ], 401);
        }

        try {
            // Jalankan database transaction aman dari trait PaymentRepositories
            $transaction = $this->storePayment($data);

            return response()->json([
                'success'          => true,
                'message'          => 'Transfer berhasil diproses.',
                'transaction_code' => $transaction->transaction_code,
                'data'             => [
                    'sender_id'    => $data['sender_id'],
                    'recipient_id' => $data['recipient_id'],
                    'amount'       => $data['amount'],
                    'note'         => $data['note']
                ]
            ], 201); // Status 201 Created

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400); // Status 400 Bad Request
        }
    }

    /**
     * Menampilkan detail spesifik satu baris transaksi transfer berdasarkan ID.
     * * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $userId = auth()->id();
        $transaction = PayTransaction::with(['sender', 'receiver', 'logs'])
            ->where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->orWhere('receiver_id', $userId);
            })
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Detail transaksi tidak ditemukan atau Anda tidak memiliki akses.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diambil.',
            'data'    => $transaction
        ], 200);
    }
}
