<?php

namespace App\Services\V1;

use App\Repositories\V1\SdgRepository;

class SdgsService
{
    public function getSdgsData(): array
    {
        $sdgs = app(SdgRepository::class)->fetchSdgs();
        if ($sdgs) {
            return $sdgs->toArray();
        }
        return [];
    }
}