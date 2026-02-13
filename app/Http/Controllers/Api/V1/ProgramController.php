<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddProgramRequest;
use App\Services\Bo\V1\ProgramBo;
use App\Services\V1\ProgramService;
use App\Traits\V1\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ProgramController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private ProgramService $programService
    ) {}

    public function add(AddProgramRequest $addProgramRequest): JsonResponse
    {
        // Get validated data (this ALWAYS works for JSON)
        $data = $addProgramRequest->validated();

        // Map to Business Object
        $programBo = new ProgramBo();
        $programBo->setTitle($data['title']);
        $programBo->setDescription($data['description'] ?? null);
        $programBo->setStartDate($data['start_date'] ?? null);
        $programBo->setEndDate($data['end_date'] ?? null);
        $programBo->setLeaderIds($data['leader_ids']);
        $programBo->setMemberIds($data['member_ids']);

        return $this->programService->create($programBo);
    }

    public function getProgramNames(): JsonResponse
    {
        try {
            $data = $this->programService->getProgramNamesData();

            return $this->success($data, "Programs retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve programs");
        }
    }

    public function getProgramsWithMembers(): JsonResponse
    {
        try {
            $data = $this->programService->getProgramsWithMembersData();

            return $this->success($data, "Programs with members retrieved successfully");
        } catch (\Exception) {
            return $this->error("Failed to retrieve programs with members");
        }
    }
}
