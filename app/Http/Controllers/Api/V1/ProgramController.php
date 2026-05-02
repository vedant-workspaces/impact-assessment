<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddProgramRequest;
use App\Http\Requests\V1\EditProgramRequest;
use App\Services\Bo\V1\ProgramBo;
use App\Services\V1\ProgramService;
use App\Traits\V1\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function edit(EditProgramRequest $editProgramRequest): JsonResponse
    {
        $data = $editProgramRequest->validated();

        $programBo = new ProgramBo();
        $programBo->setTitle($data['title']);
        $programBo->setDescription($data['description'] ?? null);
        $programBo->setStartDate($data['start_date'] ?? null);
        $programBo->setEndDate($data['end_date'] ?? null);
        $programBo->setLeaderIds($data['leader_ids']);
        $programBo->setMemberIds($data['member_ids']);

        return $this->programService->edit($programBo, (int) $data['program_id']);
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

    public function getDetails(Request $request): JsonResponse
    {
        try {
            $programId = $request->input('program_id');

            if (is_null($programId) || $programId === '') {
                return $this->error('program_id is required', 422);
            }

            if (!is_numeric($programId)) {
                return $this->error('program_id must be an integer', 422);
            }

            $data = $this->programService->getProgramDetailsData((int) $programId);

            return $this->success($data, 'Program details retrieved successfully');
        } catch (\Exception) {
            return $this->error('Failed to retrieve program details');
        }
    }

    public function deleteProgram(Request $request): JsonResponse
    {
        try {
            $programId = $request->input('program_id');

            if (is_null($programId) || $programId === '') {
                return $this->error('program_id is required', 422);
            }

            if (!is_numeric($programId)) {
                return $this->error('program_id must be an integer', 422);
            }

            return $this->programService->deleteProgramById((int) $programId);
        } catch (\Exception) {
            return $this->error('Failed to delete program');
        }
    }

    public function impactScore(\App\Http\Requests\V1\ProgramImpactRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $programId = array_key_exists('program_id', $data) ? $data['program_id'] : null;

            // if programId provided and >0, ensure program exists
            if (!is_null($programId) && intval($programId) > 0) {
                $exists = \App\Models\Program::where('id', intval($programId))
                    ->where('is_deleted', 0)
                    ->where('ngo_id', app('current_ngo_id') ?? 0)
                    ->exists();

                if (!$exists) {
                    return $this->error('Program not found', 404);
                }
            }

            $result = $this->programService->calculateProgramImpactData($programId);

            if (empty($result)) {
                return $this->error('No activities found for given program', 404);
            }

            return $this->success($result, 'Program impact score calculated');
        } catch (Exception) {
            return $this->error('Failed to calculate program impact');
        }
    }
}
