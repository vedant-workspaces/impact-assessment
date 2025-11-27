<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\SdgsService;
use App\Traits\V1\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class SdgsController extends Controller
{
    Use ApiResponseTrait;

    public function getSdgs(): JsonResponse
    {
        try {
            $sdgsService = app(SdgsService::class);

            $data = $sdgsService->getSdgsData();

            return $this->success($data, "SDGs retrieved successfully");
        } catch (Exception) {
            return $this->error("Failed to retrieve SDGs");
        }
    }
}