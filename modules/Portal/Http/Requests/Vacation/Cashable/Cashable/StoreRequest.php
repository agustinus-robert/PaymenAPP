<?php

namespace Modules\Portal\Http\Requests\Vacation\Cashable\Cashable;

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
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $quotas = $this->user()->employee->vacationQuotas()->with('vacations')->active()->get()->filter(fn ($quota) => $quota->category->meta->cashable_limit ?? false);
        $quota = $quotas->firstWhere('id', $this->input('quota_id'));

        return [
            'quota_id'          => 'required|in:' . $quotas->implode('id', ','),
            'days'              => 'required|min:1|max:' . ($quota->remain < $quota->category->meta->cashable_limit ? $quota->remain : $quota->category->meta->cashable_limit)
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'quota_id'          => 'jenis cuti',
            'days'              => 'jumlah hari'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $cutoff = cmp_cutoff(1)->gt(today()) ? cmp_cutoff(1) : cmp_cutoff(1)->addMonths(1);
        
        $dates = [];

        for ($i = 0; $i < $this->input('days'); $i++) {
            $dates[] = array_filter([
                'd' => '2022-12-10',
                'cashable' => true
            ]);
        }

        $quota = $this->user()->employee->vacationQuotas()->find($this->input('quota_id'));

        return [
            'quota_id' => $quota->id,
            'description' => 'Kompensasi ' . $quota->category->name,
            'dates' => $dates
        ];
    }
}
