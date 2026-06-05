<?php

namespace Modules\Account\Http\Requests\User\Phone;

use App\Rules\UniqueMetaValue;
use App\Http\Requests\FormRequest;
use Modules\Reference\Models\Country;
use Modules\Account\Models\User;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            // 'phone_code'     => ['required', 'in:' . Country::select('phones', 'code')->get()->pluck('phones', 'code')->flatten()->join(',')],
            'phone_code' => 'required',
            'phone_number'   => ['required', 'numeric', new UniqueMetaValue(User::class, 'phone_number', $this->user()->getMeta('phone_number'))],
            'phone_whatsapp' => 'boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'phone_code'        => 'kode negara',
            'phone_number'      => 'nomor ponsel',
            'phone_whatsapp'    => 'whatsapp'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'phone_code' => $this->input('phone_code'),
            'phone_number' => $this->input('phone_number'),
            'phone_whatsapp' => (bool) $this->input('phone_whatsapp')
        ];
    }
}
