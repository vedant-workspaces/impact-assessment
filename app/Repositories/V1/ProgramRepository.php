<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\ProgramDao;

interface ProgramRepository
{
    public function createProgram(ProgramDao $programDao): int;

    public function getProgramNames(): array;
}