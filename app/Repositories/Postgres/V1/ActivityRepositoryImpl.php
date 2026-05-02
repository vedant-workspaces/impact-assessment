<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Activity;
use App\Repositories\Dao\V1\ActivityDao;
use App\Repositories\V1\ActivityRepository;

class ActivityRepositoryImpl implements ActivityRepository
{
    public function createActivity(ActivityDao $activityDao): int
    {
        $activity = Activity::create($activityDao->toArray());
        return $activity->id;
    }

    public function getActivityNames(): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $activities = Activity::select('id', 'name')
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->get();

        return $activities->map(function ($a) {
            return [
                'id' => $a->id,
                'name' => $a->name,
                'activity_completion' => 100,
            ];
        })->toArray();
    }

    public function getActivitiesWithMembers(?int $programId = null): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $query = Activity::where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'members.member:id,full_name'
            ])
            ->withCount(['milestones' => function ($q) {
                $q->where('is_deleted', 0);
            }]);

        // If programId is null or 0, treat as 'standalone' activities.
        // Return activities where program_id is NULL or 0 in that case.
        if (is_null($programId) || intval($programId) === 0) {
            $query->where(function ($q) {
                $q->whereNull('program_id')->orWhere('program_id', 0);
            });
        } else {
            $query->where('program_id', $programId);
        }

        $activities = $query->get(['id', 'name', 'start_date', 'end_date', 'assigned_by', 'program_id', 'total_budget', 'budget_used', 'total_beneficiaries', 'beneficiaries_reached', 'is_media_uploads', 'media_status', 'media_link']);

        return $activities->map(function ($activity) {
            $leaders = collect($activity->members)->filter(function ($am) {
                return intval($am->role) === 1;
            })->map(function ($am) {
                return [
                    'member_id' => $am->member_id,
                    'full_name' => $am->member?->full_name ?? null,
                    'role' => 'Leader'
                ];
            })->values()->toArray();

            return [
                'id' => $activity->id,
                'name' => $activity->name,
                'description' => $activity->description ?? null,
                'start_date' => $activity->start_date?->toDateString(),
                'end_date' => $activity->end_date?->toDateString(),
                'assigned_by' => $activity->assignedBy?->full_name ?? null,
                'leaders' => $leaders,
                'activity_completion' => 100,
                'program_id' => $activity->program_id ?? null,
                'milestone_count' => $activity->milestones_count ?? 0,
                'total_budget' => floatval($activity->total_budget ?? 0),
                'budget_used' => floatval($activity->budget_used ?? 0),
                'total_beneficiaries' => intval($activity->total_beneficiaries ?? 0),
                'beneficiaries_reached' => intval($activity->beneficiaries_reached ?? 0),
                'is_media_uploads' => intval($activity->is_media_uploads ?? 0),
                'media_status' => intval($activity->media_status ?? 2),
                'media_link' => $activity->media_link ?? null,
                'members' => collect($activity->members)
                    ->filter(function ($am) {
                        return intval($am->role) !== 1;
                    })
                    ->map(function ($am) {
                        $roleInt = intval($am->role);
                        $roleLabel = $roleInt === 2 ? 'Member' : null;

                        return [
                            'member_id' => $am->member_id,
                            'full_name' => $am->member?->full_name ?? null,
                            'role' => $roleLabel
                        ];
                    })->values()->toArray()
            ];
        })->toArray();
    }

    public function getActivityDetails(int $activityId): array
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $activity = Activity::where('id', $activityId)
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->with([
                'assignedBy:id,full_name',
                'members.member:id,full_name',
                'milestones' => function ($q) {
                    $q->where('is_deleted', 0)->orderBy('start_date');
                }
            ])
            ->withCount(['milestones' => function ($q) {
                $q->where('is_deleted', 0);
            }])
            ->first(['id', 'name', 'description', 'start_date', 'end_date', 'assigned_by', 'program_id', 'total_budget', 'budget_used', 'total_beneficiaries', 'beneficiaries_reached', 'is_media_uploads', 'media_status', 'media_link']);

        if (!$activity) {
            return [];
        }

        $leaders = collect($activity->members)->filter(function ($am) {
            return intval($am->role) === 1;
        })->map(function ($am) {
            return [
                'member_id' => $am->member_id,
                'full_name' => $am->member?->full_name ?? null,
                'role' => 'Leader'
            ];
        })->values()->toArray();

        $members = collect($activity->members)
            ->filter(function ($am) {
                return intval($am->role) !== 1;
            })
            ->map(function ($am) {
                $roleInt = intval($am->role);
                $roleLabel = $roleInt === 2 ? 'Member' : null;

                return [
                    'member_id' => $am->member_id,
                    'full_name' => $am->member?->full_name ?? null,
                    'role' => $roleLabel
                ];
            })->values()->toArray();

        $milestones = collect($activity->milestones)->map(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'start_date' => $m->start_date?->toDateString(),
                'end_date' => $m->end_date?->toDateString(),
                'status' => intval($m->milestone_status ?? 0),
            ];
        })->values()->toArray();

        return [
            'id' => $activity->id,
            'name' => $activity->name,
            'description' => $activity->description ?? null,
            'start_date' => $activity->start_date?->toDateString(),
            'end_date' => $activity->end_date?->toDateString(),
            'assigned_by' => $activity->assignedBy?->full_name ?? null,
            'leaders' => $leaders,
            'program_id' => $activity->program_id ?? null,
            'milestone_count' => $activity->milestones_count ?? 0,
            'members' => $members,
            'milestones' => $milestones,
            'total_budget' => floatval($activity->total_budget ?? 0),
            'budget_used' => floatval($activity->budget_used ?? 0),
            'total_beneficiaries' => intval($activity->total_beneficiaries ?? 0),
            'beneficiaries_reached' => intval($activity->beneficiaries_reached ?? 0),
            'is_media_uploads' => intval($activity->is_media_uploads ?? 0),
            'media_status' => intval($activity->media_status ?? 2),
            'media_link' => $activity->media_link ?? null,
        ];
    }

    public function updateActivityParams(int $activityId, array $params): bool
    {
        $ngoId = app('current_ngo_id') ?? 0;

        $activity = Activity::where('id', $activityId)
            ->where('is_deleted', 0)
            ->where('ngo_id', $ngoId)
            ->first();

        if (!$activity) {
            return false;
        }

        $allowed = ['budget_used', 'beneficiaries_reached', 'media_status', 'media_link'];
        foreach ($params as $k => $v) {
            if (in_array($k, $allowed, true)) {
                $activity->{$k} = $v;
            }
        }

        $activity->updated_at = now();
        $activity->save();

        return true;
    }
}
