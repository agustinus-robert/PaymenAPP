<?php

namespace Modules\Portal\Http\Requests\Counseling\Submission;

use App\Http\Requests\FormRequest;
use Modules\Core\Models\CompanyCounseling;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return isset($this->user()->employee);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'counseling_id'   => 'required|exists:' . (new CompanyCounseling())->getTable() . ',id',
            'start_at'        => 'required',
            'end_at'          => 'required',
            'description'     => 'nullable|max:191',
            'location'        => 'required|numeric',
            'phone_number'    => 'nullable|string',
            'email_address'   => 'nullable|string',
            'profile_dob'     => 'nullable|string',
            'next'            => 'nullable|string',
            'attachment'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'counseling_id'  => 'kategori izin',
            'start_at'       => 'waktu mulai',
            'end_at'         => 'waktu berakhir',
            'description'    => 'deskripsi',
            'location'       => 'lokasi',
            'phone_number'   => 'telpon',
            'email_address'  => 'email',
            'profile_dob'    => 'tanggal lahir',
            'next'           => 'lanjutan',
            'attachment'     => 'lampiran'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'counseling_id' => $this->input('counseling_id'),
            'start_at'      => $this->input('start_at'),
            'end_at'        => $this->input('end_at'),
            'description'   => $this->input('description'),
            'location'      => $this->input('location'),
            'meta'          => [
                'phone_number'  => $this->input('phone_number'),
                'email_address' => $this->input('email_address'),
                'profile_dob'   => $this->input('profile_dob'),
            ],
            'attachment'    => $this->handleUploadedFile(),
            'next'          => $this->input('next'),
        ];
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        return $this->hasFile('file') ? $this->file('file')->store('users/' . $this->user()->id . '/employees/counselings') : null;
    }
}
