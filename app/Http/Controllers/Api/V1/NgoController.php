<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterNgoRequest;
use App\Services\Bo\V1\RegisterNgoBo;
use App\Services\V1\NgoService;
use Illuminate\Http\JsonResponse;

class NgoController extends Controller
{
    public function registerNgo(RegisterNgoRequest $registerNgoRequest): JsonResponse
    {
        $registerNgoBo = app(RegisterNgoBo::class);
        $registerNgoBo->setOrganisationEmail($registerNgoRequest->organisation_email);
        $registerNgoBo->setUserName($registerNgoRequest->user_name);
        $registerNgoBo->setPassword(md5($registerNgoRequest->confirm_password));
        $registerNgoBo->setOrganisationWebsite($registerNgoRequest->organisation_website);
        $registerNgoBo->setOrganisationName($registerNgoRequest->organisation_name);
        $registerNgoBo->setContactPersonName($registerNgoRequest->contact_person_name);
        $registerNgoBo->setContactPersonDesignation($registerNgoRequest->contact_person_designation);
        $registerNgoBo->setContactPersonNumber($registerNgoRequest->contact_person_number);
        $registerNgoBo->setOrganisationAddress($registerNgoRequest->organisation_address);
        $registerNgoBo->setOrganisationCity($registerNgoRequest->organisation_city);
        $registerNgoBo->setOrganisationState($registerNgoRequest->organisation_state);
        $registerNgoBo->setOrganisationPincode($registerNgoRequest->organisation_pincode);
        $registerNgoBo->setPrimarySector($registerNgoRequest->primary_sector);
        $registerNgoBo->setSdgs($registerNgoRequest->sdgs);
        $registerNgoBo->setPurpose($registerNgoRequest->purpose);

        $ngoService = app(NgoService::class);

        return response()->json($ngoService->registerNgo($registerNgoBo));
    }
}
