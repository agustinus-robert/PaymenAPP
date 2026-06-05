<?php

namespace Modules\Portal\Http\Requests\Holiday\Submission;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return isset($this->user()->employee);
    }
}
