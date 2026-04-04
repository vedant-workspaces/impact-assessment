<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Prefer the request-bound user (set by JWT middleware), fallback to Auth facade
        $user = $request->auth_user ?? Auth::user();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Access denied: authentication required.'
            ], 403);
        }

        // Support passing multiple allowed roles as a comma-separated list: e.g. middleware('role:2,3')
        $allowedRoles = array_map('intval', explode(',', (string) $role));

        if (!in_array((int) $user->user_type, $allowedRoles, true)) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Access denied: Only user role(s) ' . implode(',', $allowedRoles) . ' allowed.'
            ], 403);
        }

        return $next($request);
    }
}
