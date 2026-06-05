<?php

namespace Modules\Portal\Http\Requests\Vacation\Cancelation;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'dates.*'           => 'required|date_format:Y-m-d|in:'.$this->vacation->dates->implode('d', ',')
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'dates.*'           => 'tanggal'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = $this->vacation->dates->map(function ($date) {
                    $date['c'] = in_array($date['d'], $this->input('dates'));
                    return array_filter($date);
                })->toArray();

        $this->merge(compact('dates'));

        return $this->validated();
    }
}