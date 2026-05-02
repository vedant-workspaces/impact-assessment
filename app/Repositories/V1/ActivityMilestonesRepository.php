<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ActivityMilestoneDao;

interface ActivityMilestonesRepository
{
    public function addActivityMilestone(ActivityMilestoneDao $activityMilestoneDao): bool;

    public function updateMilestoneStatus(int $milestoneId, int $status): bool;
}
