<?php

namespace App\Repositories\Postgres\V1;

use App\Models\ProgramMember;
use App\Repositories\Dao\V1\ProgramMembersDao;
use App\Repositories\V1\ProgramMembersRepository;
use Carbon\Carbon;

class ProgramMembersRepositoryImpl implements ProgramMembersRepository
{
    public function addProgramMembers(ProgramMembersDao $programMembersDao): bool
    {
        $currentDate = Carbon::now();
        $programMembersDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $programMembersDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        ProgramMember::create($programMembersDao->toArray());

        return true;
    }
}