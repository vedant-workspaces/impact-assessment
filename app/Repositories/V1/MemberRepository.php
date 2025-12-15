<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\MemberDao;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MemberRepository
{
    public function createMember(MemberDao $dao): bool;

    public function getActiveMembers(int $perPage = 15, int $page = 1): LengthAwarePaginator;
}