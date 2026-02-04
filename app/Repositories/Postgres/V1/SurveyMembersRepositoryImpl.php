<?php

namespace App\Repositories\Postgres\V1;

use App\Models\SurveyMember;
use App\Repositories\Dao\V1\SurveyMembersDao;
use App\Repositories\V1\SurveyMembersRepository;
use Carbon\Carbon;

class SurveyMembersRepositoryImpl implements SurveyMembersRepository
{
    public function addSurveyMembers(SurveyMembersDao $surveyMembersDao): bool
    {
        $currentDate = Carbon::now();
        $surveyMembersDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $surveyMembersDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        SurveyMember::create($surveyMembersDao->toArray());

        return true;
    }
}
