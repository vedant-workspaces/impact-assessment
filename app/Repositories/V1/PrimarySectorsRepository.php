<?php

namespace App\Repositories\V1;

use Illuminate\Database\Eloquent\Collection;

interface PrimarySectorsRepository
{
    public function fetchPrimarySectors(): Collection;
}