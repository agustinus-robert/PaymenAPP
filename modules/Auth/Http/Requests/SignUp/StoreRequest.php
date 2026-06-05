<?php

namespace Modules\Auth\Http\Requests\SignUp;

use Str;
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:'.(new $model())->getTable().',email_address',
            'password'  => 'required|confirmed|min:4',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'alamat surel',
            'password' => 'sandi'
        ];
    }

    /**
     * Transform the requests into expected array.
     */
    public function transformed()
    {
        return [
            'name' => $this->input('name'),
            'email_address' => $this->input('email'),
            'username' => Str::before($this->input('email'), '@').rand(10, 499),
            'password' => $this->input('password')
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function messages()
    {
        return [
            'email.unique' => 'Isian :attribute sudah digunakan oleh orang lain, silahkan gunakan :attribute lainnya.'
        ];
    }
}
