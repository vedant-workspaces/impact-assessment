<?php

namespace App\Repositories\Postgres\V1;

use App\Models\User;
use App\Repositories\Dao\V1\RegisterUserDao;
use App\Repositories\V1\UserRepository;
use Carbon\Carbon;

class UserRepositoryImpl implements UserRepository
{
    public function insert(RegisterUserDao $registerUserDao): int
    {
        $currentDate = Carbon::now();
        $registerUserDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $registerUserDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        $newRecord = User::create($registerUserDao->toArray());

        return $newRecord->id;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function findByUserName(string $userName)
    {
        return User::where('username', $userName)->first();
    }
}