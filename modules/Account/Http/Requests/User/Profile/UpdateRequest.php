<?php

namespace Modules\Account\Http\Requests\User\Profile;

use App\Rules\UniqueMetaValue;
use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Account\Models\User;
use Modules\Account\Enums\SexEnum;
use Modules\Account\Enums\BloodEnum;
use Modules\Account\Enums\ReligionEnum;

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
            'profile_prefix'    => 'nullable|string|max:191',
            'name'              => 'required|string|max:191',
            'profile_suffix'    => 'nullable|string|max:191',
            'profile_sex'       => ['nullable', new Enum(SexEnum::class)],
            'profile_pob'       => 'nullable|string|max:191',
            'profile_dob'       => 'nullable|string|date_format:Y-m-d',
            'profile_blood'     => ['nullable', new Enum(BloodEnum::class)],
            'profile_religion'  => ['nullable', new Enum(ReligionEnum::class)]
            // 'profile_nik'       => ['nullable', 'numeric', new UniqueMetaValue(User::class, 'profile_nik', $this->user()->profile_nik)],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'profile_prefix'    => 'gelar depan',
            'name'              => 'nama lengkap',
            'profile_suffix'    => 'gelar belakang',
            'profile_sex'       => 'jenis kelamin',
            'profile_pob'       => 'tempat lahir',
            'profile_dob'       => 'tanggal lahir',
            'profile_blood'     => 'golongan darah',
            'profile_religion'  => 'agama'
        ];
    }

    /**
     * Transform request data into expected output.
     */
    public function transform()
    {
        return $this->only('name', 'profile_prefix', 'profile_suffix', 'profile_sex', 'profile_pob', 'profile_dob', 'profile_blood', 'profile_religion');
    }
}
