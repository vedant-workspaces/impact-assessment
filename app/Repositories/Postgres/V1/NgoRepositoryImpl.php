<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Ngo;
use App\Repositories\Dao\V1\RegisterNgoDao;
use App\Repositories\V1\NgoRepository;
use Carbon\Carbon;

class NgoRepositoryImpl implements NgoRepository
{
    public function insert(RegisterNgoDao $registerNgoDao)
    {
        $currentDate = Carbon::now();
        $registerNgoDao->setCreatedAt($currentDate->format('Y-m-d H:i:s'));
        $registerNgoDao->setUpdatedAt($currentDate->format('Y-m-d H:i:s'));
        $ngo = Ngo::create($registerNgoDao->toArray());

        return $ngo->id;
    }
}