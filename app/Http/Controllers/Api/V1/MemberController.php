<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddMemberRequest;
use App\Services\Bo\V1\MemberBo;
use App\Services\V1\MemberService;
use App\Traits\V1\ApiResponseTrait;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private MemberService $service) {}

    public function add(AddMemberRequest $addMemberRequest)
    {
        // Get validated data (this ALWAYS works for JSON)
        $data = $addMemberRequest->validated();

        // Map to Business Object
        $memberBo = new MemberBo();
        $memberBo->setFullName($data['full_name']);
        $memberBo->setGender($data['gender']);
        $memberBo->setDesignation($data['designation']);
        $memberBo->setDepartment($data['department']);
        $memberBo->setContactNumber($data['contact_number']);
        $memberBo->setOfficialEmail($data['official_email']);
        $memberBo->setUserName($data['username']);
        $memberBo->setPassword(md5($data['password']));
        $memberBo->setRoleType($data['role_type']);
        $memberBo->setAccessLevel($data['access_level']);
        $memberBo->setStatus($data['status']);

        return $this->service->create($memberBo);
    }

    public function get(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $page    = (int) $request->query('page', 1);

        $paginator = $this->service->getActiveMembers($perPage, $page);

        // Format response: data + meta
        $data = [
            'members' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ];

        return $this->success($data, 'Active members fetched successfully');
    }
}
