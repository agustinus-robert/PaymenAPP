<?php

namespace Modules\Portal\Http\Requests\Reimbursement\Submission;

use App\Http\Requests\FormRequest;
use DateTimeInterface;
use Modules\Core\Models\CompanyReimbursementCategory;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return isset($this->user()->employee);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'transaction_at'    => 'required|date_format:Y-m-d\TH:i|before_or_equal:now',
            'ctg_id'            => 'required|exists:' . (new CompanyReimbursementCategory)->getTable() . ',id',
            'amount'            => 'required|numeric',
            'method'            => 'required|in:' . implode(',', CompanyReimbursementCategory::find($this->input('ctg_id'))->meta->method),
            'description'       => 'nullable|max:191',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'transaction_at'    => 'tanggal transaksi',
            'ctg_id'            => 'kategori',
            'amount'            => 'jumlah/nominal',
            'method'            => 'metode pembayaran',
            'description'       => 'deskripsi',
            'attachment'        => 'lampiran'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return array_merge(
            $this->only('transaction_at', 'ctg_id', 'amount', 'method', 'description'),
            [
                'attachment' => $this->handleUploadedFile()
            ]
        );
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        return $this->has('attachment') ? $this->file('attachment')->store('users/' . $this->user()->id . '/employees/reimbursements') : null;
    }
}
