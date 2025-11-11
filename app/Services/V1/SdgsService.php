<?php

namespace App\Services\V1;

use App\Repositories\V1\SdgsRepository;

class SdgsService
{
    public function getSdgsData(): array
    {
        $sdgs = app(SdgsRepository::class)->fetchSdgs();
        if ($sdgs) {
            return $sdgs->toArray();
        }
        return [];
    }
}