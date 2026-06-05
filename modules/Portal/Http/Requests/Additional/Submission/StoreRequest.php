<?php

namespace Modules\Portal\Http\Requests\Additional\Submission;

use App\Http\Requests\FormRequest;
use Modules\HRMS\Models\EmployeePosition;

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
            'empl_id'       => 'required|numeric',
            'type'          => 'required|numeric',
            'name'          => 'required|string|max:191',
            'dates.d.*'     => 'nullable|date_format:Y-m-d|before_or_equal:now',
            'dates.s.*'     => 'nullable|date_format:H:i',
            'dates.e.*'     => 'nullable|date_format:H:i',
            'dates.m.*'     => 'nullable',
            'dates.t.*'     => 'nullable',
            'description'   => 'nullable',
            'method'        => 'required|numeric',
            'attachment'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'approvables'   => 'array',
            'approvables.*' => 'nullable|exists:' . (new EmployeePosition())->getTable() . ',id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'empl_id'       => 'karyawan',
            'name'          => 'pekerjaan',
            'type'          => 'jenis lembur',
            'dates.d.*'     => 'tanggal',
            'dates.s.*'     => 'jam mulai',
            'dates.e.*'     => 'jam selesai',
            'dates.m.*'     => 'makan',
            'dates.e.*'     => 'transport',
            'description'   => 'deskripsi',
            'method'        => 'metode pembayaran',
            'attachment'    => 'lampiran',
            'approvables.*' => 'karyawan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];

        foreach ($this->input('dates.d') as $index => $date) {
            $dates[] = array_filter([
                'd' => $date,
                't_s' => $this->input('dates.s.' . $index),
                't_e' => $this->input('dates.e.' . $index),
                't_m' => $this->input('dates.m.' . $index),
                't_t' => $this->input('dates.t.' . $index)
            ]);
        }

        return array_merge(
            $this->only('empl_id', 'type', 'name', 'description', 'approvables', 'method'),
            [
                'dates' => $dates,
                'attachment' => $this->handleUploadedFile()
            ]
        );
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        return $this->has('attachment') ? $this->file('attachment')->store('users/' . $this->user()->id . '/employees/overtimes') : null;
    }
}
