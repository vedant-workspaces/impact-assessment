<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\SurveyMembersDao;

interface SurveyMembersRepository
{
    public function addSurveyMembers(SurveyMembersDao $surveyMembersDao): bool;
}
