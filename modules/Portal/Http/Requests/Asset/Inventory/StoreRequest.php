<?php

namespace Modules\Portal\Http\Requests\Asset\Inventory;

use Auth;
use Illuminate\Validation\Rules\Enum;
use App\Http\Requests\FormRequest;
use Carbon\CarbonPeriod;
use Modules\Core\Enums\BorrowableTypeEnum;
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
            'inv.*.modelable_type' => ['required', new Enum(BorrowableTypeEnum::class)],
            'inv.*.modelable_id'   => 'required',
            'received_at'          => 'required',
            'returned_at'          => 'nullable',
            'for'                  => 'nullable|string|max:255',
            'description'          => 'nullable|string'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'inv.*.modelable_type' => 'kategori inventaris',
            'inv.*.modelable_id'   => 'jenis inventaris',
            'received_at'          => 'dipinjam pada',
            'returned_at'          => 'dikembalikan pada',
            'for'                  => 'keperluan',
            'description'          => 'catatan'
        ];
    }


    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $return = $this->input('returned_at') ?? $this->input('received_at');
        $period = CarbonPeriod::create(date('Y-m-d', strtotime($this->input('received_at'))), date('Y-m-d', strtotime($return)));
        $list = $period->toArray();

        return [
            'title' => $this->input('for'),
            'receiver_id' => Auth::user()->id,
            'meta' => [
                'returned'  => $this->input('returned', 0),
                'for'       => $this->input('for'),
                'clause'    => $this->input('clause'),
                'description' => $this->input('description')
            ],
            'items' => $this->collect('inv')->map(
                function ($item) use ($period, $return) {
                    return array_map(fn ($key, $value) => array_merge([
                        'borrowable'     => $borrowable = BorrowableTypeEnum::forceTryFrom($item['modelable_type']),
                        'modelable_type' => $borrowable->instance(),
                        'modelable_id'   => (float) $item['modelable_id'],
                        'giver_id'       => (float) Employee::find($borrowable->approver())->first()->user_id,
                        'received_at'    => min($period->toArray())->isSameDay($value) ? date('Y-m-d H:i:s', strtotime($this->input('received_at'))) : date('Y-m-d', strtotime($value)) . ' 08:00:00',
                        'returned_at'    => max($period->toArray())->isSameDay($value) ? date('Y-m-d H:i:s', strtotime($return)) : null,
                    ]), array_keys($period->toArray()), $period->toArray());
                }
            )->toArray(),
        ];
    }
}
