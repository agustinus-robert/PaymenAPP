<?php

namespace Modules\Portal\Http\Requests\Overtime\Manage\Schedule;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\HRMS\Models\Employee;

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
            'name'          => 'required|string|max:191',
            'empl_id'       => 'required|numeric|exists:' . (new Employee())->getTable() . ',id',
            'schedules.d.*' => 'required|date_format:Y-m-d',
            'schedules.s.*' => 'required|date_format:H:i',
            'schedules.e.*' => 'required|date_format:H:i',
            'description'   => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'          => 'pekerjaan',
            'karyawan'      => 'required|numeric',
            'schedules.d.*' => 'tanggal',
            'schedules.s.*' => 'jam mulai',
            'schedules.e.*' => 'jam selesai',
            'description'   => 'deskripsi',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $schedules = [];
        $inputs = $this->input('schedules.d') ?? [];

        foreach ($inputs as $index => $schedule) {
            $schedules[] = array_filter([
                'd' => $schedule,
                't_s' => $this->input('schedules.s.' . $index),
                't_e' => $this->input('schedules.e.' . $index)
            ]);
        }

        return array_merge(
            $this->only('empl_id', 'name', 'description'),
            [
                'schedules' => $schedules,
                'scheduled_by' => Auth::user()->employee->id,
                'scheduled_at' => now(),
            ]
        );
    }
}
