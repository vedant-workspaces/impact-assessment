<?php

namespace App\Repositories\V1;

use Illuminate\Database\Eloquent\Collection;

interface SdgRepository
{
    public function fetchSdgs(): Collection;
}