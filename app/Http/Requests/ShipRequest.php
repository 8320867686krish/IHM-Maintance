<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequest extends FormRequest
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
            'client_company_id' => $this->id ? '' . $this->id : 'required',
            'email' => $this->id ? '' . $this->id : 'required',
            'password' => $this->id ? '' . $this->id : 'required',
            'ship_name' => 'required',
            'imo_number' => 'required',
        ];
    }
}
