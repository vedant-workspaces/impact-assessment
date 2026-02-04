<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Member;
use App\Repositories\Dao\V1\MemberDao;
use App\Repositories\V1\MemberRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MemberRepositoryImpl implements MemberRepository
{
    public function createMember(MemberDao $memberDao): bool
    {
        $currentDate = Carbon::now();
        $memberDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $memberDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        Member::create($memberDao->toArray());

        return true;
    }

    public function getActiveMembers(int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        // Eager load the user relation if you want login/email details
        $ngoId = app('current_ngo_id') ?? 0;

        $query = Member::where('status', 1)
            ->where('ngo_id', $ngoId);

        // Use the paginator with page override
        return $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
}

