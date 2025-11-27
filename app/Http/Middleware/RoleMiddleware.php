<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // kalau belum login atau rolenya tidak ada di daftar yang diperbolehkan
        if (! $user || ! in_array($user->role, $roles)) {
            abort(403); // atau bisa redirect('login') dsb
        }

        return $next($request);
    }
}
