<?php

namespace Modules\Portal\Http\Requests\Asset\Device;

use Illuminate\Validation\Rules\Enum;
use App\Http\Requests\FormRequest;
use Modules\Core\Enums\InventoryConditionEnum;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'condition.*' => ['required', new Enum(InventoryConditionEnum::class)],
            'description.*' => 'nullable'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'condition.*' => 'kondisi inventaris',
            'description.*' => 'keterangan'
        ];
    }


    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'condition' => array_values($this->input('condition')),
            'description' => array_values($this->input('description'))
        ];
    }
}
