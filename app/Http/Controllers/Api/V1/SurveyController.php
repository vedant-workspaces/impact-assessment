<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddSurveyRequest;
use Illuminate\Http\Request;
use App\Services\Bo\V1\SurveyBo;
use App\Services\V1\SurveyService;
use App\Traits\V1\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class SurveyController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private SurveyService $surveyService
    ) {}

    public function add(AddSurveyRequest $addSurveyRequest): JsonResponse
    {
        $data = $addSurveyRequest->validated();

        $surveyBo = new SurveyBo();
        $surveyBo->setTitle($data['title']);
        $surveyBo->setDescription($data['description'] ?? null);
        $surveyBo->setStartDate($data['start_date'] ?? null);
        $surveyBo->setEndDate($data['end_date'] ?? null);
        $surveyBo->setProgramId($data['program_id']);
        $surveyBo->setLeaderIds($data['leader_ids']);
        $surveyBo->setMemberIds($data['member_ids']);
        $surveyBo->setQuestions($data['questions'] ?? []);

        return $this->surveyService->create($surveyBo);
    }

    public function getSurveyNames(): JsonResponse
    {
        try {
            $data = $this->surveyService->getSurveyNamesData();

            return $this->success($data, "Surveys retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve surveys");
        }
    }

    public function getSurveysWithMembers(Request $request): JsonResponse
    {
        try {
            $programId = $request->input('program_id');

            if (is_null($programId) || $programId === '') {
                return $this->error('program_id is required', 422);
            }

            if (!is_numeric($programId)) {
                return $this->error('program_id must be an integer', 422);
            }

            $data = $this->surveyService->getSurveysWithMembersData((int) $programId);

            return $this->success($data, "Surveys with members retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve surveys with members");
        }
    }

    public function getDetails(Request $request): JsonResponse
    {
        try {
            $surveyId = $request->input('survey_id');

            if (is_null($surveyId) || $surveyId === '') {
                return $this->error('survey_id is required', 422);
            }

            if (!is_numeric($surveyId)) {
                return $this->error('survey_id must be an integer', 422);
            }

            $data = $this->surveyService->getSurveyDetailsData((int) $surveyId);

            return $this->success($data, 'Survey details retrieved successfully');
        } catch (\Exception) {
            return $this->error('Failed to retrieve survey questions');
        }
    }

        public function deleteSurvey(Request $request): JsonResponse
        {
            try {
                $surveyId = $request->input('survey_id');

                if (is_null($surveyId) || $surveyId === '') {
                    return $this->error('survey_id is required', 422);
                }

                if (!is_numeric($surveyId)) {
                    return $this->error('survey_id must be an integer', 422);
                }

                return $this->surveyService->deleteSurveyById((int) $surveyId);
            } catch (\Exception) {
                return $this->error('Failed to delete survey');
            }
        }
}
