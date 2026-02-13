<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddSurveyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',

            'program_id'  => 'required|integer|exists:programs,id',

            'leader_ids'   => 'required|array|min:1',
            'leader_ids.*' => 'integer|exists:members,id',
            'member_ids'  => 'required|array|min:1',
            'member_ids.*'=> 'integer|exists:members,id',
            'questions' => 'nullable|array',
            'questions.*.order' => 'required_with:questions|integer',
            'questions.*.label' => 'required_with:questions|string',
            'questions.*.type' => 'required_with:questions|string',
            'questions.*.required' => 'nullable|boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*.label' => 'required_with:questions.*.options|string',
            'questions.*.options.*.order' => 'nullable|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = response()->json(['status' => 'error', 'message' => $firstError], 422);
        throw new HttpResponseException($response);
    }

    protected $fields = [
        'title',
        'description',
        'start_date',
        'end_date',
        'program_id',
        'leader_ids',
        'member_ids',
        'questions',
    ];

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title must be less than 255 characters',
            'end_date.after_or_equal' => 'End date must be greater than or equal to start date',

            'leader_ids.required' => 'Leader IDs is required',
            'leader_ids.min' => 'Leader IDs must be greater than or equal to 1',
            'leader_ids.*.integer' => 'Leader IDs must be integer',
            'member_ids.required' => 'Member IDs is required',
            'member_ids.min' => 'Member IDs must be greater than or equal to 1',
            'member_ids.*.integer' => 'Member IDs must be integer',
        ];
    }
}
