<?php

namespace App\Repositories\V1;

use App\Repositories\Dao\V1\RegisterNgoDao;

interface NgosRepository
{
    public function insert(RegisterNgoDao $registerNgoDao);
}