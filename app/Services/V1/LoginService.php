<?php

namespace App\Services\V1;

use App\Models\User;
use App\Models\Member;
use App\Repositories\V1\UserRepository;
use App\Services\Bo\V1\LoginBo;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function login(LoginBo $bo): array
    {
        $user = $this->userRepository->findByEmail($bo->getEmail());

        if (!$user || md5($bo->getPassword()) !== $user->password) {
            return [
                'success' => false,
                'message' => 'Invalid login credentials',
            ];
        }

        $token = JWTAuth::fromUser(User::find($user->id));

        // Determine access_level: prefer member.access_level, fallback to users.user_type
        $member = Member::where('user_id', $user->id)->first();
        $accessLevel = $member->access_level ?? $user->user_type ?? null;

        return [
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'access_level' => $accessLevel,
            ]
        ];
    }
}
