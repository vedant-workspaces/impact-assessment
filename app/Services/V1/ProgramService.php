<?php

namespace App\Services\V1;

use App\Constants\CommonConstants;
use App\Repositories\Dao\V1\ProgramDao;
use App\Repositories\Dao\V1\ProgramMembersDao;
use App\Repositories\V1\ProgramMembersRepository;
use App\Repositories\V1\ProgramRepository;
use App\Services\Bo\V1\ProgramBo;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProgramService
{
    public function __construct(
        private ProgramRepository $programRepository,
        private ProgramMembersRepository $programMembersRepository,
        private \App\Repositories\V1\ActivityRepository $activityRepository
    ) {}

    public function create(ProgramBo $programBo)
    {
        try {
            $programDao = $this->setProgramDao($programBo);

            if (empty($programDao->getAssignedBy()) || intval($programDao->getAssignedBy()) <= 0) {
                return response()->json(['status' => 400, 'message' => 'Current user is not registered as a member. Please create a member profile before creating a program.']);
            }

            $programId = $this->programRepository->createProgram($programDao);

            $this->addProgramMembers($programBo, $programId);

            return response()->json(['status' => 200, 'message' => 'Program added successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
            // return response()->json(['status' => 400, 'message' => 'Error occurred while adding program']);
        }
    }

    public function getProgramNamesData(): array
    {
        return $this->programRepository->getProgramNames();
    }

    public function getProgramsWithMembersData(): array
    {
        return $this->programRepository->getProgramsWithMembers();
    }

    public function edit(\App\Services\Bo\V1\ProgramBo $programBo, int $programId)
    {
        try {
            $programDao = new \App\Repositories\Dao\V1\ProgramDao();
            $programDao->setNgoId(app('current_ngo_id') ?? 0);
            $programDao->setTitle($programBo->getTitle());
            $programDao->setDescription($programBo->getDescription());
            $programDao->setStartDate($programBo->getStartDate());
            $programDao->setEndDate($programBo->getEndDate());
            // Map authenticated user to `members.id` (assigned_by references members)
            $member = \App\Models\User::where('id', \Illuminate\Support\Facades\Auth::id())
                ->first();

            if (!$member) {
                return response()->json(['status' => 400, 'message' => 'Current user is not registered as a member. Please create a member profile before editing a program.']);
            }

            $programDao->setAssignedBy($member->id);
            $programDao->setUpdatedAt(now());

            $updated = $this->programRepository->updateProgram($programId, $programDao, $programBo->getLeaderIds(), $programBo->getMemberIds());

            if (!$updated) {
                return response()->json(['status' => 404, 'message' => 'Program not found or not editable']);
            }

            return response()->json(['status' => 200, 'message' => 'Program updated successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while updating program']);
        }
    }

    public function getProgramDetailsData(int $programId): array
    {
        return $this->programRepository->getProgramDetails($programId);
    }

    public function calculateProgramImpactData(?int $programId = null): array
    {
        $activities = $this->activityRepository->getActivitiesForProgram($programId);

        if (empty($activities)) {
            return [];
        }

        $totalBudget = 0.0;
        $totalBudgetUsed = 0.0;
        $totalBeneficiaries = 0;
        $totalBeneficiariesReached = 0;
        $totalMilestones = 0;
        $totalCompletedMilestones = 0;
        $totalCompletedOnTime = 0;
        $fieldEvidenceScores = [];

        foreach ($activities as $act) {
            $tb = floatval($act['total_budget'] ?? 0);
            $tbu = floatval($act['budget_used'] ?? 0);
            $totalBudget += $tb;
            $totalBudgetUsed += $tbu;

            $tbens = intval($act['total_beneficiaries'] ?? 0);
            $treached = intval($act['beneficiaries_reached'] ?? 0);
            $totalBeneficiaries += $tbens;
            $totalBeneficiariesReached += $treached;

            $milestones = $act['milestones'] ?? [];
            $totalMilestones += count($milestones);
            $completed = collect($milestones)->filter(function ($m) {
                return intval($m['status'] ?? 0) === 2;
            })->count();
            $totalCompletedMilestones += $completed;

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

            $totalCompletedOnTime += $completedOnTime;

            // Field evidence score for activity (same logic as ActivityService)
            $isMediaRequired = intval($act['is_media_uploads'] ?? 0) === 1;
            $mediaStatus = intval($act['media_status'] ?? 2);
            $mediaLink = $act['media_link'] ?? null;

            if (!$isMediaRequired) {
                $fes = 100.0;
            } else {
                if (empty($mediaLink)) {
                    $fes = 0.0;
                } else {
                    if ($mediaStatus === 1) {
                        $fes = 100.0;
                    } elseif ($mediaStatus === 2) {
                        $fes = 75.0;
                    } else {
                        $fes = 50.0;
                    }
                }
            }

            $fieldEvidenceScores[] = $fes;
        }

        // Budget Utilization Score for program
        $budgetPct = $totalBudget > 0 ? ($totalBudgetUsed / $totalBudget) * 100.0 : null;
        $budgetScore = $budgetPct === null ? 100.0 : min(100.0, $budgetPct);

        // Timeline Performance Score
        if ($totalMilestones <= 0) {
            $timelineScore = 100.0;
        } else {
            $timelineScore = ($totalCompletedOnTime / $totalMilestones) * 100.0;
        }

        // Milestone Completion Score
        if ($totalMilestones <= 0) {
            $milestoneScore = 100.0;
        } else {
            $milestoneScore = ($totalCompletedMilestones / $totalMilestones) * 100.0;
        }

        // Beneficiary Score
        if ($totalBeneficiaries <= 0) {
            $beneficiaryScore = 100.0;
        } else {
            $beneficiaryScore = ($totalBeneficiariesReached / $totalBeneficiaries) * 100.0;
        }

        // Field Evidence program score: average of activity scores
        if (empty($fieldEvidenceScores)) {
            $fieldEvidenceScore = 100.0;
        } else {
            $fieldEvidenceScore = array_sum($fieldEvidenceScores) / count($fieldEvidenceScores);
        }

        $finalScoreRaw = ($budgetScore * 0.25) + ($timelineScore * 0.20) + ($milestoneScore * 0.25) + ($beneficiaryScore * 0.15) + ($fieldEvidenceScore * 0.15);
        $finalScore = round(min(100.0, $finalScoreRaw), 2);

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
            'program_id' => $programId,
            'budget' => [
                'total_budget' => $totalBudget,
                'budget_used' => $totalBudgetUsed,
                'raw_percentage' => $budgetPct === null ? null : round($budgetPct, 2),
                'score' => round($budgetScore, 2),
            ],
            'timeline' => [
                'total_milestones' => $totalMilestones,
                'completed_on_time' => $totalCompletedOnTime,
                'score' => round($timelineScore, 2),
            ],
            'milestones' => [
                'total' => $totalMilestones,
                'completed' => $totalCompletedMilestones,
                'score' => round($milestoneScore, 2),
            ],
            'beneficiaries' => [
                'target' => $totalBeneficiaries,
                'reached' => $totalBeneficiariesReached,
                'score' => round($beneficiaryScore, 2),
            ],
            'field_evidence' => [
                'score' => round($fieldEvidenceScore, 2),
            ],
            'final' => [
                'raw' => round($finalScoreRaw, 2),
                'score' => $finalScore,
                'status' => $finalStatus,
            ],
            'activity_count' => count($activities),
        ];
    }

    public function deleteProgramById(int $programId)
    {
        try {
            $deleted = $this->programRepository->deleteProgram($programId);

            if (!$deleted) {
                return response()->json(['status' => 404, 'message' => 'Program not found or already deleted']);
            }

            return response()->json(['status' => 200, 'message' => 'Program deleted successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while deleting program']);
        }
    }

    private function setProgramDao(ProgramBo $programBo): ProgramDao
    {
        $programDao = new ProgramDao();
        $programDao->setNgoId(app('current_ngo_id') ?? 0);
        $programDao->setTitle($programBo->getTitle());
        $programDao->setDescription($programBo->getDescription());
        $programDao->setStartDate($programBo->getStartDate());
        $programDao->setEndDate($programBo->getEndDate());
        // Map authenticated user to `members.id` (assigned_by references members)
        $member = \App\Models\User::where('id', \Illuminate\Support\Facades\Auth::id())
            ->first();

        if ($member) {
            $programDao->setAssignedBy($member->id);
        }
        $programDao->setCreatedAt(now());
        $programDao->setUpdatedAt(now());

        return $programDao;
    }

    private function addProgramMembers(ProgramBo $programBo, int $programId)
    {
        $this->addProgramLeader($programBo, $programId);

        foreach ($programBo->getMemberIds() as $memberId) {

            $programMembersDao = new ProgramMembersDao();
            $programMembersDao->setProgramId($programId);
            $programMembersDao->setMemberIds($memberId);
            $programMembersDao->setRole(CommonConstants::PROGRAM_MEMBER_ROLE);

            $this->programMembersRepository->addProgramMembers($programMembersDao);
        }
    }

    private function addProgramLeader(ProgramBo $programBo, int $programId)
    {
        foreach ($programBo->getLeaderIds() as $leaderId) {
            $programMembersDao = new ProgramMembersDao();
            $programMembersDao->setProgramId($programId);
            $programMembersDao->setMemberIds($leaderId);
            $programMembersDao->setRole(CommonConstants::PROGRAM_LEADER_ROLE);

            $this->programMembersRepository->addProgramMembers($programMembersDao);
        }
    }
}
