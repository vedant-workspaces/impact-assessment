<?php

namespace App\Repositories\Postgres\V1;

use App\Models\ActivityMilestone;
use App\Repositories\Dao\V1\ActivityMilestoneDao;
use App\Repositories\V1\ActivityMilestonesRepository;
use Carbon\Carbon;

class ActivityMilestonesRepositoryImpl implements ActivityMilestonesRepository
{
    public function addActivityMilestone(ActivityMilestoneDao $activityMilestoneDao): bool
    {
        $currentDate = Carbon::now();
        $activityMilestoneDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $activityMilestoneDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        ActivityMilestone::create($activityMilestoneDao->toArray());

        return true;
    }
}
