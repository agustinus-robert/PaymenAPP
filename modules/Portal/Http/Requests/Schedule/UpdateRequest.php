<?php

namespace Modules\Portal\Http\Requests\Schedule;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->schedule);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
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
            'dates.*'           => 'waktu',
            'dates.*.*'         => 'waktu',
            'dates.*.*.*'       => 'waktu',
            'workdays_count'    => 'hari efektif',
        ];
    }
}
