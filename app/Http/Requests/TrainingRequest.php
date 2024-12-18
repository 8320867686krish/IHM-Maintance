<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hazmat_companies_id' => 'required|integer|min:1',
        ];
    }
    public function messages(): array
    {
        return [
            'hazmat_companies_id.required' => 'Please select a hazmat company.',
            'hazmat_companies_id.integer' => 'Invalid company selection.',
            'hazmat_companies_id.min' => 'Please select a valid company.',
        ];
    }
}
