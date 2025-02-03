<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BriefingRequest extends FormRequest
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
            'number_of_attendance' => 'required',
            'brifing_date' => 'required',
            'designated_people_id' =>  'required',
          
        ];
    }
    public function messages(): array
    {
        return [
            'number_of_attendance.required' => 'Please enter a number of attendance.',
            'brifing_date.required' => 'plese select briefing date.',
            'designated_people_id.required' => 'please select designated pepole'
        ];
    }
}
