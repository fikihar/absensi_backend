<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = $request->user();
        //Log::info('CheckRole: User - ' . ($user ? json_encode($user) : 'No user'));
        //Log::info('CheckRole: User Role - ' . ($user ? $user->role : 'No role'));
        //Log::info('CheckRole: Required roles - ' . implode(', ', $roles));

        if (!$user || !in_array($user->role, $roles)) {
            Log::info('CheckRole: Authorization failed');
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
