<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddSurveyRequest;
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
        $surveyBo->setStartDate($data['start_date'] ?? null);
        $surveyBo->setEndDate($data['end_date'] ?? null);
        $surveyBo->setProgramId($data['program_id']);
        $surveyBo->setLeaderId($data['leader_id']);
        $surveyBo->setMemberIds($data['member_ids']);

        return $this->surveyService->create($surveyBo);
    }
}
