<?php

namespace Modules\Portal\Http\Requests\Asset\Device\Attachment;

use Storage;
use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
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
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'files.*' => 'Lampiran',
        ];
    }


    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $items = $this->device->attachments?->items ?? [];

        foreach ($items as $i => $item) {
            if (!in_array($i, $this->input('existing_attachments', []))) {
                Storage::exists($item->url) ? Storage::delete($item->url) : false;
                unset($items[$i]);
            }
        }


        if ($this->hasFile('files.*')) {
            foreach ($this->file('files') as $file) {
                array_push($items, [
                    'name'  => $file->getClientOriginalName(),
                    'url'   => $file->store('company/inventories/item/user_file/'),
                ]);
            }
        }

        return [
            'attachments' => array_filter([
                'items' => array_values($items),
            ]),
        ];
    }
}
