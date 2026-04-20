<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle incoming request
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 🔐 cek login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 🔐 cek role
        if (!in_array(Auth::user()->role, $roles)) {

            // jika request API
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akses ditolak'
                ], 403);
            }

            // jika web
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}