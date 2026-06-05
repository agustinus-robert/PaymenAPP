<?php

namespace Modules\Portal\Http\Requests\Counseling\Submission\Pretest;

use App\Http\Requests\FormRequest;
use Modules\Core\Models\CompanyCounselingPretestQuestion;

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
            'key'   => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'key'  => 'jawaban',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $questions = CompanyCounselingPretestQuestion::find(array_keys($this->input('key')));

        return [
            'counseling_id' => $this->counseling->id,
            'pretest_id' => $this->pretest->id,
            'result' => $questions->map(fn ($question) => [
                'q_id' => $question->id,
                'q' => $question->label,
                'a' => $this->input("key.{$question->id}"),
                'o' => $question->options
            ])
        ];
    }
}
