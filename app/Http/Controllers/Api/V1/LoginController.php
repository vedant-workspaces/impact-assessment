<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Services\Bo\V1\LoginBo;
use App\Services\V1\LoginService;
use App\Traits\V1\ApiResponseTrait;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    Use ApiResponseTrait;

    public function __construct(
        private LoginService $loginService
    ) {}

    public function login(LoginRequest $request)
    {
        $bo = new LoginBo();
        $bo->setEmail($request->input('email'));
        $bo->setPassword($request->input('password'));

        return response()->json(
            $this->loginService->login($bo)
        );
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();

            return $this->success([
                'token' => $newToken
            ], "Token refreshed");

        } catch (Exception) {
            return $this->error("Token refresh failed", 401);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->success([], "Logged out successfully");
        } catch (Exception) {
            return $this->error("Failed to logout", 500);
        }
    }
}
