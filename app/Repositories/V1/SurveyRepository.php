<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\SurveyDao;

interface SurveyRepository
{
    public function createSurvey(SurveyDao $surveyDao): int;

    public function getSurveyNames(): array;

    public function getSurveysWithMembers(?int $programId = null): array;

    public function getSurveyDetails(int $surveyId): array;

    public function updateSurvey(int $surveyId, \App\Repositories\Dao\V1\SurveyDao $surveyDao, array $leaderIds, array $memberIds, array $questions): bool;

    public function deleteSurvey(int $surveyId): bool;
}
