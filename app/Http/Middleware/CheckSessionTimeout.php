<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->role === 'siswa') {
            $lastActivity = $user->last_activity;
            $timeoutMinutes = 15;
            if ($lastActivity && now()->diffInMinutes($lastActivity) > $timeoutMinutes) {
                return response()->json(['message' => 'Session timed out'], 401);
            }
        }
        return $next($request);
    }
}
