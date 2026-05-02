<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ActivityDao;

interface ActivityRepository
{
    public function createActivity(ActivityDao $activityDao): int;

    public function getActivityNames(): array;

    public function getActivitiesWithMembers(?int $programId = null): array;

    public function getActivityDetails(int $activityId): array;

    public function updateActivityParams(int $activityId, array $params): bool;

    public function getActivitiesForProgram(?int $programId = null): array;
}
