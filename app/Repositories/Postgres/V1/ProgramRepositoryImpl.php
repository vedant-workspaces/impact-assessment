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
                'program_completion' => 100,
            ];
        })->toArray();
    }

    public function getProgramsWithMembers(): array
    {
        $programs = Program::where('is_deleted', 0)
            ->with([
                'assignedBy:id,full_name',
                'programMembers.member:id,full_name'
            ])
            ->get(['id', 'title', 'description', 'start_date', 'end_date', 'assigned_by']);

        return $programs->map(function ($program) {
            return [
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'start_date' => $program->start_date?->toDateString(),
                'end_date' => $program->end_date?->toDateString(),
                'assigned_by' => $program->assignedBy?->full_name ?? null,
                'program_completion' => 100,
                'no_of_surveys' => 0,
                'members' => collect($program->programMembers)->map(function ($pm) {
                    $roleInt = intval($pm->role);
                    $roleLabel = $roleInt === 1 ? 'Leader' : ($roleInt === 2 ? 'Member' : null);

                    return [
                        'member_id' => $pm->member_id,
                        'full_name' => $pm->member?->full_name ?? null,
                        'role' => $roleLabel
                    ];
                })->values()->toArray()
            ];
        })->toArray();
    }
}