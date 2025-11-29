<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Member;
use App\Repositories\Dao\V1\MemberDao;
use App\Repositories\V1\MemberRepository;
use Carbon\Carbon;

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
}

