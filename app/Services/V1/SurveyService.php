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

            $surveyId = $this->surveyRepository->createSurvey($surveyDao);

            $this->addSurveyMembers($surveyBo, $surveyId);

            return response()->json(['status' => 200, 'message' => 'Survey added successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while adding survey']);
        }
    }

    public function getSurveyNamesData(): array
    {
        return $this->surveyRepository->getSurveyNames();
    }

    public function getSurveysWithMembersData(): array
    {
        return $this->surveyRepository->getSurveysWithMembers();
    }

    private function setSurveyDao(SurveyBo $surveyBo): SurveyDao
    {
        $surveyDao = new SurveyDao();
        $surveyDao->setNgoId(app('current_ngo_id') ?? 0);
        $surveyDao->setTitle($surveyBo->getTitle());
        $surveyDao->setStartDate($surveyBo->getStartDate());
        $surveyDao->setEndDate($surveyBo->getEndDate());
        $surveyDao->setProgramId($surveyBo->getProgramId());
        $surveyDao->setAssignedBy(Auth::id());
        $surveyDao->setCreatedAt(now());
        $surveyDao->setUpdatedAt(now());

        return $surveyDao;
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
        $surveyMembersDao = new SurveyMembersDao();
        $surveyMembersDao->setSurveyId($surveyId);
        $surveyMembersDao->setMemberIds($surveyBo->getLeaderId());
        $surveyMembersDao->setRole(CommonConstants::PROGRAM_LEADER_ROLE);

        $this->surveyMembersRepository->addSurveyMembers($surveyMembersDao);
    }
}
