<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Survey;
use App\Repositories\Dao\V1\SurveyDao;
use App\Repositories\V1\SurveyRepository;

class SurveyRepositoryImpl implements SurveyRepository
{
    public function createSurvey(SurveyDao $surveyDao): int
    {
        $survey = Survey::create($surveyDao->toArray());
        return $survey->id;
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

    public function getSurveysWithMembers(): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $surveys = Survey::where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'surveyMembers.member:id,full_name'
            ])
            ->get(['id', 'title', 'start_date', 'end_date', 'assigned_by', 'program_id']);

        return $surveys->map(function ($survey) {
            return [
                'id' => $survey->id,
                'title' => $survey->title,
                'start_date' => $survey->start_date?->toDateString(),
                'end_date' => $survey->end_date?->toDateString(),
                'assigned_by' => $survey->assignedBy?->full_name ?? null,
                'survey_completion' => 100,
                'program_id' => $survey->program_id ?? null,
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
