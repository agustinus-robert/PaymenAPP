<?php

namespace Modules\Portal\Http\Requests\Schedule;

use App\Http\Requests\FormRequest;
use Modules\HRMS\Models\EmployeeContract;
use Modules\HRMS\Models\EmployeeContractSchedule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', EmployeeContractSchedule::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'contract_id'       => 'required|exists:' . (new EmployeeContract())->getTable() . ',id',
            'start_at'          => 'required',
            'end_at'            => 'required',
            'dates.*.*.*'       => 'nullable|date_format:H:i',
            'workdays_count'    => 'required|numeric'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'contract_id'       => 'kontrak',
            'start_at'          => 'tanggal mulai',
            'end_at'            => 'tanggal selesai',
            'dates.*'           => 'waktu',
            'dates.*.*'         => 'waktu',
            'dates.*.*.*'       => 'waktu',
            'workdays_count'    => 'hari efektif',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];
        foreach ($this->input('dates') as $date => $shifts) {
            foreach ($shifts as $times) {
                $filled = is_array($times) && count(array_filter($times)) == 2;
                $dates[$date][] = [
                    $filled ? ($date . ' ' . $times[0] . ':00') : null,
                    $filled ? ((strtotime($times[1]) < strtotime($times[0])) ? date('Y-m-d', strtotime($date . ' +1 days')) . ' ' . $times[1] . ':00' : $date . ' ' . $times[1] . ':00') : null
                ];
            }
        }

        return array_merge($this->only('contract_id', 'workdays_count', 'start_at', 'end_at'), [
            'dates' => $dates,
        ]);
    }
}
