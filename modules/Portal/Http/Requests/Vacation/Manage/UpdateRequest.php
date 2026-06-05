<?php

namespace Modules\Portal\Http\Requests\Vacation\Manage;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Http\Requests\FormRequest;
use Modules\Core\Enums\ApprovableResultEnum;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'result' => ['required', new Enum(ApprovableResultEnum::class)],
            'reason' => [
                'nullable',
                Rule::requiredIf(function() {
                    $result = ApprovableResultEnum::tryFrom((int) $this->input('result'));
                    return $result ? $result->reasonRequirement() : false;
                })
            ]
        ];
    }
    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'result'            => 'status',
            'reason'            => 'alasan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return collect($this->validated());
    }
}
