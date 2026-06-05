<?php

namespace Modules\Portal\Http\Requests\Overtime\Submission;

use App\Http\Requests\FormRequest;
use Modules\HRMS\Models\EmployeePosition;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:191',
            'dates.d.*'         => 'required|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'dates.s.*'         => 'required|date_format:H:i',
            'dates.e.*'         => 'required|date_format:H:i',
            'description'       => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'approvables'       => 'required|array|min:1', // Minimal ada 1 approver jika bukan owner
            'approvables.*'     => 'required|exists:' . (new EmployeePosition())->getTable() . ',id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'              => 'nama pekerjaan',
            'dates.d.*'         => 'tanggal lembur',
            'dates.s.*'         => 'jam mulai',
            'dates.e.*'         => 'jam selesai',
            'description'       => 'deskripsi',
            'attachment'        => 'lampiran',
            'approvables.*'     => 'atasan penanggung jawab'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];

        if ($this->has('dates.d')) {
            foreach ($this->input('dates.d') as $index => $date) {
                $dates[] = array_filter([
                    'd'   => $date,
                    't_s' => $this->input('dates.s.' . $index),
                    't_e' => $this->input('dates.e.' . $index)
                ]);
            }
        }

        return [
            'name'        => $this->input('name'),
            'description' => $this->input('description'),
            'dates'       => $dates,
            'attachment'  => $this->handleUploadedFile()
        ];
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        if ($this->hasFile('attachment')) {
            return $this->file('attachment')->store('users/' . $this->user()->id . '/employees/overtimes');
        }

        return null;
    }
}
