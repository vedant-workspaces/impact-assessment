<?php

namespace App\Repositories\Postgres\V1;

use App\Models\Sdg;
use App\Repositories\V1\SdgRepository;
use Illuminate\Database\Eloquent\Collection;

class SdgRepositoryImpl implements SdgRepository
{
    public function fetchSdgs(): Collection
    {
        return Sdg::select('id', 'sdg_name')
            ->where('is_deleted', 0)
            ->get();
    }
}