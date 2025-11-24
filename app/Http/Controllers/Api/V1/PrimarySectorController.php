<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\PrimarySectorService;
use App\Traits\V1\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class PrimarySectorController extends Controller
{
    Use ApiResponseTrait;

    public function getPrimarySectors(): JsonResponse
    {
        try {
            $primarySectorService = app(PrimarySectorService::class);

            $data = $primarySectorService->getPrimarySectorsData();

            return $this->success($data, "Primary sectors retrieved successfully");

        } catch (Exception) {
            return $this->error("Failed to retrieve primary sectors");
        }
    }
}