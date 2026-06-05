<?php

namespace Modules\Account\Http\Requests\User\Achievement;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:191',
            'territory_id'      => 'required|exists:ref_territories,id',
            'type_id'           => 'required|exists:ref_achievement_types,id',
            'num_id'            => 'required|exists:ref_achievement_nums,id',
            'year'              => 'required|date_format:Y',
            'file'              => 'nullable|file|image|max:1024',
            'description'       => 'nullable|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'              => 'nama prestasi',
            'territory_id'      => 'wilayah',
            'type_id'           => 'jenis prestasi',
            'num_id'            => 'peringkat',
            'year'              => 'tahun',
            'file'              => 'bukti keorganisasian',
            'description'       => 'deskripsi',
        ];
    }
}