<?php

namespace Modules\Portal\Http\Requests\Vacation\Submission;

class UpdateRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'dates.*'           => 'required|date_format:Y-m-d|distinct',
            'as_freelances.*'   => 'nullable|boolean',
            'description'       => 'nullable|max:191'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'dates.*'           => 'tanggal',
            'as_freelances.*'   => 'pilihan freelance',
            'description'       => 'alasan'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $dates = [];
        foreach($this->input('dates') as $i => $date) {
            $dates[] = array_filter([
                'd' => $date,
                'f' => ($this->input('as_freelances')[$i] ?? 0) == 1
            ]);
        }

        return [
            'dates' => $dates,
            'description' => $this->input('description')
        ];
    }
}
