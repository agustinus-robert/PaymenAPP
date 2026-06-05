<?php

namespace Modules\Web\Http\Requests\Fund;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mutation_type' => ['required', 'in:top_up,withdraw'],
            'amount'        => ['required', 'integer', 'min:10000'],
            'note'          => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'mutation_type.required' => 'Jenis aktivitas mutasi harus ditentukan.',
            'mutation_type.in'       => 'Jenis aktivitas mutasi tidak valid.',
            'amount.required'        => 'Nominal tidak boleh kosong.',
            'amount.integer'         => 'Nominal harus berupa angka bersih.',
            'amount.min'             => 'Nominal transaksi minimal adalah Rp 10.000.',
            'note.max'               => 'Catatan tidak boleh lebih dari 255 karakter.',
        ];
    }

    public function transformed(): array
    {
        $validated = $this->validated();

        if (auth()->check() == false) {
            return [
                'status'  => false,
                'message' => 'Anda belum login',
            ];
        }

        $adjustmentStatus = ($validated['mutation_type'] === 'top_up') ? 1 : 2;

        return [
            'status'            => 'success',
            'user_balance_id'   => auth()->id(),
            'mutation_type'     => $validated['mutation_type'],
            'amount'            => (int) $validated['amount'],
            'adjustment_status' => $adjustmentStatus,
            'log_user'          => $validated['note'] ?? (($adjustmentStatus === 1) ? 'Tambah saldo' : 'Penarikan saldo'),
            'created_at'        => now(),
        ];
    }
}
