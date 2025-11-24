<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterNgoRequest;
use App\Services\Bo\V1\RegisterNgoBo;
use App\Services\V1\NgoService;
use App\Traits\V1\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class NgoController extends Controller
{
    Use ApiResponseTrait;

    public function registerNgo(RegisterNgoRequest $registerNgoRequest): JsonResponse
    {
        // Get validated data (this ALWAYS works for JSON)
        $data = $registerNgoRequest->validated();

        $registerNgoBo = app(RegisterNgoBo::class);
        $registerNgoBo->setOrganisationEmail($data['organisation_email']);
        $registerNgoBo->setUserName($data['user_name']);
        $registerNgoBo->setPassword(md5($data['confirm_password']));
        $registerNgoBo->setOrganisationWebsite($data['organisation_website'] ?? null);
        $registerNgoBo->setOrganisationName($data['organisation_name']);
        $registerNgoBo->setContactPersonName($data['contact_person_name']);
        $registerNgoBo->setContactPersonDesignation($data['contact_person_designation']);
        $registerNgoBo->setContactPersonNumber($data['contact_person_number']);
        $registerNgoBo->setOrganisationAddress($data['organisation_address']);
        $registerNgoBo->setOrganisationCity($data['organisation_city']);
        $registerNgoBo->setOrganisationState($data['organisation_state']);
        $registerNgoBo->setOrganisationPincode($data['organisation_pincode']);
        $registerNgoBo->setPrimarySector($data['primary_sector']);
        $registerNgoBo->setSdgs($data['sdgs']);
        $registerNgoBo->setPurpose($data['purpose'] ?? null);

        $ngoService = app(NgoService::class);

        $data = $ngoService->registerNgo($registerNgoBo);

        return $this->success($data, "NGO registered successfully");
    }
}
