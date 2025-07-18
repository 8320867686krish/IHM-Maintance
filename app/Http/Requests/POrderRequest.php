<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class POrderRequest extends FormRequest
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
            'po_no' => 'required',
            'po_date' => 'required',
            'email' => 'required',
            'items.*.type_category' => 'required',

            //
        ];
    }
    public function messages():array
    {
        return [
                      'items.*.type_category.required' => 'Please select the type category for each item.',

        ];
    }
}
