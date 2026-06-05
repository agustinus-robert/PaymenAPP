<?php

namespace Modules\Portal\Http\Requests\Tax;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Account\Models\User;

class StoreRequest extends FormRequest
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
            'tax_number'        => 'nullable|string|max:191',
            'name'              => 'required|string|max:191',
            'tax_address'       => 'required|string|max:255',
            'profile_nik'       => 'required|numeric',
            'profile_mariage'   => 'required|numeric',
            'profile_child'     => 'required|numeric',
            'address_address'   => 'required|string|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'tax_number'        => 'nomor wajib pajak',
            'name'              => 'nama',
            'tax_address'       => 'alamat sesuai NPWP',
            'profile_nik'       => 'nomor induk kependudukan',
            'profile_mariage'   => 'status pernikahan',
            'profile_child'     => 'jumlah tanggungan anak',
            'address_address'   => 'alamat saat ini',
        ];
    }

    /**
     * Transform request data into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('name', 'tax_number', 'tax_address', 'profile_nik', 'profile_mariage', 'profile_child', 'address_address'),
            'tax_file' => $this->handleUploadedFile()
        ];
    }

    public function handleUploadedFile()
    {
        return $this->has('files') ? $this->file('files')->store('/employee/taxs') : null;
    }
}
