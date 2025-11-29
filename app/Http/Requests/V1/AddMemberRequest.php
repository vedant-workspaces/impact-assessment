<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'gender' => 'required|string',
            'designation' => 'required|string',
            'department' => 'required|string',
            'contact_number' => 'required|string',
            'official_email' => 'required|email',
            'username' => 'required|string',
            'password' => 'required|string|min:8',
            'role_type' => 'required|int',
            'access_level' => 'required|int',
            'status' => 'required|int',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = response()->json(['status' => 'error', 'message' => $firstError], 422);
        throw new HttpResponseException($response);
    }

    protected $fields = [
        'full_name',
        'gender',
        'designation',
        'department',
        'contact_number',
        'official_email',
        'username',
        'password',
        'role_type',
        'access_level',
        'status',
    ];

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required',
            'gender.required' => 'Gender is required',
            'designation.required' => 'Designation is required',
            'department.required' => 'Department is required',
            'contact_number.required' => 'Contact number is required',
            'official_email.required' => 'Official email is required',
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
            'role_type.required' => 'Role type is required',
            'access_level.required' => 'Access level is required',
            'status.required' => 'Status is required',
        ];
    }
}
