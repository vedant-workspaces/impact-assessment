<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        try {
            // Validate token
            $user = JWTAuth::parseToken()->authenticate();
            $request->auth_user = $user;

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Unauthorized: Invalid or missing token',
            ], 401);
        }

        return $next($request);
    }
}
