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
        $ngoId = app('current_ngo_id') ?? 0;
        $programs = Program::select('id', 'title')
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->get();

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
        $ngoId = app('current_ngo_id') ?? 0;

        $programs = Program::where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'programMembers.member:id,full_name'
            ])
            ->get(['id', 'title', 'description', 'start_date', 'end_date', 'assigned_by']);

        return $programs->map(function ($program) {
            $leaderIds = collect($program->programMembers)->filter(function($pm){ return intval($pm->role) === 1; })->map(function($pm){ return $pm->member_id; })->values()->toArray();
            return [
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'start_date' => $program->start_date?->toDateString(),
                'end_date' => $program->end_date?->toDateString(),
                'assigned_by' => $program->assignedBy?->full_name ?? null,
                'leader_ids' => $leaderIds,
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

    public function deleteProgram(int $programId): bool
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $program = Program::where('id', $programId)
            ->where('ngo_id', $ngoId)
            ->where('is_deleted', 0)
            ->first();

        if (!$program) {
            return false;
        }

        $program->is_deleted = 1;
        $program->updated_at = now();

        return $program->save();
    }

    public function getProgramDetails(int $programId): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $program = Program::where('id', $programId)
            ->where('ngo_id', $ngoId)
            ->where('is_deleted', 0)
            ->with(['assignedBy:id,full_name', 'programMembers.member:id,full_name'])
            ->first(['id', 'title', 'description', 'start_date', 'end_date', 'assigned_by']);

        if (!$program) {
            return [];
        }

        $leaders = collect($program->programMembers)->filter(function($pm){ return intval($pm->role) === 1; })->map(function($pm){
            return [
                'member_id' => $pm->member_id,
                'full_name' => $pm->member?->full_name ?? null,
                'role' => 'Leader'
            ];
        })->values()->toArray();

        $leaderIds = collect($program->programMembers)->filter(function($pm){ return intval($pm->role) === 1; })->map(function($pm){ return $pm->member_id; })->values()->toArray();

        $members = collect($program->programMembers)->map(function($pm){
            return [
                'member_id' => $pm->member_id,
                'full_name' => $pm->member?->full_name ?? null,
                'role' => intval($pm->role) === 1 ? 'Leader' : (intval($pm->role) === 2 ? 'Member' : null)
            ];
        })->values()->toArray();

        $memberIds = collect($program->programMembers)->map(function($pm){ return $pm->member_id; })->values()->toArray();

        return [
            'id' => $program->id,
            'title' => $program->title,
            'description' => $program->description ?? null,
            'start_date' => $program->start_date?->toDateString(),
            'end_date' => $program->end_date?->toDateString(),
            'assigned_by' => $program->assignedBy?->full_name ?? null,
            'leader_ids' => $leaderIds,
            'member_ids' => $memberIds,
            'leaders' => $leaders,
            'members' => $members,
        ];
    }

    public function updateProgram(int $programId, \App\Repositories\Dao\V1\ProgramDao $programDao, array $leaderIds, array $memberIds): bool
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $program = Program::where('id', $programId)
            ->where('ngo_id', $ngoId)
            ->where('is_deleted', 0)
            ->first();

        if (!$program) {
            return false;
        }

        $data = $programDao->toArray();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $program->{$k} = $v;
            }
        }
        $program->updated_at = now();
        $program->save();

        // Soft-delete existing program members
        \App\Models\ProgramMember::where('program_id', $programId)
            ->where('is_deleted', 0)
            ->update(['is_deleted' => 1, 'updated_at' => now()]);

        // Re-create leaders
        foreach ($leaderIds as $lid) {
            \App\Models\ProgramMember::create([
                'program_id' => $programId,
                'member_id' => $lid,
                'role' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_deleted' => 0,
            ]);
        }

        // Re-create members
        foreach ($memberIds as $mid) {
            \App\Models\ProgramMember::create([
                'program_id' => $programId,
                'member_id' => $mid,
                'role' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'is_deleted' => 0,
            ]);
        }

        return true;
    }
}