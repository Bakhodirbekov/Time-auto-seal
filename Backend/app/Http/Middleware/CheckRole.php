<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        if ($request->user()->is_blocked) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your account has been blocked'], 403);
            }
            auth()->logout();
            return redirect()->route('login')->with('error', 'Sizning hisobingiz bloklangan.');
        }

        if (!in_array($request->user()->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Sizda bu bo\'limga kirish huquqi yo\'q.');
        }

        return $next($request);
    }
}
