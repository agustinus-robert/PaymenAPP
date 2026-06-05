<?php

namespace Modules\Portal\Http\Requests\Leave\Submission;

use App\Http\Requests\FormRequest;
use Modules\Core\Models\CompanyLeaveCategory;

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
            'ctg_id'            => 'required|exists:' . (new CompanyLeaveCategory)->getTable() . ',id',
            'dates.*'           => 'required|date_format:Y-m-d|after_or_equal:today|distinct',
            'time_start'        => 'nullable|date_format:H:i|before:time_end',
            'time_end'          => 'nullable|date_format:H:i|after:time_start',
            'description'       => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'ctg_id'            => 'kategori izin',
            'dates.*'           => 'tanggal',
            'time_start'        => 'waktu mulai',
            'time_end'          => 'waktu berakhir',
            'description'       => 'deskripsi',
            'attachment'        => 'lampiran'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];
        foreach ($this->input('dates') as $i => $date) {
            $dates[] = array_filter([
                'd' => $date,
                't_s' => $this->input('time_start'),
                't_e' => $this->input('time_end')
            ]);
        }

        return [
            'ctg_id' => $this->input('ctg_id'),
            'dates' => $dates,
            'attachment' => $this->handleUploadedFile(),
            'description' => $this->input('description')
        ];
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        return $this->has('attachment') ? $this->file('attachment')->store('users/' . $this->user()->id . '/employees/leaves') : null;
    }
}
