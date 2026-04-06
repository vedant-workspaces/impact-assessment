<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddActivityRequest;
use Illuminate\Http\Request;
use App\Services\Bo\V1\ActivityBo;
use App\Services\V1\ActivityService;
use App\Traits\V1\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private ActivityService $activityService
    ) {}

    public function add(AddActivityRequest $addActivityRequest): JsonResponse
    {
        $data = $addActivityRequest->validated();

        $activityBo = new ActivityBo();
        $activityBo->setName($data['name']);
        $activityBo->setDescription($data['description'] ?? null);
        $activityBo->setStartDate($data['start_date'] ?? null);
        $activityBo->setEndDate($data['end_date'] ?? null);
        $activityBo->setProgramId($data['program_id'] ?? 0);
        $activityBo->setLeaderIds($data['leader_ids']);
        $activityBo->setMemberIds($data['member_ids']);
        $activityBo->setMilestones($data['milestones'] ?? []);
        $activityBo->setTotalBudget($data['total_budget'] ?? 0);
        $activityBo->setTotalBeneficiaries($data['total_beneficiaries'] ?? 0);
        $activityBo->setIsMediaUploads($data['is_media_uploads'] ?? 0);

        return $this->activityService->create($activityBo);
    }
}
