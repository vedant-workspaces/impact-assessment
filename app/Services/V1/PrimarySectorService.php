<?php

namespace App\Services\V1;

use App\Repositories\V1\PrimarySectorsRepository;

class PrimarySectorService
{
    public function getPrimarySectorsData(): array
    {
        $primarySectors = app(PrimarySectorsRepository::class)->fetchPrimarySectors();
        if ($primarySectors) {
            return $primarySectors->toArray();
        }
        return [];
    }
}