<?php

namespace Modules\Portal\Http\Requests\Overtime\Submission;

use App\Http\Requests\FormRequest;
use Modules\HRMS\Models\EmployeePosition;

class UpdateRequest extends FormRequest
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
            'name'              => 'required|string|max:191',
            'dates.d.*'         => 'required|date_format:Y-m-d|before_or_equal:now',
            'dates.s.*'         => 'required|date_format:H:i',
            'dates.e.*'         => 'required|date_format:H:i',
            'description'       => 'nullable',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'approvables'       => 'array',
            'approvables.*'     => 'nullable|exists:' . (new EmployeePosition())->getTable() . ',id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'              => 'pekerjaan',
            'dates.d.*'         => 'tanggal',
            'dates.s.*'         => 'jam mulai',
            'dates.e.*'         => 'jam selesai',
            'description'       => 'deskripsi',
            'attachment'        => 'lampiran',
            'approvables.*'     => 'karyawan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];
        $inputs = $this->input('dates.d') ?? [];

        foreach ($inputs as $index => $date) {
            $dates[] = array_filter([
                'd' => $date,
                't_s' => $this->input('dates.s.' . $index),
                't_e' => $this->input('dates.e.' . $index)
            ]);
        }

        return array_merge(
            $this->only('name', 'description', 'approvables'),
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
        if (!$this->hasFile('attachment')) {
            return null;
        }
        return $this->file('attachment')->store('users/' . $this->user()->id . '/employees/overtimes');
    }
}
