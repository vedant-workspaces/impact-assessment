<?php

namespace App\Repositories\V1;

use Illuminate\Database\Eloquent\Collection;

interface PrimarySectorRepository
{
    public function fetchPrimarySectors(): Collection;
}