<?php

namespace Modules\Portal\Http\Requests\Holiday\Submission;

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
        return [
            'dates.*'  => 'required|date_format:Y-m-d|after_or_equal:today|distinct',
            'start_at' => 'nullable|before:end_at',
            'end_at'   => 'nullable|after:start_at',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'dates.*'  => 'tanggal',
            'start_at' => 'tanggal mulai',
            'end_at'   => 'tanggal berakhir',
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
                't_s' => $this->input('time_start'),
                't_e' => $this->input('time_end')
            ]);
        }

        return [
            'start_at' => $this->input('start_at'),
            'end_at' => $this->input('end_at'),
            'dates' => $dates,
        ];
    }
}
