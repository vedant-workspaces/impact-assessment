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
        private ProgramMembersRepository $programMembersRepository
    ) {}

    public function create(ProgramBo $programBo)
    {
        try {
            $programDao = $this->setProgramDao($programBo);
    
            $programId = $this->programRepository->createProgram($programDao);
    
            $this->addProgramMembers($programBo, $programId);
    
            return response()->json(['status' => 200, 'message' => 'Program added successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while adding program']);
        }
    }

    public function getProgramNamesData(): array
    {
        return $this->programRepository->getProgramNames();
    }

    private function setProgramDao(ProgramBo $programBo): ProgramDao
    {
        $programDao = new ProgramDao();
        $programDao->setTitle($programBo->getTitle());
        $programDao->setDescription($programBo->getDescription());
        $programDao->setStartDate($programBo->getStartDate());
        $programDao->setEndDate($programBo->getEndDate());
        $programDao->setAssignedBy(Auth::id());
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
        $programMembersDao = new ProgramMembersDao();
        $programMembersDao->setProgramId($programId);
        $programMembersDao->setMemberIds($programBo->getLeaderId());
        $programMembersDao->setRole(CommonConstants::PROGRAM_LEADER_ROLE);

        $this->programMembersRepository->addProgramMembers($programMembersDao);
    }
}
