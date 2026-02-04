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
}
