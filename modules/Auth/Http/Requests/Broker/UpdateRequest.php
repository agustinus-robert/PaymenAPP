<?php

namespace Modules\Auth\Http\Requests\Broker;

use Modules\Account\Models\User;
use Modules\Account\Rules\VerifiedEmail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return [
            'token' => 'required',
            'email' => 'required|exists:users,email',
            'password' => 'required|confirmed|min:4',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'password' => 'sandi'
        ];
    }

    /**
     * Transform request data
     */
    public function transformed()
    {
        return [
            'email' => $this->input('email'),
            'token' => $this->input('token'),
            'password' => $this->input('password'),
            'password_confirmation' => $this->input('password_confirmation')
        ];
    }
}
