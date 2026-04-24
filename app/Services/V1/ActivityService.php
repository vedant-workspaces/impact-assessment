<?php

namespace App\Services\V1;

use App\Constants\CommonConstants;
use App\Repositories\Dao\V1\ActivityDao;
use App\Repositories\Dao\V1\ActivityMembersDao;
use App\Repositories\Dao\V1\ActivityMilestoneDao;
use App\Repositories\V1\ActivityRepository;
use App\Repositories\V1\ActivityMembersRepository;
use App\Repositories\V1\ActivityMilestonesRepository;
use App\Services\Bo\V1\ActivityBo;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityMilestone;

class ActivityService
{
    public function __construct(
        private ActivityRepository $activityRepository,
        private ActivityMembersRepository $activityMembersRepository,
        private ActivityMilestonesRepository $activityMilestonesRepository
    ) {}

    public function create(ActivityBo $activityBo)
    {
        try {
            $activityDao = $this->setActivityDao($activityBo);

            $activityId = $this->activityRepository->createActivity($activityDao);

            $this->addActivityMembers($activityBo, $activityId);

            $this->addActivityMilestones($activityBo, $activityId);

            return response()->json(['status' => 200, 'message' => 'Activity added successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while adding activity']);
        }
    }

    private function setActivityDao(ActivityBo $activityBo): ActivityDao
    {
        $activityDao = new ActivityDao();
        $activityDao->setNgoId(app('current_ngo_id') ?? 0);
        $activityDao->setProgramId($activityBo->getProgramId() ?? 0);
        $activityDao->setName($activityBo->getName());
        $activityDao->setDescription($activityBo->getDescription() ?? null);
        // Map authenticated user to `members.id` (assigned_by references members). Activities allow null assigned_by.
        $member = \App\Models\Member::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('is_deleted', 0)
            ->where('ngo_id', app('current_ngo_id') ?? 0)
            ->first();

        if ($member) {
            $activityDao->setAssignedBy($member->id);
        }
        $activityDao->setTotalBudget($activityBo->getTotalBudget() ?? 0);
        $activityDao->setTotalBeneficiaries($activityBo->getTotalBeneficiaries() ?? 0);
        $activityDao->setIsMediaUploads($activityBo->getIsMediaUploads() ?? 0);
        $activityDao->setStartDate($activityBo->getStartDate() ?? null);
        $activityDao->setEndDate($activityBo->getEndDate() ?? null);
        $activityDao->setCreatedAt(now());
        $activityDao->setUpdatedAt(now());

        return $activityDao;
    }

    private function addActivityMembers(ActivityBo $activityBo, int $activityId)
    {
        foreach ($activityBo->getLeaderIds() as $leaderId) {
            $dao = new ActivityMembersDao();
            $dao->setActivityId($activityId);
            $dao->setMemberIds($leaderId);
            $dao->setRole(CommonConstants::PROGRAM_LEADER_ROLE);

            $this->activityMembersRepository->addActivityMembers($dao);
        }

        foreach ($activityBo->getMemberIds() as $memberId) {
            $dao = new ActivityMembersDao();
            $dao->setActivityId($activityId);
            $dao->setMemberIds($memberId);
            $dao->setRole(CommonConstants::PROGRAM_MEMBER_ROLE);

            $this->activityMembersRepository->addActivityMembers($dao);
        }
    }

    private function addActivityMilestones(ActivityBo $activityBo, int $activityId)
    {
        $milestones = $activityBo->getMilestones();
        if (empty($milestones) || !is_array($milestones)) {
            return;
        }

        foreach ($milestones as $m) {
            $dao = new ActivityMilestoneDao();
            $dao->setActivityId($activityId);
            $dao->setNgoId(app('current_ngo_id') ?? 0);
            $dao->setName($m['name'] ?? '');
            $dao->setStartDate($m['start_date'] ?? null);
            $dao->setEndDate($m['end_date'] ?? null);
            $dao->setCreatedAt(now());
            $dao->setUpdatedAt(now());

            $this->activityMilestonesRepository->addActivityMilestone($dao);
        }
    }
}
