<?php

namespace Modules\Account\Http\Requests\User\Password;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize ()
    {
        return $this->user()->can('update', $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules ()
    {
        return [
            'old_password'  => 'required|current_password',
            'password'      => 'required|string|min:4|max:191|confirmed'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes ()
    {
        return [
            'old_password' => 'sandi lama',
            'password' => 'sandi',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform ()
    {
        return $this->only('password');
    }
}