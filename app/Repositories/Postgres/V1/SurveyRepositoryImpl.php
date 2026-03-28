<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Repositories\Dao\V1\SurveyDao;
use App\Repositories\V1\SurveyRepository;

class SurveyRepositoryImpl implements SurveyRepository
{
    public function createSurvey(SurveyDao $surveyDao): int
    {
        $survey = Survey::create($surveyDao->toArray());
        return $survey->id;
    }

    public function getSurveyDetails(int $surveyId): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $survey = Survey::where('id', $surveyId)
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'surveyMembers.member:id,full_name',
                'surveyQuestions' => function ($q) {
                    $q->where('is_deleted', 0)->orderBy('order');
                }
            ])
            ->withCount(['surveyQuestions' => function ($q) {
                $q->where('is_deleted', 0);
            }])
            ->first(['id', 'title', 'description', 'start_date', 'end_date', 'assigned_by', 'program_id']);

        if (!$survey) {
            return [];
        }

        $leaders = collect($survey->surveyMembers)->filter(function ($sm) {
            return intval($sm->role) === 1;
        })->map(function ($sm) {
            return [
                'member_id' => $sm->member_id,
                'full_name' => $sm->member?->full_name ?? null,
                'role' => 'Leader'
            ];
        })->values()->toArray();

        $members = collect($survey->surveyMembers)->map(function ($sm) {
            $roleInt = intval($sm->role);
            $roleLabel = $roleInt === 1 ? 'Leader' : ($roleInt === 2 ? 'Member' : null);

            return [
                'member_id' => $sm->member_id,
                'full_name' => $sm->member?->full_name ?? null,
                'role' => $roleLabel
            ];
        })->values()->toArray();

        $questions = collect($survey->surveyQuestions)->map(function ($q) {
            return [
                'id' => $q->id,
                'label' => $q->question_title,
                'language' => $q->language,
                'options' => $q->options ?? [],
                'is_required' => intval($q->is_required),
                'order' => intval($q->order),
            ];
        })->values()->toArray();

        return [
            'id' => $survey->id,
            'title' => $survey->title,
            'description' => $survey->description ?? null,
            'start_date' => $survey->start_date?->toDateString(),
            'end_date' => $survey->end_date?->toDateString(),
            'assigned_by' => $survey->assignedBy?->full_name ?? null,
            'leaders' => $leaders,
            'program_id' => $survey->program_id ?? null,
            'question_count' => $survey->survey_questions_count ?? 0,
            'members' => $members,
            'questions' => $questions,
        ];
    }

    public function deleteSurvey(int $surveyId): bool
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $survey = Survey::where('id', $surveyId)
            ->where('ngo_id', $ngoId)
            ->where('is_deleted', 0)
            ->first();

        if (!$survey) {
            return false;
        }

        $survey->is_deleted = 1;
        $survey->updated_at = now();

        return $survey->save();
    }

    public function updateSurvey(int $surveyId, \App\Repositories\Dao\V1\SurveyDao $surveyDao, array $leaderIds, array $memberIds, array $questions): bool
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $survey = \App\Models\Survey::where('id', $surveyId)
            ->where('ngo_id', $ngoId)
            ->where('is_deleted', 0)
            ->first();

        if (!$survey) {
            return false;
        }

        $data = $surveyDao->toArray();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $survey->{$k} = $v;
            }
        }
        $survey->updated_at = now();
        $survey->save();

        // Upsert survey members: update existing rows or create new ones.
        $existingMembers = \App\Models\SurveyMember::where('survey_id', $surveyId)->get()->keyBy('member_id');

        $incomingIds = array_values(array_unique(array_merge($leaderIds, $memberIds)));

        // Process incoming IDs: create or reactivate/update role
        foreach ($incomingIds as $mid) {
            $isLeader = in_array($mid, $leaderIds, true);
            $role = $isLeader ? 1 : 2;

            if (isset($existingMembers[$mid])) {
                $sm = $existingMembers[$mid];
                $sm->role = $role;
                $sm->is_deleted = 0;
                $sm->updated_at = now();
                $sm->save();
            } else {
                \App\Models\SurveyMember::create([
                    'survey_id' => $surveyId,
                    'member_id' => $mid,
                    'role' => $role,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'is_deleted' => 0,
                ]);
            }
        }

        // Any existing members not present in incoming list should be soft-deleted
        foreach ($existingMembers as $memberId => $sm) {
            if (!in_array($memberId, $incomingIds, true) && intval($sm->is_deleted) === 0) {
                $sm->is_deleted = 1;
                $sm->updated_at = now();
                $sm->save();
            }
        }

        // Soft-delete existing survey questions
        \App\Models\SurveyQuestion::where('survey_id', $surveyId)
            ->where('is_deleted', 0)
            ->update(['is_deleted' => 1, 'updated_at' => now()]);

        // Re-create questions
        foreach ($questions as $q) {
            $options = $q['options'] ?? null;

            \App\Models\SurveyQuestion::create([
                'survey_id' => $surveyId,
                'question_title' => $q['label'] ?? '',
                'language' => 'english',
                'options' => $options ?? null,
                'is_required' => isset($q['required']) && ($q['required'] === true || $q['required'] == 1) ? 1 : 0,
                'order' => $q['order'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
                'is_deleted' => 0,
            ]);
        }

        return true;
    }

    public function getSurveyNames(): array
    {
        $ngoId = app('current_ngo_id') ?? 0;
        $surveys = Survey::select('id', 'title')
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->get();

        return $surveys->map(function ($s) {
            return [
                'id' => $s->id,
                'title' => $s->title,
                'survey_completion' => 100,
            ];
        })->toArray();
    }

    public function getSurveysWithMembers(?int $programId = null): array
    {
        $ngoId = app('current_ngo_id') ?? 0;
        $query = Survey::where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'surveyMembers.member:id,full_name'
            ])
            ->withCount(['surveyQuestions' => function ($q) {
                $q->where('is_deleted', 0);
            }])
            ;

        if (!is_null($programId)) {
            $query->where('program_id', $programId);
        }

        $surveys = $query->get(['id', 'title', 'start_date', 'end_date', 'assigned_by', 'program_id']);

        return $surveys->map(function ($survey) {
            $leaders = collect($survey->surveyMembers)->filter(function($sm){ return intval($sm->role) === 1; })->map(function($sm){
                return [
                    'member_id' => $sm->member_id,
                    'full_name' => $sm->member?->full_name ?? null,
                    'role' => 'Leader'
                ];
            })->values()->toArray();

            return [
                'id' => $survey->id,
                'title' => $survey->title,
                'description' => $survey->description ?? null,
                'start_date' => $survey->start_date?->toDateString(),
                'end_date' => $survey->end_date?->toDateString(),
                'assigned_by' => $survey->assignedBy?->full_name ?? null,
                'leaders' => $leaders,
                'survey_completion' => 100,
                'program_id' => $survey->program_id ?? null,
                'question_count' => $survey->survey_questions_count ?? 0,
                'members' => collect($survey->surveyMembers)->map(function ($sm) {
                    $roleInt = intval($sm->role);
                    $roleLabel = $roleInt === 1 ? 'Leader' : ($roleInt === 2 ? 'Member' : null);

                    return [
                        'member_id' => $sm->member_id,
                        'full_name' => $sm->member?->full_name ?? null,
                        'role' => $roleLabel
                    ];
                })->values()->toArray()
            ];
        })->toArray();
    }
}
