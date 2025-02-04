<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class configrationRequest extends FormRequest
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
            'ship_staff' => $this->id ? '' . $this->id : 'required',

            'client_company' => $this->id ? 'nullable' : 'required',
            'hazmat_company' => $this->id ? 'nullable' : 'required',
        ];
        
    }
    public function messages(): array
    {
        return [
            'ship_staff.required' => 'Please choose document.',
            'client_company.required' => 'Please choose document.',
            'hazmat_company.required' => 'Please choose document.',
        ];
    }
}
