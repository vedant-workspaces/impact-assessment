<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\RegisterUserDao;

interface UserRepository
{
    public function insert(RegisterUserDao $registerUserDao): int;

    public function findByEmail(string $email);

    public function findByUserName(string $userName);
}