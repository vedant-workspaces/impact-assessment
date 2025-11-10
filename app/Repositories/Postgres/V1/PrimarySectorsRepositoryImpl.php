<?php

namespace App\Repositories\Postgres\V1;

use App\Models\PrimarySectors;
use App\Repositories\V1\PrimarySectorsRepository;
use Illuminate\Database\Eloquent\Collection;

class PrimarySectorsRepositoryImpl implements PrimarySectorsRepository
{
    public function fetchPrimarySectors(): Collection
    {
        return PrimarySectors::select('id', 'primary_sector_name')
            ->where('is_deleted', 0)
            ->get();
    }
}