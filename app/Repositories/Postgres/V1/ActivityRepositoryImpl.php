<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Activity;
use App\Repositories\Dao\V1\ActivityDao;
use App\Repositories\V1\ActivityRepository;

class ActivityRepositoryImpl implements ActivityRepository
{
    public function createActivity(ActivityDao $activityDao): int
    {
        $activity = Activity::create($activityDao->toArray());
        return $activity->id;
    }
}
