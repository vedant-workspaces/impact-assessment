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

    public function getActivityNames(): JsonResponse
    {
        try {
            $data = $this->activityService->getActivityNamesData();

            return $this->success($data, "Activities retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve activities");
        }
    }

    public function getActivitiesWithMembers(Request $request): JsonResponse
    {
        try {
            // Accept nullable program_id: if null -> standalone activities, otherwise filter by program id
            $programId = $request->has('program_id') ? $request->input('program_id') : null;

            if (!is_null($programId) && $programId !== '' && !is_numeric($programId)) {
                return $this->error('program_id must be an integer or null', 422);
            }

            $programParam = is_null($programId) || $programId === '' ? null : (int) $programId;

            $data = $this->activityService->getActivitiesWithMembersData($programParam);

            return $this->success($data, "Activities with members retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve activities with members");
        }
    }

    public function getDetails(Request $request): JsonResponse
    {
        try {
            $activityId = $request->input('activity_id');

            if (is_null($activityId) || $activityId === '') {
                return $this->error('activity_id is required', 422);
            }

            if (!is_numeric($activityId)) {
                return $this->error('activity_id must be an integer', 422);
            }

            $data = $this->activityService->getActivityDetailsData((int) $activityId);

            return $this->success($data, 'Activity details retrieved successfully');
        } catch (\Exception) {
            return $this->error('Failed to retrieve activity details');
        }
    }

    public function updateParams(\App\Http\Requests\V1\UpdateActivityParamsRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $activityId = (int) ($data['activity_id'] ?? 0);

            $params = [];
            if (array_key_exists('budget_used', $data)) {
                $params['budget_used'] = $data['budget_used'];
            }
            if (array_key_exists('beneficiaries_reached', $data)) {
                $params['beneficiaries_reached'] = $data['beneficiaries_reached'];
            }
            if (array_key_exists('media_status', $data)) {
                $params['media_status'] = $data['media_status'];
            }
            if (array_key_exists('media_link', $data)) {
                $params['media_link'] = $data['media_link'];
            }

            return $this->activityService->updateActivityParams($activityId, $params);
        } catch (\Exception) {
            return $this->error('Failed to update activity');
        }
    }

    public function markMilestoneComplete(\App\Http\Requests\V1\MarkMilestoneRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $milestoneId = (int) ($data['milestone_id'] ?? 0);

            return $this->activityService->markMilestoneCompleted($milestoneId);
        } catch (\Exception) {
            return $this->error('Failed to update milestone status');
        }
    }
}
