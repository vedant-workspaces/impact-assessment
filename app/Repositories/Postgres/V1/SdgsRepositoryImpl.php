<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Sdgs;
use App\Repositories\V1\SdgsRepository;
use Illuminate\Database\Eloquent\Collection;

class SdgsRepositoryImpl implements SdgsRepository
{
    public function fetchSdgs(): Collection
    {
        return Sdgs::select('id', 'sdg_name')
            ->where('is_deleted', 0)
            ->get();
    }
}