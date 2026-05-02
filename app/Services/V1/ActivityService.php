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

    public function getActivityNamesData(): array
    {
        return $this->activityRepository->getActivityNames();
    }

    public function updateActivityParams(int $activityId, array $params)
    {
        try {
            $updated = $this->activityRepository->updateActivityParams($activityId, $params);

            if (!$updated) {
                return response()->json(['status' => 404, 'message' => 'Activity not found']);
            }

            return response()->json(['status' => 200, 'message' => 'Activity updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while updating activity']);
        }
    }

    public function markMilestoneCompleted(int $milestoneId)
    {
        try {
            $updated = $this->activityMilestonesRepository->updateMilestoneStatus($milestoneId, 2);

            if (!$updated) {
                return response()->json(['status' => 404, 'message' => 'Milestone not found']);
            }

            return response()->json(['status' => 200, 'message' => 'Milestone marked completed']);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while updating milestone status']);
        }
    }

    public function getActivitiesWithMembersData(?int $programId = null): array
    {
        return $this->activityRepository->getActivitiesWithMembers($programId);
    }

    public function getActivityDetailsData(int $activityId): array
    {
        return $this->activityRepository->getActivityDetails($activityId);
    }

    public function calculateActivityImpactData(int $activityId): array
    {
        $activity = $this->getActivityDetailsData($activityId);

        if (empty($activity)) {
            return [];
        }

        // Budget Utilization Score
        $totalBudget = floatval($activity['total_budget'] ?? 0);
        $budgetUsed = floatval($activity['budget_used'] ?? 0);
        $budgetPct = $totalBudget > 0 ? ($budgetUsed / $totalBudget) * 100.0 : null;
        $budgetScore = $budgetPct === null ? 100.0 : min(100.0, $budgetPct);
        $budgetOverspend = ($budgetPct !== null && $budgetPct > 100.0);

        // Milestones
        $milestones = $activity['milestones'] ?? [];
        $totalMilestones = intval($activity['milestone_count'] ?? count($milestones));
        $completedMilestones = collect($milestones)->filter(function ($m) {
            return intval($m['status'] ?? 0) === 2;
        })->count();

        // Completed on time: requires completed_at and end_date comparison
        $completedOnTime = collect($milestones)->filter(function ($m) {
            if (intval($m['status'] ?? 0) !== 2) {
                return false;
            }
            if (empty($m['completed_at']) || empty($m['end_date'])) {
                return false;
            }
            try {
                $completed = new \DateTime($m['completed_at']);
                $end = new \DateTime($m['end_date']);
            } catch (\Exception $e) {
                return false;
            }

            return $completed <= $end;
        })->count();

        // Timeline Performance Score
        if ($totalMilestones <= 0) {
            $timelineScore = 100.0;
        } else {
            $timelineScore = ($completedOnTime / $totalMilestones) * 100.0;
        }

        // Milestone Completion Score
        if ($totalMilestones <= 0) {
            $milestoneScore = 100.0;
        } else {
            $milestoneScore = ($completedMilestones / $totalMilestones) * 100.0;
        }

        // Beneficiary Reach Score
        $totalBeneficiaries = intval($activity['total_beneficiaries'] ?? 0);
        $beneficiariesReached = intval($activity['beneficiaries_reached'] ?? 0);
        if ($totalBeneficiaries <= 0) {
            $beneficiaryScore = 100.0;
        } else {
            $beneficiaryScore = ($beneficiariesReached / $totalBeneficiaries) * 100.0;
        }

        // Field Evidence / Media Score
        // Logic: If activity does not require media uploads, score is 100.
        // Otherwise map based on media_status and presence of media_link:
        // approved+link => 100, pending+link => 75, not approved+link => 50, no link => 0
        $isMediaRequired = intval($activity['is_media_uploads'] ?? 0) === 1;
        $mediaStatus = intval($activity['media_status'] ?? 2);
        $mediaLink = $activity['media_link'] ?? null;

        if (!$isMediaRequired) {
            $fieldEvidenceScore = 100.0;
        } else {
            if (empty($mediaLink)) {
                $fieldEvidenceScore = 0.0;
            } else {
                if ($mediaStatus === 1) {
                    $fieldEvidenceScore = 100.0;
                } elseif ($mediaStatus === 2) {
                    $fieldEvidenceScore = 75.0;
                } else {
                    $fieldEvidenceScore = 50.0;
                }
            }
        }

        // Final Impact Score (weights as provided)
        $finalScoreRaw = ($budgetScore * 0.25) + ($timelineScore * 0.20) + ($milestoneScore * 0.25) + ($beneficiaryScore * 0.15) + ($fieldEvidenceScore * 0.15);
        $finalScore = round(min(100.0, $finalScoreRaw), 2);

        // Final status band
        if ($finalScore >= 85.0) {
            $finalStatus = 'High Impact';
        } elseif ($finalScore >= 70.0) {
            $finalStatus = 'Moderate Impact';
        } elseif ($finalScore >= 50.0) {
            $finalStatus = 'Low Impact';
        } else {
            $finalStatus = 'Critical / Needs Attention';
        }

        return [
            'activity_id' => $activityId,
            'budget' => [
                'total_budget' => $totalBudget,
                'budget_used' => $budgetUsed,
                'raw_percentage' => $budgetPct === null ? null : round($budgetPct, 2),
                'score' => round($budgetScore, 2),
                'overspend' => $budgetOverspend,
            ],
            'timeline' => [
                'total_milestones' => $totalMilestones,
                'completed_on_time' => $completedOnTime,
                'score' => round($timelineScore, 2),
            ],
            'milestones' => [
                'total' => $totalMilestones,
                'completed' => $completedMilestones,
                'score' => round($milestoneScore, 2),
            ],
            'beneficiaries' => [
                'target' => $totalBeneficiaries,
                'reached' => $beneficiariesReached,
                'score' => round($beneficiaryScore, 2),
            ],
            'field_evidence' => [
                'is_required' => $isMediaRequired,
                'media_status' => $mediaStatus,
                'media_link' => $mediaLink,
                'score' => round($fieldEvidenceScore, 2),
            ],
            'final' => [
                'raw' => round($finalScoreRaw, 2),
                'score' => $finalScore,
                'status' => $finalStatus,
            ],
        ];
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
            ->where('status', 1)
            ->where('ngo_id', app('current_ngo_id') ?? 0)
            ->first();

        if ($member) {
            $activityDao->setAssignedBy($member->id);
        }
        $activityDao->setTotalBudget($activityBo->getTotalBudget() ?? 0);
        $activityDao->setTotalBeneficiaries($activityBo->getTotalBeneficiaries() ?? 0);
        $activityDao->setIsMediaUploads($activityBo->getIsMediaUploads() ?? 0);
        // default media status pending (2) and no media link on creation
        $activityDao->setMediaStatus(2);
        $activityDao->setMediaLink(null);
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
