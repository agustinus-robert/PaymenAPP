<?php

namespace Modules\Account\Http\Requests\User\Email;

use App\Http\Requests\FormRequest;

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
        $model = config('auth.providers.users.model');

        return [
            'email'     => 'required|email|max:191|not_in:' . $this->user()->email . '|unique:' . (new $model())->getTable() . ',email,' . $this->user()->id
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'email'     => 'alamat surel',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function messages()
    {
        return [
            'email.not_in' => 'Isian :attribute harus berbeda dengan :attribute sebelumnya.'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'email' => strtolower($this->input('email')),
            'email_verified_at' => null
        ];
    }
}
