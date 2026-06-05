<?php

namespace Modules\Portal\Http\Requests\Appreciation;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Modules\HRMS\Enums\AppreciationTypeEnum;
use Modules\HRMS\Models\Employee;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'type'        => ['required', new Enum(AppreciationTypeEnum::class)],
            'empl_id'     => 'required|exists:' . (new Employee())->getTable() . ',id',
            'period'      => 'required',
            'description' => 'nullable|string|max:255',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'type'        => 'kategori',
            'empl_id'     => 'karyawan',
            'period'      => 'periode',
            'description' => 'deskripsi',
            'file'        => 'lampiran',
        ];
    }

    /**
     * Transform request data into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('empl_id', 'type', 'period', 'description'),
            'attachment' => $this->handleUploadedFile(),
            'created_by' => Auth::user()->employee->id,
            'name'       => 'Personnel of the month periode ' . $this->input('period'),
        ];
    }

    public function handleUploadedFile()
    {
        return $this->has('files') ? $this->file('files')->store('/employee/appreciation') : null;
    }
}
