<?php

namespace Modules\Account\Http\Requests\User\Username;

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
            'username' => 'required|min:4|max:191|regex:/^[a-z\d.]{4,20}$/|unique:' . (new $model())->getTable() . ',username,' . $this->user()->id,
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'username'  => 'username',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'username' => strtolower($this->input('username'))
        ];
    }
}
