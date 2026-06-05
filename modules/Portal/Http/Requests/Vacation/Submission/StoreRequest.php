<?php

namespace Modules\Portal\Http\Requests\Vacation\Submission;

use App\Http\Requests\FormRequest;

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
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'dates' => array_filter($this->input('dates')),
            'as_freelances' => array_filter($this->input('as_freelances')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $quotas = $this->user()->employee->vacationQuotas()->with('vacations')->active()->get();

        return [
            'quota_id'          => 'required|in:' . $quotas->implode('id', ','),
            'dates.*'           => 'required|date_format:Y-m-d|distinct',
            'as_freelances.*'   => 'nullable|boolean',
            'description'       => 'nullable|string'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'quota_id'          => 'jenis cuti/libur hari raya',
            'dates.*'           => 'tanggal',
            'as_freelances.*'   => 'pilihan freelance',
            'description'       => 'keperluan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];
        foreach ($this->input('dates') as $i => $date) {
            $dates[] = array_filter([
                'd' => $date,
                'f' => ($this->input('as_freelances')[$i] ?? 0) == 1
            ]);
        }

        return [
            'quota_id' => $this->input('quota_id'),
            'dates' => $dates,
            'description' => $this->input('description')
        ];
    }
}
