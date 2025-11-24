<?php

namespace App\Repositories\Postgres\V1;

use App\Models\PrimarySector;
use App\Repositories\V1\PrimarySectorRepository;
use Illuminate\Database\Eloquent\Collection;

class PrimarySectorRepositoryImpl implements PrimarySectorRepository
{
    public function fetchPrimarySectors(): Collection
    {
        return PrimarySector::select('id', 'primary_sector_name')
            ->where('is_deleted', 0)
            ->get();
    }
}