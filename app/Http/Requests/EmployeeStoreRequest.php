<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'department_id' => ['required','integer','exists:departments,id'],
            'service_id' => ['nullable','integer','exists:services,id'],
            'position_id' => ['nullable','integer','exists:positions,id'],
            'employee_number' => ['nullable','string','max:20'],
            'first_name' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'email' => ['nullable','email','max:255'],
            'phone' => ['nullable','string','max:20'],
            'mobile' => ['nullable','string','max:20'],
            'extension' => ['nullable','string','max:10'],
            'office_location' => ['nullable','string','max:255'],
            'hire_date' => ['nullable','date'],
            'is_active' => ['boolean'],
            'photo' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
        ];
    }
}
