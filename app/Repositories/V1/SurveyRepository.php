<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\SurveyDao;

interface SurveyRepository
{
    public function createSurvey(SurveyDao $surveyDao): int;
}
