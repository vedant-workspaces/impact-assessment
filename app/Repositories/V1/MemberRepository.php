<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\MemberDao;

interface MemberRepository
{
    public function createMember(MemberDao $dao): bool;
}