<?php

namespace App\Repositories\V1;

use Illuminate\Database\Eloquent\Collection;

interface SdgsRepository
{
    public function fetchSdgs(): Collection;
}