<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterNgoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organisation_email' => ['required', 'string', 'email'],

            'user_name' => ['required', 'string'],

            'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],

            'confirm_password' => ['required', 'string', 'same:password'],

            'organisation_website' => ['sometimes', 'nullable', 'string'],

            'organisation_name' => ['required', 'string'],

            'contact_person_name' => ['required', 'string'],

            'contact_person_designation' => ['required', 'string'],

            'contact_person_number' => ['required', 'string'],

            'organisation_address' => ['required', 'string'],

            'organisation_city' => ['required', 'string'],

            'organisation_state' => ['required', 'string'],

            'organisation_pincode' => ['required', 'string'],

            'primary_sector' => ['required', 'array', 'min:1'],
            'primary_sector.*' => ['integer', 'distinct'],

            'sdgs' => ['required', 'array', 'min:1'],
            'sdgs.*' => ['integer', 'distinct'],

            'purpose' => ['sometimes','string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = response()->json(['status' => 'error', 'message' => $firstError], 422);
        throw new HttpResponseException($response);
    }

    protected $fields = [
        'organisation_email',
        'user_name',
        'password',
        'confirm_password',
        'organisation_website',
        'organisation_name',
        'contact_person_name',
        'contact_person_designation',
        'contact_person_number',
        'organisation_address',
        'organisation_city',
        'organisation_state',
        'organisation_pincode',
        'primary_sector',
        'sdgs',
        'purpose',
    ];

    public function messages(): array
    {
        return [
            'organisation_email.required' => 'Organisation email is required',
            'organisation_email.string' => 'Organisation email must be a string',
            'organisation_email.email' => 'Organisation email must be a valid email',

            'user_name.required' => 'User name is required',
            'user_name.string' => 'User name must be a string',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character',

            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Passwords must match',

            'organisation_website.string' => 'Organisation website must be a string',

            'organisation_name.required' => 'Organisation name is required',
            'organisation_name.string' => 'Organisation name must be a string',

            'contact_person_name.required' => 'Contact person name is required',
            'contact_person_name.string' => 'Contact person name must be a string',

            'contact_person_designation.string' => 'Contact person designation must be a string',
            'contact_person_designation.required' => 'Contact person designation is required',

            'contact_person_number.required' => 'Contact person number is required',
            'contact_person_number.string' => 'Contact person number must be a string',

            'organisation_address.required' => 'Organisation address is required',
            'organisation_address.string' => 'Organisation address must be a string',

            'organisation_city.required' => 'Organisation city is required',
            'organisation_city.string' => 'Organisation city must be a string',

            'organisation_state.required' => 'Organisation state is required',
            'organisation_state.string' => 'Organisation state must be a string',

            'organisation_pincode.required' => 'Organisation pincode is required',
            'organisation_pincode.string' => 'Organisation pincode must be a string',

            'primary_sector.required' => 'At least one primary sector is required',
            'primary_sector.array' => 'Primary sector must be an array',
            'primary_sector.min' => 'At least one primary sector is required',

            'sdgs.required' => 'At least one SDG is required',
            'sdgs.array' => 'SDG must be an array',
            'sdgs.min' => 'At least one SDG is required',

            'purpose.string' => 'Purpose must be a string',
        ];
    }
}