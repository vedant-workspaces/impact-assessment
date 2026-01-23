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

    public function getProgramNames(): array
    {
        $programs = Program::select('id', 'title')->where('is_deleted', 0)->get();

        return $programs->map(function ($p) {
            return [
                'id' => $p->id,
                'title' => $p->title,
                'percentage' => 0
            ];
        })->toArray();
    }
}