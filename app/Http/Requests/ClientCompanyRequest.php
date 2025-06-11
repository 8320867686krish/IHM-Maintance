<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCompanyRequest extends FormRequest
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
            'hazmat_companies_id' => 'required',
            'name' => 'required|unique:client_companies,name,'.$this->id,
            'email' => 'required|email|unique:users,email,'.$this->user_id,
            'password' => $this->user_id ? 'nullable' : 'required',
            'manager_initials' => 'required|unique:client_companies,IMO_ship_owner_details,'.$this->id,
            'IMO_ship_owner_details' => 'required|unique:client_companies,IMO_ship_owner_details,'.$this->id,
            'accounting_team_email' => $this->id ? 'nullable' : 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'hazmat_companies_id.required' => 'please select hazmat company',
            'name.required' => 'please enter name',
            'email.required' => 'please enter email',
            'email.unique' => 'please enter unique email',
            'password.required' => 'please enter password',
            'manager_initials.required' => 'plese enter intials',
            'manager_initials.unique' => 'please enter unique intials',
            'IMO_ship_owner_details.unique' => 'please enter unique intials',
            'IMO_ship_owner_details.required' => 'plese enter intials',
        ];
    }
}
