<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\SdgsService;
use Illuminate\Http\JsonResponse;

class SdgsController extends Controller
{
    public function getSdgs(): JsonResponse
    {
        try {
            $sdgsService = app(SdgsService::class);

            $data = $sdgsService->getSdgsData();

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