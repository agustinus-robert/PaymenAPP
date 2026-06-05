<?php

namespace Modules\Web\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipient' => ['required', 'exists:users,id'],
            'amount'    => ['required', 'integer', 'min:10000'],
            'note'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'recipient.required' => 'Silakan pilih penerima terlebih dahulu.',
            'amount.required'    => 'Nominal tidak boleh kosong.',
            'amount.integer'     => 'Nominal harus berupa angka bersih.',
            'amount.min'         => 'Nominal transfer minimal adalah Rp 10.000.',
            'note.max'           => 'Catatan tidak boleh lebih dari 255 karakter.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $transferAmount = $this->input('amount');
            $userBalance = auth()->user()->balance->amount ?? 0;
            if (auth()->check() == true) {
                if ($transferAmount > $userBalance) {
                    $validator->errors()->add('amount', 'Saldo Anda tidak mencukupi untuk melakukan transfer ini.');
                }
            }
        });
    }

    public function transformed(): array
    {
        $validated = $this->validated();

        if (auth()->check() == false) {
            return [
                'status'   => false,
                'message' => 'Anda belum login',
            ];
        }

        return [
            'sender_id'    => auth()->user()->id,
            'recipient_id' => $validated['recipient'],
            'amount'       => (int) $validated['amount'],
            'note'         => $validated['note'] ?? '-',
            'status'       => 'success',
            'created_at'   => now(),
        ];
    }
}
