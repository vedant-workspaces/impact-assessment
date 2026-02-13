<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ProgramDao;

interface ProgramRepository
{
    public function createProgram(ProgramDao $programDao): int;

    public function getProgramNames(): array;

    public function getProgramsWithMembers(): array;

    public function deleteProgram(int $programId): bool;
}