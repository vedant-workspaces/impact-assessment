<?php

namespace App\Services\V1;

use App\Mail\MemberRegisteredMail;
use App\Repositories\Dao\V1\MemberDao;
use App\Repositories\Dao\V1\RegisterUserDao;
use App\Repositories\V1\MemberRepository;
use App\Repositories\V1\UserRepository;
use App\Services\Bo\V1\MemberBo;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Constants\UserTypes;

class MemberService
{
    public function __construct(
        private MemberRepository $memberRepository
    ) {}

    public function create(MemberBo $memberBo): JsonResponse
    {
        try {
            // Step 1: Validate data
            // Check if email already exists
            if (app(UserRepository::class)->findByEmail($memberBo->getOfficialEmail())) {
                return response()->json(['status' => 409, 'message' => 'Email already exists']);
            }

            // Check if username already exists
            if (app(UserRepository::class)->findByUserName($memberBo->getUserName())) {
                return response()->json(['status' => 409, 'message' => 'Username already exists']);
            }

            // Authorization: ensure the authenticated user can create the requested role
            $authUser = Auth::user();
            if (! $authUser) {
                return response()->json(['status' => 403, 'message' => 'Authentication required']);
            }

            $creatorType = (int) ($authUser->user_type ?? 0);
            // The incoming `access_level` is now the identity of the member
            $targetType = (int) $memberBo->getAccessLevel();

            if ($creatorType === UserTypes::SUPER_ADMIN) {
                // full permissions
            } elseif ($creatorType === UserTypes::PROJECT_MANAGER) {
                // Project Managers can only create Supervisors and Field Executives
                if (! in_array($targetType, [UserTypes::SUPERVISOR, UserTypes::FIELD_EXECUTIVE], true)) {
                    return response()->json(['status' => 403, 'message' => 'Project Managers can only create Supervisors and Field Executives']);
                }
            } elseif ($creatorType === UserTypes::SUPERVISOR) {
                // Supervisors can only create Field Executives
                if ($targetType !== UserTypes::FIELD_EXECUTIVE) {
                    return response()->json(['status' => 403, 'message' => 'Supervisors can only create Field Executives']);
                }
            } else {
                return response()->json(['status' => 403, 'message' => 'Insufficient privileges to create member']);
            }
    
            // STEP 2: Set register user dao
            $registerUserDao = $this->setRegisterUserDao($memberBo);
            $userId = app(UserRepository::class)->insert($registerUserDao);
    
            // STEP 3: Map to MemberDao
            $memberDao = $this->setMemberDao($memberBo, $userId);
    
            // STEP 4: Store inside members table
            $this->memberRepository->createMember($memberDao);
    
            // STEP 5: Send confirmation email
            Mail::to($memberBo->getOfficialEmail())
                ->send(new MemberRegisteredMail($memberBo->getFullName(), $memberBo->getUserName())
            );
    
            // STEP 6: Return success response
            return response()->json(['status' => 200, 'message' => 'Member registered successfully']);
        } catch (Exception) {
            return response()->json(['status' => 400, 'message' => 'Error occurred while registering member']);
        }
    }

    private function setRegisterUserDao(MemberBo $memberBo): RegisterUserDao
    {
        $registerUserDao = app(RegisterUserDao::class);
        $registerUserDao->setEmail($memberBo->getOfficialEmail());
        $registerUserDao->setUserName($memberBo->getUserName());
        $registerUserDao->setPassword($memberBo->getPassword());
        // Use the selected `access_level` as the user's user_type (identity)
        $registerUserDao->setUserType($memberBo->getAccessLevel());

        // Associate member user with current NGO
        $registerUserDao->setNgoId(app('current_ngo_id') ?? 0);

        return $registerUserDao;
    }

    private function setMemberDao(MemberBo $memberBo, int $userId): MemberDao
    {
        $memberDao = new MemberDao();
        $memberDao->setNgoId(app('current_ngo_id') ?? 0);
        $memberDao->setUserId($userId);
        $memberDao->setFullName($memberBo->getFullName());
        $memberDao->setGender($memberBo->getGender());
        $memberDao->setDesignation($memberBo->getDesignation());
        $memberDao->setDepartment($memberBo->getDepartment());
        $memberDao->setContactNumber($memberBo->getContactNumber());
        $memberDao->setOfficialEmail($memberBo->getOfficialEmail());
        // `role_type` column removed; store only access level as the member identity
        $memberDao->setAccessLevel($memberBo->getAccessLevel());
        $memberDao->setAccessLevel($memberBo->getAccessLevel());
        $memberDao->setStatus($memberBo->getStatus());
        $memberDao->setAssignedBy(Auth::id());

        return $memberDao;
    }

    public function getActiveMembers(int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->memberRepository->getActiveMembers($perPage, $page);
    }
}
