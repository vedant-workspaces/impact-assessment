<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\PrimarySectorService;
use Illuminate\Http\JsonResponse;

class PrimarySectorController extends Controller
{
    public function getPrimarySectors(): JsonResponse
    {
        try {
            $primarySectorService = app(PrimarySectorService::class);

            $data = $primarySectorService->getPrimarySectorsData();

            return response()->json([
                'data' => $data,
                'status_code' => 200
            ]);

        } catch (\Exception) {
            return response()->json([
                'data' => [],
                'status_code' => 500
            ]);
        }
    }
}