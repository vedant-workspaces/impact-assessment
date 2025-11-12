<?php

namespace App\Repositories\V1;

use App\Models\Users;
use App\Repositories\Dao\V1\RegisterUserDao;

interface UsersRepository
{
    public function insert(RegisterUserDao $registerUserDao): int;
}