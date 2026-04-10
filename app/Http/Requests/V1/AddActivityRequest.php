<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'program_id' => 'nullable|integer',
            'leader_ids' => 'required|array|min:1',
            'leader_ids.*' => 'integer|exists:members,id',
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'integer|exists:members,id',
            'milestones' => 'nullable|array',
            'milestones.*.name' => 'required_with:milestones|string',
            'milestones.*.start_date' => 'required_with:milestones|date',
            'milestones.*.end_date' => 'required_with:milestones|date|after_or_equal:milestones.*.start_date',
            'total_budget' => 'nullable|numeric',
            'total_beneficiaries' => 'nullable|integer|min:0',
            'is_media_uploads' => 'nullable|boolean',
        ];

        // If program_id is provided and > 0, ensure program exists
        $programId = $this->input('program_id');
        if (!is_null($programId) && intval($programId) > 0) {
            $rules['program_id'] = 'integer|exists:programs,id';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        $response = response()->json(['status' => 'error', 'message' => $firstError], 422);
        throw new HttpResponseException($response);
    }

    protected $fields = [
        'name',
        'description',
        'start_date',
        'end_date',
        'program_id',
        'leader_ids',
        'member_ids',
        'milestones',
        'total_budget',
        'total_beneficiaries',
        'is_media_uploads',
    ];

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.max' => 'Name must be less than 255 characters',
            'end_date.after_or_equal' => 'End date must be greater than or equal to start date',
            'leader_ids.required' => 'Leader IDs is required',
            'leader_ids.min' => 'Leader IDs must be greater than or equal to 1',
            'member_ids.required' => 'Member IDs is required',
            'member_ids.min' => 'Member IDs must be greater than or equal to 1',
        ];
    }
}
