<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Users;
use App\Repositories\Dao\V1\RegisterUserDao;
use App\Repositories\V1\UsersRepository;
use Carbon\Carbon;

class UsersRepositoryImpl implements UsersRepository
{
    public function insert(RegisterUserDao $registerUserDao): int
    {
        $currentDate = Carbon::now();
        $registerUserDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $registerUserDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        $newRecord = Users::create($registerUserDao->toArray());

        return $newRecord->id;
    }
}