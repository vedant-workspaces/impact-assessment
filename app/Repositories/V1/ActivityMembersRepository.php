<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ActivityMembersDao;

interface ActivityMembersRepository
{
    public function addActivityMembers(ActivityMembersDao $activityMembersDao): bool;
}
