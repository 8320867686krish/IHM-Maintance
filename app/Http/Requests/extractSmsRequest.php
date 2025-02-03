<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class extractSmsRequest extends FormRequest
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
            'title'=>'required',
            'document' => 'required',
            'client_company_id' => 'required'
            //
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title.',
            'document.required' => 'plese select document.',
            'client_company_id.required' => 'plese select client.',

        ];
    }
}
