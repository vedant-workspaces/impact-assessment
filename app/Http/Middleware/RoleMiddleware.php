<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->auth_user;

        if (!$user || (int)$user->user_type !== (int)$role) {
            return new JsonResponse([
                'success' => false,
                'message' => "Access denied: Only {$role} users allowed."
            ], 403);
        }

        return $next($request);
    }
}
