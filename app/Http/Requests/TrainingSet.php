<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingSet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'questions.*.question_name*' => 'required|string',
            'questions.*.answer_type*' => 'required|string',
            'questions.*.option_a' => 'required_without:questions.*.option_a_existing',  // Only required if no existing file
            'questions.*.option_b' => 'required_without:questions.*.option_b_existing',  // Only required if no existing file
            'questions.*.option_c' => 'required_without:questions.*.option_c_existing',  // Only required if no existing file
            'questions.*.option_d' => 'required_without:questions.*.option_d_existing',  // Only required if no existing file
            'questions.*.correct_answer*' => 'required',

        ];
    }
    public function messages()
{
    return [
        'questions.*.question_name.required' => 'Question Name is required.',
        'questions.*.answer_type.required'   => 'Answer Type is required.',
        'questions.*.option_a.required_without'  => 'Option A is required.',
        'questions.*.option_b.required_without'  => 'Option B is required.',
        'questions.*.option_c.required_without'  => 'Option C is required.',
        'questions.*.option_d.required_without'  => 'Option D is required.',
        'questions.*.correct_answer*' => 'Correct Answer is required.',

    ];
}
}
