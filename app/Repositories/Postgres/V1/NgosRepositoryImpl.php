<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Ngos;
use App\Repositories\Dao\V1\RegisterNgoDao;
use App\Repositories\V1\NgosRepository;
use Carbon\Carbon;

class NgosRepositoryImpl implements NgosRepository
{
    public function insert(RegisterNgoDao $registerNgoDao)
    {
        $currentDate = Carbon::now();
        $registerNgoDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $registerNgoDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));

        Ngos::create($registerNgoDao->toArray());
    }
}