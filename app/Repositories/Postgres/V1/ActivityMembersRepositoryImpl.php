<?php

namespace App\Repositories\Postgres\V1;

use App\Models\ActivityMember;
use App\Repositories\Dao\V1\ActivityMembersDao;
use App\Repositories\V1\ActivityMembersRepository;
use Carbon\Carbon;

class ActivityMembersRepositoryImpl implements ActivityMembersRepository
{
    public function addActivityMembers(ActivityMembersDao $activityMembersDao): bool
    {
        $currentDate = Carbon::now();
        $activityMembersDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $activityMembersDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        ActivityMember::create($activityMembersDao->toArray());

        return true;
    }
}
