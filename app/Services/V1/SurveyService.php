<?php

namespace App\Services\V1;

use App\Constants\CommonConstants;
use App\Repositories\Dao\V1\SurveyDao;
use App\Repositories\Dao\V1\SurveyMembersDao;
use App\Repositories\V1\SurveyMembersRepository;
use App\Repositories\V1\SurveyRepository;
use App\Services\Bo\V1\SurveyBo;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyQuestion;

class SurveyService
{
    public function __construct(
        private SurveyRepository $surveyRepository,
        private SurveyMembersRepository $surveyMembersRepository
    ) {}

    public function create(SurveyBo $surveyBo)
    {
        try {
            $surveyDao = $this->setSurveyDao($surveyBo);

            if (empty($surveyDao->getAssignedBy()) || intval($surveyDao->getAssignedBy()) <= 0) {
                return response()->json(['status' => 400, 'message' => 'Current user is not registered as a member. Please create a member profile before creating a survey.']);
            }

            $surveyId = $this->surveyRepository->createSurvey($surveyDao);

            $this->addSurveyMembers($surveyBo, $surveyId);

            $this->addSurveyQuestions($surveyBo, $surveyId);

            return response()->json(['status' => 200, 'message' => 'Survey added successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while adding survey']);
        }
    }

    public function getSurveyNamesData(): array
    {
        return $this->surveyRepository->getSurveyNames();
    }

    public function getSurveysWithMembersData(?int $programId = null): array
    {
        return $this->surveyRepository->getSurveysWithMembers($programId);
    }

    public function getSurveyDetailsData(int $surveyId): array
    {
        return $this->surveyRepository->getSurveyDetails($surveyId);
    }

    public function edit(SurveyBo $surveyBo, int $surveyId)
    {
        try {
            $surveyDao = new \App\Repositories\Dao\V1\SurveyDao();
            $surveyDao->setNgoId(app('current_ngo_id') ?? 0);
            $surveyDao->setTitle($surveyBo->getTitle());
            $surveyDao->setDescription($surveyBo->getDescription() ?? null);
            $surveyDao->setStartDate($surveyBo->getStartDate());
            $surveyDao->setEndDate($surveyBo->getEndDate());
            // Map authenticated user to `members.id` (assigned_by references members)
            $member = \App\Models\Member::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('is_deleted', 0)
                ->where('ngo_id', app('current_ngo_id') ?? 0)
                ->first();

            if (!$member) {
                return response()->json(['status' => 400, 'message' => 'Current user is not registered as a member. Please create a member profile before updating a survey.']);
            }

            $surveyDao->setAssignedBy($member->id);
            $surveyDao->setUpdatedAt(now());

            $updated = $this->surveyRepository->updateSurvey($surveyId, $surveyDao, $surveyBo->getLeaderIds(), $surveyBo->getMemberIds(), $surveyBo->getQuestions());

            if (!$updated) {
                return response()->json(['status' => 404, 'message' => 'Survey not found or not editable']);
            }

            return response()->json(['status' => 200, 'message' => 'Survey updated successfully']);
        } catch (Exception $e) {
            dd($e->getMessage());
            return response()->json(['status' => 400, 'message' => 'Error occurred while updating survey']);
        }
    }

    public function deleteSurveyById(int $surveyId)
    {
        try {
            $deleted = $this->surveyRepository->deleteSurvey($surveyId);

            if (!$deleted) {
                return response()->json(['status' => 404, 'message' => 'Survey not found or already deleted']);
            }

            return response()->json(['status' => 200, 'message' => 'Survey deleted successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while deleting survey']);
        }
    }

    private function setSurveyDao(SurveyBo $surveyBo): SurveyDao
    {
        $surveyDao = new SurveyDao();
        $surveyDao->setNgoId(app('current_ngo_id') ?? 0);
        $surveyDao->setTitle($surveyBo->getTitle());
        $surveyDao->setDescription($surveyBo->getDescription() ?? null);
        $surveyDao->setStartDate($surveyBo->getStartDate());
        $surveyDao->setEndDate($surveyBo->getEndDate());
        $surveyDao->setProgramId($surveyBo->getProgramId());
        // Map authenticated user to `members.id` (assigned_by references members)
        $member = \App\Models\Member::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('is_deleted', 0)
            ->where('ngo_id', app('current_ngo_id') ?? 0)
            ->first();

        if ($member) {
            $surveyDao->setAssignedBy($member->id);
        }
        $surveyDao->setCreatedAt(now());
        $surveyDao->setUpdatedAt(now());

        return $surveyDao;
    }

    private function addSurveyQuestions(SurveyBo $surveyBo, int $surveyId)
    {
        $questions = $surveyBo->getQuestions();
        if (empty($questions) || !is_array($questions)) {
            return;
        }

        foreach ($questions as $q) {
            $options = $q['options'] ?? null;

            SurveyQuestion::create([
                'survey_id' => $surveyId,
                'question_title' => $q['label'] ?? '',
                'language' => 'english',
                'options' => $options ?? null,
                'is_required' => isset($q['required']) && ($q['required'] === true || $q['required'] == 1) ? 1 : 0,
                'order' => $q['order'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
                'is_deleted' => 0,
            ]);
        }
    }

    private function addSurveyMembers(SurveyBo $surveyBo, int $surveyId)
    {
        $this->addSurveyLeader($surveyBo, $surveyId);

        foreach ($surveyBo->getMemberIds() as $memberId) {

            $surveyMembersDao = new SurveyMembersDao();
            $surveyMembersDao->setSurveyId($surveyId);
            $surveyMembersDao->setMemberIds($memberId);
            $surveyMembersDao->setRole(CommonConstants::PROGRAM_MEMBER_ROLE);

            $this->surveyMembersRepository->addSurveyMembers($surveyMembersDao);
        }
    }

    private function addSurveyLeader(SurveyBo $surveyBo, int $surveyId)
    {
        foreach ($surveyBo->getLeaderIds() as $leaderId) {
            $surveyMembersDao = new SurveyMembersDao();
            $surveyMembersDao->setSurveyId($surveyId);
            $surveyMembersDao->setMemberIds($leaderId);
            $surveyMembersDao->setRole(CommonConstants::PROGRAM_LEADER_ROLE);

            $this->surveyMembersRepository->addSurveyMembers($surveyMembersDao);
        }
    }
}
