<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ProgramMembersDao;

interface ProgramMembersRepository
{
    public function addProgramMembers(ProgramMembersDao $programMembersDao): bool;
}