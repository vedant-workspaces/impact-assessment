<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ActivityDao;

interface ActivityRepository
{
    public function createActivity(ActivityDao $activityDao): int;
}
