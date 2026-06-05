<?php

namespace Modules\Portal\Http\Requests\Outwork\Submission;

use App\Http\Requests\FormRequest;
use Modules\Core\Models\CompanyOutworkCategory;
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
            'name'              => 'required|string',
            'ctg_id'            => 'required|exists:' . (new CompanyOutworkCategory)->getTable() . ',id',
            'dates.d.*'         => 'required|date_format:Y-m-d|before_or_equal:now',
            'dates.s.*'         => 'required|date_format:H:i',
            'dates.e.*'         => 'required|date_format:H:i',
            'dates.b.*'         => 'required|numeric|min:0',
            'description'       => 'nullable|max:400',
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
            'ctg_id'            => 'kategori izin',
            'dates.d.*'         => 'tanggal',
            'dates.s.*'         => 'jam mulai',
            'dates.e.*'         => 'jam selesai',
            'dates.b.*'         => 'istirahat',
            'description'       => 'deskripsi',
            'file'              => 'lampiran',
            'approvables.*'     => 'karyawan'
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
                'd'   => $date,
                't_s' => $this->input('dates.s.' . $index),
                't_e' => $this->input('dates.e.' . $index),
                'b'   => $this->input('dates.b.' . $index),
                'p'   => (bool) $this->input('prepare')
            ]);
        }

        return [
            'name'        => $this->input('name'),
            'ctg_id'      => $this->input('ctg_id'),
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
        return $this->hasFile('file') ? $this->file('file')->store('users/' . $this->user()->id . '/employees/outworks') : null;
    }
}
