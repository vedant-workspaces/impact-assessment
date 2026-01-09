<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Program;
use App\Repositories\Dao\V1\ProgramDao;
use App\Repositories\V1\ProgramRepository;

class ProgramRepositoryImpl implements ProgramRepository
{
    public function createProgram(ProgramDao $programDao): int
    {
        $program = Program::create($programDao->toArray());
        return $program->id;
    }
}