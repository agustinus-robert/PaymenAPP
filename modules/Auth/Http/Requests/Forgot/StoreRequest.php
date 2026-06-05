<?php

namespace Modules\Auth\Http\Requests\Forgot;

use Modules\Account\Models\User;
use Modules\Account\Rules\VerifiedEmail;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $model = config('auth.providers.users.model');
        
        return [
            'email'   => ['required', 'string', 'email', 'exists:'.(new $model())->getTable().',email_address', new VerifiedEmail],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'email' => 'alamat surel'
        ];
    }

    /**
     * Transform request data
     */
    public function transformed()
    {
        return [
            'email_address' => $this->input('email')
        ];
    }
}
