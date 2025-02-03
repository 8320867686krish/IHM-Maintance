<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class designatedRequest extends FormRequest
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
            'name'=>'required',
            'rank' => 'required',
            'passport_number' => ['sometimes', 'required'],
            'sign_on_date' => 'required',
            'ship_id' => ['required_if:position,SuperDp'],
            'position'=> ['sometimes', 'required']
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a name.',
            'rank.required' => 'plese enter rank.',
            'passport_number.required' => 'please enter passport number',
            'sign_on_date.required' => 'please select sign on date ',
            'ship_id.required_if' => 'please select ship',
            'position.required' => 'please select position'
        ];
    }
}
