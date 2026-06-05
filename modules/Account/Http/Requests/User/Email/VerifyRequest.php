<?php

namespace Modules\Account\Http\Requests\User\Email;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class VerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        try {

            $this->merge([
                'token' => decrypt($this->query('token'))
            ]);
        } catch (DecryptException $e) {

            return abort(404);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'token'     => 'string'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return $this->only('token');
    }
}
