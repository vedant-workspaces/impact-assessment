<?php

namespace App\Services\V1;

use App\Repositories\V1\PrimarySectorRepository;

class PrimarySectorService
{
    public function getPrimarySectorsData(): array
    {
        $primarySectors = app(PrimarySectorRepository::class)->fetchPrimarySectors();
        if ($primarySectors) {
            return $primarySectors->toArray();
        }
        return [];
    }
}