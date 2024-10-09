<?php
namespace App\Http\Requests;

use App\Rules\AtLeastOnePermissionRule;
use Illuminate\Foundation\Http\FormRequest;

class hazmatCompanyRequest extends FormRequest
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
            'name' => 'required|unique:hazmat_companies,name,' . $this->id,
            'email' => $this->id ? 'unique:hazmat_companies,email,' . $this->id : 'required|unique:hazmat_companies,email',
            'logo' => $this->id ? 'image|mimes:jpeg,png,jpg,gif|max:2048,' . $this->id : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => $this->id ? 'nullable' : 'required',
            'phone' => 'numeric|digits:10',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a name.',
            'name.unique' => 'This hazmatCompany already exists.',
            'email.required' => 'Please enter a email.',
            'email.unique' => 'The email already exists.',
            'password.required' => 'Please enter a password.',
        ];
    }
}
