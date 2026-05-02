<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProgramImpactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // program_id is nullable (0 or null indicates standalone activities)
        return [
            'program_id' => 'nullable|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = response()->json(['status' => 'error', 'message' => $firstError], 422);
        throw new HttpResponseException($response);
    }
}
