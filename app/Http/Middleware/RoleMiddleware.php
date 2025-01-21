<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        Log::info('RoleMiddleware executed.');
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthenticated. Please provide a valid token.',
            ], 401);
        }
        
        // dd($role);
        if (!auth()->user()->hasRole($role)) {
            return response()->json([
                'message' => 'Unauthorized. You do not have the required role.',
            ], 403);
        }

        return $next($request);
    }
}
