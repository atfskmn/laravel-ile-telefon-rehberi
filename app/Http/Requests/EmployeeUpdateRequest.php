<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'department_id' => ['sometimes','integer','exists:departments,id'],
            'service_id' => ['sometimes','nullable','integer','exists:services,id'],
            'position_id' => ['sometimes','nullable','integer','exists:positions,id'],
            'employee_number' => ['sometimes','nullable','string','max:20'],
            'first_name' => ['sometimes','string','max:100'],
            'last_name' => ['sometimes','string','max:100'],
            'email' => ['sometimes','nullable','email','max:255'],
            'phone' => ['sometimes','nullable','string','max:20'],
            'mobile' => ['sometimes','nullable','string','max:20'],
            'extension' => ['sometimes','nullable','string','max:10'],
            'office_location' => ['sometimes','nullable','string','max:255'],
            'hire_date' => ['sometimes','nullable','date'],
            'is_active' => ['sometimes','boolean'],
            'photo' => ['sometimes','nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
        ];
    }
}
